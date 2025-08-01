<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coleta extends Model
{
    use HasFactory;

    protected $table = 'coletas';

    protected $fillable = [
        'estabelecimento_id',
        'usuario_id',
        'status_id',
        'data_agendamento',
        'data_coleta',
        'data_conclusao',
        'observacoes',
        'acompanhante',
        'motivo_cancelamento',
        'peso_total',
        'numero_coleta'
    ];

    protected $casts = [
        'data_agendamento' => 'datetime',
        'data_coleta' => 'datetime',
        'data_conclusao' => 'datetime',
        'peso_total' => 'decimal:2'
    ];

    /**
     * Relacionamento com estabelecimento
     */
    public function estabelecimento()
    {
        return $this->belongsTo(Estabelecimento::class);
    }

    /**
     * Relacionamento com usuário
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    /**
     * Relacionamento com status
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Relacionamento com peças da coleta
     */
    public function pecas()
    {
        return $this->hasMany(ColetaPeca::class);
    }

    /**
     * Relacionamento com empacotamento
     */
    public function empacotamento()
    {
        return $this->hasOne(Empacotamento::class);
    }

    /**
     * Relacionamento com pesagens
     */
    public function pesagens()
    {
        return $this->hasMany(Pesagem::class);
    }

    /**
     * Boot method para gerar número da coleta automaticamente
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($coleta) {
            if (!$coleta->numero_coleta) {
                $ultimaColeta = static::orderBy('id', 'desc')->first();
                $proximoNumero = $ultimaColeta ? (intval(substr($ultimaColeta->numero_coleta, 3)) + 1) : 1;
                $coleta->numero_coleta = 'COL' . str_pad($proximoNumero, 6, '0', STR_PAD_LEFT);
            }
        });

        // Remover o evento saved para evitar loop infinito
    }

    /**
     * Verifica se a coleta pode ser cancelada
     */
    public function podeSerCancelada()
    {
        return in_array($this->status->nome, ['Agendada', 'Em andamento']);
    }

    /**
     * Calcula os totais da coleta baseado nas peças
     */
    public function calcularTotais()
    {
        $pesoTotal = $this->pecas->sum('peso');

        // Usar updateQuietly para evitar disparar eventos e loop infinito
        $this->updateQuietly([
            'peso_total' => $pesoTotal,
        ]);
    }

    /**
     * Scope para coletas ativas (não canceladas)
     */
    public function scopeAtivas($query)
    {
        return $query->whereHas('status', function($q) {
            $q->where('nome', '!=', 'Cancelada');
        });
    }

    /**
     * Scope para coletas por período
     */
    public function scopePorPeriodo($query, $dataInicio, $dataFim)
    {
        return $query->whereBetween('data_agendamento', [$dataInicio, $dataFim]);
    }

    /**
     * Scope para coletas por estabelecimento
     */
    public function scopePorEstabelecimento($query, $estabelecimentoId)
    {
        return $query->where('estabelecimento_id', $estabelecimentoId);
    }

    /**
     * Scope para coletas por status
     */
    public function scopePorStatus($query, $statusId)
    {
        return $query->where('status_id', $statusId);
    }

    /**
     * Verifica se a coleta pode ser concluída
     */
    public function podeSerConcluida()
    {
        return $this->status->nome === 'Em andamento';
    }

    /**
     * Verifica se a coleta pode ter pesagens registradas
     */
    public function podeReceberPesagens()
    {
        return in_array($this->status->nome, ['Concluída', 'Em andamento']);
    }

    /**
     * Calcula o peso total das pesagens
     */
    public function pesoTotalPesagens()
    {
        return $this->pesagens->sum('peso');
    }

    /**
     * Verifica se a coleta já possui pesagem cadastrada
     */
    public function possuiPesagem()
    {
        return $this->pesagens()->exists();
    }

    /**
     * Scope para coletas sem pesagem
     */
    public function scopeSemPesagem($query)
    {
        return $query->whereDoesntHave('pesagens');
    }

    /**
     * Verifica se há diferença entre peso das peças e pesagens
     */
    public function temDiferencaPeso()
    {
        $pesoPecas = $this->peso_total;
        $pesoPesagens = $this->pesoTotalPesagens();

        return abs($pesoPecas - $pesoPesagens) > 0.01; // Tolerância de 10g
    }

    /**
     * Calcula a diferença percentual entre peso das peças e pesagens
     */
    public function diferencaPercentualPeso()
    {
        $pesoPecas = $this->peso_total;
        $pesoPesagens = $this->pesoTotalPesagens();

        if ($pesoPecas <= 0) {
            return null;
        }

        return (($pesoPesagens - $pesoPecas) / $pesoPecas) * 100;
    }
}
