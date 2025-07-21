<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    use HasFactory;

    protected $table = 'tipos';

    protected $fillable = [
        'nome',
        'descricao',
        'preco_kg',
        'categoria',
        'ativo'
    ];

    protected $casts = [
        'preco_kg' => 'decimal:2',
        'ativo' => 'boolean'
    ];

    /**
     * Relacionamento com peças de coleta
     */
    public function coletaPecas()
    {
        return $this->hasMany(ColetaPeca::class);
    }

    /**
     * Scope para tipos ativos
     */
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    /**
     * Scope por categoria
     */
    public function scopePorCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    /**
     * Accessor para preço formatado
     */
    public function getPrecoFormatadoAttribute()
    {
        return 'R$ ' . number_format($this->preco_kg, 2, ',', '.');
    }
}
