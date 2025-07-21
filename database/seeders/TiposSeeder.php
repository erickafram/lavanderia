<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tipo;

class TiposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            // Roupa de cama
            [
                'nome' => 'Lençol Solteiro',
                'descricao' => 'Lençol para cama de solteiro',
                'preco_kg' => 8.50,
                'categoria' => 'roupa_cama',
                'ativo' => true
            ],
            [
                'nome' => 'Lençol Casal',
                'descricao' => 'Lençol para cama de casal',
                'preco_kg' => 8.50,
                'categoria' => 'roupa_cama',
                'ativo' => true
            ],
            [
                'nome' => 'Fronha',
                'descricao' => 'Fronha para travesseiro',
                'preco_kg' => 9.00,
                'categoria' => 'roupa_cama',
                'ativo' => true
            ],
            [
                'nome' => 'Edredom',
                'descricao' => 'Edredom/cobertor',
                'preco_kg' => 12.00,
                'categoria' => 'roupa_cama',
                'ativo' => true
            ],
            [
                'nome' => 'Colcha',
                'descricao' => 'Colcha de cama',
                'preco_kg' => 10.00,
                'categoria' => 'roupa_cama',
                'ativo' => true
            ],
            
            // Roupa de banho
            [
                'nome' => 'Toalha de Banho',
                'descricao' => 'Toalha de banho grande',
                'preco_kg' => 9.50,
                'categoria' => 'roupa_banho',
                'ativo' => true
            ],
            [
                'nome' => 'Toalha de Rosto',
                'descricao' => 'Toalha de rosto pequena',
                'preco_kg' => 10.00,
                'categoria' => 'roupa_banho',
                'ativo' => true
            ],
            [
                'nome' => 'Roupão',
                'descricao' => 'Roupão de banho',
                'preco_kg' => 11.00,
                'categoria' => 'roupa_banho',
                'ativo' => true
            ],
            
            // Vestuário
            [
                'nome' => 'Camisa',
                'descricao' => 'Camisa social ou casual',
                'preco_kg' => 15.00,
                'categoria' => 'vestuario',
                'ativo' => true
            ],
            [
                'nome' => 'Calça',
                'descricao' => 'Calça social ou casual',
                'preco_kg' => 12.00,
                'categoria' => 'vestuario',
                'ativo' => true
            ],
            [
                'nome' => 'Vestido',
                'descricao' => 'Vestido feminino',
                'preco_kg' => 18.00,
                'categoria' => 'vestuario',
                'ativo' => true
            ],
            [
                'nome' => 'Terno/Blazer',
                'descricao' => 'Terno completo ou blazer',
                'preco_kg' => 25.00,
                'categoria' => 'vestuario',
                'ativo' => true
            ],
            
            // Mesa e copa
            [
                'nome' => 'Toalha de Mesa',
                'descricao' => 'Toalha de mesa',
                'preco_kg' => 8.00,
                'categoria' => 'mesa_copa',
                'ativo' => true
            ],
            [
                'nome' => 'Guardanapo',
                'descricao' => 'Guardanapo de tecido',
                'preco_kg' => 12.00,
                'categoria' => 'mesa_copa',
                'ativo' => true
            ],
            
            // Cortinas
            [
                'nome' => 'Cortina',
                'descricao' => 'Cortina de ambiente',
                'preco_kg' => 7.50,
                'categoria' => 'cortina',
                'ativo' => true
            ]
        ];

        foreach ($tipos as $tipo) {
            Tipo::create($tipo);
        }
    }
}
