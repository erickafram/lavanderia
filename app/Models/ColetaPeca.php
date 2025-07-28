<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColetaPeca extends Model
{
    use HasFactory;

    protected $table = 'coleta_pecas';

    protected $fillable = [
        'coleta_id',
        'tipo_id',
        'quantidade',
        'peso',
        'observacoes'
    ];

    protected $casts = [
        'quantidade' => 'integer',
        'peso' => 'decimal:2'
    ];

    /**
     * Relacionamento com coleta
     */
    public function coleta()
    {
        return $this->belongsTo(Coleta::class);
    }

    /**
     * Relacionamento com tipo
     */
    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }

    /**
     * Boot method para eventos do modelo
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($coletaPeca) {
            // Recalcular totais da coleta apenas se a coleta existir
            if ($coletaPeca->coleta && $coletaPeca->coleta->exists) {
                $coletaPeca->coleta->calcularTotais();
            }
        });

        static::deleted(function ($coletaPeca) {
            // Recalcular totais da coleta após exclusão
            if ($coletaPeca->coleta && $coletaPeca->coleta->exists) {
                $coletaPeca->coleta->calcularTotais();
            }
        });
    }



    /**
     * Accessor para subtotal formatado (agora representa quantidade de peças)
     */
    public function getSubtotalFormatadoAttribute()
    {
        return $this->subtotal . ($this->subtotal == 1 ? ' peça' : ' peças');
    }
}
