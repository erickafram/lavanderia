<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pesagem extends Model
{
    use HasFactory;

    protected $table = 'pesagens';

    protected $fillable = [
        'coleta_id',
        'usuario_id',
        'tipo_id',
        'peso',
        'quantidade',
        'peso_unitario',
        'data_pesagem',
        'observacoes',
        'local_pesagem',
        'conferido',
        'usuario_conferencia_id',
        'data_conferencia'
    ];

    protected $casts = [
        'peso' => 'decimal:2',
        'peso_unitario' => 'decimal:2',
        'quantidade' => 'integer',
        'data_pesagem' => 'datetime',
        'data_conferencia' => 'datetime',
        'conferido' => 'boolean'
    ];

    /**
     * Relacionamento com coleta
     */
    public function coleta()
    {
        return $this->belongsTo(Coleta::class);
    }

    /**
     * Relacionamento com usuário responsável pela pesagem
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    /**
     * Relacionamento com usuário que conferiu a pesagem
     */
    public function usuarioConferencia()
    {
        return $this->belongsTo(Usuario::class, 'usuario_conferencia_id');
    }

    /**
     * Relacionamento com tipo de peça
     */
    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }

    /**
     * Boot method para calcular peso unitário automaticamente
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($pesagem) {
            // Calcular peso unitário se quantidade > 0
            if ($pesagem->quantidade > 0) {
                $pesagem->peso_unitario = $pesagem->peso / $pesagem->quantidade;
            }

            // Definir data de pesagem se não informada
            if (!$pesagem->data_pesagem) {
                $pesagem->data_pesagem = now();
            }
        });

        static::saved(function ($pesagem) {
            // Recalcular totais da coleta após salvar pesagem
            if ($pesagem->coleta && $pesagem->coleta->exists) {
                $pesagem->coleta->calcularTotais();
            }
        });

        static::deleted(function ($pesagem) {
            // Recalcular totais da coleta após excluir pesagem
            if ($pesagem->coleta && $pesagem->coleta->exists) {
                $pesagem->coleta->calcularTotais();
            }
        });
    }

    /**
     * Scope para pesagens conferidas
     */
    public function scopeConferidas($query)
    {
        return $query->where('conferido', true);
    }

    /**
     * Scope para pesagens não conferidas
     */
    public function scopeNaoConferidas($query)
    {
        return $query->where('conferido', false);
    }

    /**
     * Scope para pesagens por período
     */
    public function scopePorPeriodo($query, $dataInicio, $dataFim)
    {
        return $query->whereBetween('data_pesagem', [$dataInicio, $dataFim]);
    }

    /**
     * Scope para pesagens por coleta
     */
    public function scopePorColeta($query, $coletaId)
    {
        return $query->where('coleta_id', $coletaId);
    }

    /**
     * Scope para pesagens por tipo
     */
    public function scopePorTipo($query, $tipoId)
    {
        return $query->where('tipo_id', $tipoId);
    }

    /**
     * Scope para pesagens por usuário
     */
    public function scopePorUsuario($query, $usuarioId)
    {
        return $query->where('usuario_id', $usuarioId);
    }

    /**
     * Accessor para peso formatado
     */
    public function getPesoFormatadoAttribute()
    {
        return number_format($this->peso, 2, ',', '.') . ' kg';
    }

    /**
     * Accessor para peso unitário formatado
     */
    public function getPesoUnitarioFormatadoAttribute()
    {
        return $this->peso_unitario ? number_format($this->peso_unitario, 2, ',', '.') . ' kg' : '-';
    }

    /**
     * Accessor para data de pesagem formatada
     */
    public function getDataPesagemFormatadaAttribute()
    {
        return $this->data_pesagem ? $this->data_pesagem->format('d/m/Y H:i') : '-';
    }

    /**
     * Accessor para data de conferência formatada
     */
    public function getDataConferenciaFormatadaAttribute()
    {
        return $this->data_conferencia ? $this->data_conferencia->format('d/m/Y H:i') : '-';
    }

    /**
     * Método para conferir a pesagem
     */
    public function conferir($usuarioId)
    {
        $this->update([
            'conferido' => true,
            'usuario_conferencia_id' => $usuarioId,
            'data_conferencia' => now()
        ]);
    }

    /**
     * Método para desconferir a pesagem
     */
    public function desconferir()
    {
        $this->update([
            'conferido' => false,
            'usuario_conferencia_id' => null,
            'data_conferencia' => null
        ]);
    }

    /**
     * Verifica se a pesagem pode ser editada
     */
    public function podeSerEditada()
    {
        // Pesagem pode ser editada se não foi conferida ou se foi conferida há menos de 24h
        if (!$this->conferido) {
            return true;
        }

        if ($this->data_conferencia) {
            return $this->data_conferencia->diffInHours(now()) < 24;
        }

        return false;
    }

    /**
     * Calcula a diferença percentual entre peso esperado e pesado
     */
    public function calcularDiferencaPercentual($pesoEsperado)
    {
        if ($pesoEsperado <= 0) {
            return null;
        }

        return (($this->peso - $pesoEsperado) / $pesoEsperado) * 100;
    }
}
