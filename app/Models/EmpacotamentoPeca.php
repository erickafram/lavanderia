<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EmpacotamentoPeca extends Model
{
    use HasFactory;

    protected $table = 'empacotamento_pecas';

    protected $fillable = [
        'empacotamento_id',
        'tipo_id',
        'codigo_qr',
        'quantidade',
        'peso',
        'observacoes'
    ];

    /**
     * Relacionamento com empacotamento
     */
    public function empacotamento()
    {
        return $this->belongsTo(Empacotamento::class);
    }

    /**
     * Relacionamento com tipo de peça
     */
    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }

    /**
     * Boot method para gerar código QR automaticamente
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($empacotamentoPeca) {
            if (!$empacotamentoPeca->codigo_qr) {
                do {
                    $codigo = 'PC' . strtoupper(Str::random(8));
                } while (static::where('codigo_qr', $codigo)->exists());
                
                $empacotamentoPeca->codigo_qr = $codigo;
            }
        });
    }

    /**
     * Gera URL do QR Code
     */
    public function getUrlQrCodeAttribute()
    {
        return route('qrcodes.rastrear-peca', $this->codigo_qr);
    }

    /**
     * Scope para peças por empacotamento
     */
    public function scopePorEmpacotamento($query, $empacotamentoId)
    {
        return $query->where('empacotamento_id', $empacotamentoId);
    }

    /**
     * Scope para peças por tipo
     */
    public function scopePorTipo($query, $tipoId)
    {
        return $query->where('tipo_id', $tipoId);
    }
}
