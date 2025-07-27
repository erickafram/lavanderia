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
        'preco_unitario',
        'subtotal',
        'observacoes'
    ];

    protected $casts = [
        'quantidade' => 'integer',
        'peso' => 'decimal:2',
        'preco_unitario' => 'decimal:2',
        'subtotal' => 'integer'  // Agora representa quantidade de peças
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
     * Boot method para calcular subtotal automaticamente
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($coletaPeca) {
            // Subtotal agora representa a quantidade de peças ao invés do valor monetário
            $coletaPeca->subtotal = $coletaPeca->quantidade;
        });

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
