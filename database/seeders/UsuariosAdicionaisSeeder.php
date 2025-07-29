<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\NivelAcesso;
use Illuminate\Support\Facades\Hash;

class UsuariosAdicionaisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar os níveis de acesso
        $nivelOperador = NivelAcesso::where('nome', 'Operador')->first();
        $nivelVisualizador = NivelAcesso::where('nome', 'Visualizador')->first();
        $nivelMotorista = NivelAcesso::where('nome', 'Motorista')->first();

        // Criar usuários operadores
        $operadores = [
            [
                'nome' => 'Ana Costa',
                'email' => 'ana.operador@lavanderia.com',
                'password' => Hash::make('123456'),
                'telefone' => '(11) 98888-1111',
                'cpf' => '11111111111',
                'nivel_acesso_id' => $nivelOperador->id,
                'ativo' => true,
            ],
            [
                'nome' => 'Pedro Almeida',
                'email' => 'pedro.operador@lavanderia.com',
                'password' => Hash::make('123456'),
                'telefone' => '(11) 98888-2222',
                'cpf' => '22222222222',
                'nivel_acesso_id' => $nivelOperador->id,
                'ativo' => true,
            ]
        ];

        // Criar usuários visualizadores
        $visualizadores = [
            [
                'nome' => 'Roberto Gerente',
                'email' => 'roberto.gerente@lavanderia.com',
                'password' => Hash::make('123456'),
                'telefone' => '(11) 97777-1111',
                'cpf' => '33333333333',
                'nivel_acesso_id' => $nivelVisualizador->id,
                'ativo' => true,
            ]
        ];

        // Motoristas adicionais
        $motoristasAdicionais = [
            [
                'nome' => 'Lucas Pereira',
                'email' => 'lucas.motorista@lavanderia.com',
                'password' => Hash::make('123456'),
                'telefone' => '(11) 96666-1111',
                'cpf' => '44444444444',
                'nivel_acesso_id' => $nivelMotorista->id,
                'ativo' => true,
            ],
            [
                'nome' => 'Rafael Souza',
                'email' => 'rafael.motorista@lavanderia.com',
                'password' => Hash::make('123456'),
                'telefone' => '(11) 96666-2222',
                'cpf' => '55555555555',
                'nivel_acesso_id' => $nivelMotorista->id,
                'ativo' => true,
            ]
        ];

        // Inserir todos os usuários
        $todosUsuarios = array_merge($operadores, $visualizadores, $motoristasAdicionais);

        foreach ($todosUsuarios as $usuario) {
            // Verificar se já existe
            $existente = Usuario::where('email', $usuario['email'])->first();
            if (!$existente) {
                Usuario::create($usuario);
                $this->command->info("Usuário {$usuario['nome']} criado com sucesso!");
            } else {
                $this->command->info("Usuário {$usuario['nome']} já existe.");
            }
        }
    }
}
