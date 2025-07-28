<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PainelController;
use App\Http\Controllers\EstabelecimentoController;
use App\Http\Controllers\ColetaController;
use App\Http\Controllers\AnotacaoController;
use App\Http\Controllers\PesagemController;
use App\Http\Controllers\EmpacotamentoController;
use App\Http\Controllers\MotoristaController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\UsuarioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rota inicial - redireciona para login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rotas de autenticação
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas protegidas por autenticação
Route::middleware(['auth'])->group(function () {
    
    // Dashboard/Painel
    Route::get('/painel', [PainelController::class, 'index'])->name('painel');
    Route::post('/acompanhar-coleta', [PainelController::class, 'acompanharColeta'])->name('acompanhar-coleta');
    
    // Estabelecimentos
    Route::prefix('estabelecimentos')->name('estabelecimentos.')->group(function () {
        Route::get('/', [EstabelecimentoController::class, 'index'])->name('index');
        Route::get('/cadastro', [EstabelecimentoController::class, 'create'])->name('create');
        Route::post('/cadastro', [EstabelecimentoController::class, 'store'])->name('store');
        Route::get('/buscar-cnpj', [EstabelecimentoController::class, 'buscarCnpj'])->name('buscar-cnpj');
        Route::get('/{id}', [EstabelecimentoController::class, 'show'])->name('show');
        Route::get('/{id}/editar', [EstabelecimentoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [EstabelecimentoController::class, 'update'])->name('update');
        Route::delete('/{id}', [EstabelecimentoController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/toggle-status', [EstabelecimentoController::class, 'toggleStatus'])->name('toggle-status');
    });

    // Coletas
    Route::prefix('coletas')->name('coletas.')->group(function () {
        Route::get('/', [ColetaController::class, 'index'])->name('index');
        Route::get('/nova', [ColetaController::class, 'create'])->name('create');
        Route::post('/nova', [ColetaController::class, 'store'])->name('store');
        Route::get('/{id}/adicionar-pecas', [ColetaController::class, 'addPecas'])->name('add-pecas');
        Route::post('/{id}/adicionar-pecas', [ColetaController::class, 'storePecas'])->name('store-pecas');
        Route::get('/{id}', [ColetaController::class, 'show'])->name('show');
        Route::put('/{id}/cancelar', [ColetaController::class, 'cancelar'])->name('cancelar');
        Route::put('/{id}/concluir', [ColetaController::class, 'concluir'])->name('concluir');

        // APIs
        Route::get('/estabelecimento/{estabelecimento_id}/coletas', [ColetaController::class, 'getColetasPorEstabelecimento'])->name('por-estabelecimento');
        Route::get('/{id}/pecas', [ColetaController::class, 'getPecasColeta'])->name('pecas');
        Route::get('/{id}/detalhes', [ColetaController::class, 'getDetalhesColeta'])->name('detalhes');
        Route::get('/tipos/lista', [ColetaController::class, 'getTipos'])->name('tipos');
    });
    
    // Pesagem
    Route::prefix('pesagem')->name('pesagem.')->group(function () {
        Route::get('/', [PesagemController::class, 'index'])->name('index');
        Route::get('/cadastrar', [PesagemController::class, 'create'])->name('create');
        Route::post('/', [PesagemController::class, 'store'])->name('store');
        Route::post('/geral', [PesagemController::class, 'storeGeral'])->name('store-geral');
        Route::get('/comparacao', [PesagemController::class, 'createComparacao'])->name('create-comparacao');
        Route::post('/comparacao', [PesagemController::class, 'storeComparacao'])->name('store-comparacao');
        Route::get('/{id}', [PesagemController::class, 'show'])->name('show');
        Route::get('/{id}/editar', [PesagemController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PesagemController::class, 'update'])->name('update');
        Route::delete('/{id}', [PesagemController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/conferir', [PesagemController::class, 'conferir'])->name('conferir');
        Route::post('/{id}/desconferir', [PesagemController::class, 'desconferir'])->name('desconferir');

        // APIs
        Route::get('/api/coleta/{coleta_id}', [PesagemController::class, 'getPesagensPorColeta'])->name('api.coleta');
        Route::get('/api/resumo/{coleta_id}', [PesagemController::class, 'getResumoPesagemColeta'])->name('api.resumo');
    });
    
    // Empacotamento
    Route::prefix('empacotamento')->name('empacotamento.')->group(function () {
        Route::get('/', [EmpacotamentoController::class, 'index'])->name('index');
        Route::get('/novo', [EmpacotamentoController::class, 'create'])->name('create');
        Route::post('/', [EmpacotamentoController::class, 'store'])->name('store');
        Route::get('/{id}', [EmpacotamentoController::class, 'show'])->name('show');
        Route::put('/{id}/confirmar-entrega', [EmpacotamentoController::class, 'confirmarEntrega'])->name('confirmar-entrega');
        Route::get('/{id}/reimprimir-qr', [EmpacotamentoController::class, 'reimprimirQR'])->name('reimprimir-qr');
        Route::get('/{id}/etiqueta', [EmpacotamentoController::class, 'gerarEtiqueta'])->name('etiqueta');
    });

    // Motorista routes
    Route::prefix('motorista')->name('motorista.')->group(function () {
        Route::get('/dashboard', [MotoristaController::class, 'dashboard'])->name('dashboard');
        Route::post('/buscar-empacotamento', [MotoristaController::class, 'buscarEmpacotamento'])->name('buscar-empacotamento');
        Route::post('/confirmar-saida', [MotoristaController::class, 'confirmarSaida'])->name('confirmar-saida');
        Route::post('/confirmar-entrega', [MotoristaController::class, 'confirmarEntrega'])->name('confirmar-entrega');
    });

    // Relatórios
    Route::prefix('relatorios')->name('relatorios.')->group(function () {
        Route::get('/', [RelatorioController::class, 'index'])->name('index');
        Route::get('/coletas', [RelatorioController::class, 'coletas'])->name('coletas');
        Route::get('/empacotamentos', [RelatorioController::class, 'empacotamentos'])->name('empacotamentos');
        Route::get('/produtividade', [RelatorioController::class, 'produtividade'])->name('produtividade');
    });
    
    // QR Codes
    Route::prefix('qrcodes')->name('qrcodes.')->group(function () {
        Route::get('/{codigo}', [QRCodeController::class, 'rastrear'])->name('rastrear');
        Route::get('/gerar/{empacotamento_id}', [QRCodeController::class, 'gerar'])->name('gerar');
    });

    // Usuários (apenas para administradores)
    Route::prefix('usuarios')->name('usuarios.')->middleware(['auth'])->group(function () {
        Route::get('/', [UsuarioController::class, 'index'])->name('index');
        Route::get('/cadastro', [UsuarioController::class, 'create'])->name('create');
        Route::post('/cadastro', [UsuarioController::class, 'store'])->name('store');
        Route::get('/{id}', [UsuarioController::class, 'show'])->name('show');
        Route::get('/{id}/editar', [UsuarioController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UsuarioController::class, 'update'])->name('update');
        Route::delete('/{id}', [UsuarioController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/toggle-status', [UsuarioController::class, 'toggleStatus'])->name('toggle-status');
    });
    
});

// Rotas para API (AJAX)
Route::prefix('api')->middleware(['auth'])->group(function () {
    Route::get('/coletas/{estabelecimento_id}', [ColetaController::class, 'getColetasPorEstabelecimento']);
    Route::get('/coleta/{id}/pecas', [ColetaController::class, 'getPecasColeta']);
    Route::get('/coleta/{id}/detalhes', [ColetaController::class, 'getDetalhesColeta']);

    // Anotações
    Route::prefix('anotacoes')->name('api.anotacoes.')->group(function () {
        Route::get('/', [AnotacaoController::class, 'index'])->name('index');
        Route::post('/', [AnotacaoController::class, 'store'])->name('store');
        Route::put('/{id}', [AnotacaoController::class, 'update'])->name('update');
        Route::delete('/{id}', [AnotacaoController::class, 'destroy'])->name('destroy');
        Route::put('/{id}/resolvida', [AnotacaoController::class, 'marcarResolvida'])->name('marcar-resolvida');
        Route::put('/{id}/nao-resolvida', [AnotacaoController::class, 'marcarNaoResolvida'])->name('marcar-nao-resolvida');
        Route::get('/estatisticas', [AnotacaoController::class, 'estatisticas'])->name('estatisticas');
        Route::get('/relatorio', [AnotacaoController::class, 'relatorio'])->name('relatorio');
    });
});
