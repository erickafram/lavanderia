<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Empacotamento extends Model
{
    use HasFactory;

    protected $table = 'empacotamento';

    protected $fillable = [
        'coleta_id',
        'usuario_empacotamento_id',
        'motorista_id',
        'status_id',
        'codigo_qr',
        'data_empacotamento',
        'data_saida',
        'data_entrega',
        'data_confirmacao_recebimento',
        'assinatura_recebimento',
        'nome_recebedor',
        'observacoes_empacotamento',
        'observacoes_entrega'
    ];

    protected $casts = [
        'data_empacotamento' => 'datetime',
        'data_saida' => 'datetime',
        'data_entrega' => 'datetime',
        'data_confirmacao_recebimento' => 'datetime'
    ];

    /**
     * Relacionamento com coleta
     */
    public function coleta()
    {
        return $this->belongsTo(Coleta::class);
    }

    /**
     * Relacionamento com usuário que fez o empacotamento
     */
    public function usuarioEmpacotamento()
    {
        return $this->belongsTo(Usuario::class, 'usuario_empacotamento_id');
    }

    /**
     * Relacionamento com motorista
     */
    public function motorista()
    {
        return $this->belongsTo(Usuario::class, 'motorista_id');
    }

    /**
     * Relacionamento com status
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * Boot method para gerar código QR automaticamente
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($empacotamento) {
            if (!$empacotamento->codigo_qr) {
                do {
                    $codigo = 'EMP' . strtoupper(Str::random(8));
                } while (static::where('codigo_qr', $codigo)->exists());
                
                $empacotamento->codigo_qr = $codigo;
            }
        });
    }

    /**
     * Scope para empacotamentos por período
     */
    public function scopePorPeriodo($query, $dataInicio, $dataFim)
    {
        return $query->whereBetween('data_empacotamento', [$dataInicio, $dataFim]);
    }

    /**
     * Scope para empacotamentos por motorista
     */
    public function scopePorMotorista($query, $motoristaId)
    {
        return $query->where('motorista_id', $motoristaId);
    }

    /**
     * Scope para empacotamentos por status
     */
    public function scopePorStatus($query, $statusId)
    {
        return $query->where('status_id', $statusId);
    }

    /**
     * Verifica se o empacotamento pode ser entregue
     */
    public function podeSerEntregue()
    {
        return $this->status->nome === 'Pronto para entrega' || $this->status->nome === 'Em trânsito';
    }

    /**
     * Verifica se o empacotamento foi entregue
     */
    public function foiEntregue()
    {
        return $this->status->nome === 'Entregue';
    }

    /**
     * Gera URL do QR Code
     */
    public function getUrlQrCodeAttribute()
    {
        return route('qrcodes.rastrear', $this->codigo_qr);
    }
}
