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
        'subtotal' => 'decimal:2'
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
            $coletaPeca->subtotal = $coletaPeca->peso * $coletaPeca->preco_unitario;
        });

        static::saved(function ($coletaPeca) {
            // Atualiza totais da coleta
            $coleta = $coletaPeca->coleta;
            $coleta->peso_total = $coleta->pecas()->sum('peso');
            $coleta->valor_total = $coleta->pecas()->sum('subtotal');
            $coleta->save();
        });

        static::deleted(function ($coletaPeca) {
            // Atualiza totais da coleta após exclusão
            $coleta = $coletaPeca->coleta;
            $coleta->peso_total = $coleta->pecas()->sum('peso');
            $coleta->valor_total = $coleta->pecas()->sum('subtotal');
            $coleta->save();
        });
    }

    /**
     * Accessor para subtotal formatado
     */
    public function getSubtotalFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->subtotal, 2, ',', '.');
    }
}
