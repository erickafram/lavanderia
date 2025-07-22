<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PainelController;
use App\Http\Controllers\EstabelecimentoController;
use App\Http\Controllers\ColetaController;
use App\Http\Controllers\PesagemController;
use App\Http\Controllers\EmpacotamentoController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\QRCodeController;

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
Route::get('/cadastro', [AuthController::class, 'showCadastro'])->name('cadastro');
Route::post('/cadastro', [AuthController::class, 'cadastro'])->name('cadastro.post');

// Rotas protegidas por autenticação
Route::middleware(['auth'])->group(function () {
    
    // Dashboard/Painel
    Route::get('/painel', [PainelController::class, 'index'])->name('painel');
    
    // Estabelecimentos
    Route::prefix('estabelecimentos')->name('estabelecimentos.')->group(function () {
        Route::get('/', [EstabelecimentoController::class, 'index'])->name('index');
        Route::get('/cadastro', [EstabelecimentoController::class, 'create'])->name('create');
        Route::post('/cadastro', [EstabelecimentoController::class, 'store'])->name('store');
        Route::get('/{id}', [EstabelecimentoController::class, 'show'])->name('show');
        Route::get('/{id}/editar', [EstabelecimentoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [EstabelecimentoController::class, 'update'])->name('update');
        Route::delete('/{id}', [EstabelecimentoController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/toggle-status', [EstabelecimentoController::class, 'toggleStatus'])->name('toggle-status');
        Route::get('/buscar-cnpj', [EstabelecimentoController::class, 'buscarCnpj'])->name('buscar-cnpj');
    });

    // Coletas
    Route::prefix('coletas')->name('coletas.')->group(function () {
        Route::get('/', [ColetaController::class, 'index'])->name('index');
        Route::get('/nova', [ColetaController::class, 'create'])->name('create');
        Route::post('/nova', [ColetaController::class, 'store'])->name('store');
        Route::get('/{id}', [ColetaController::class, 'show'])->name('show');
        Route::put('/{id}/cancelar', [ColetaController::class, 'cancelar'])->name('cancelar');
        Route::put('/{id}/concluir', [ColetaController::class, 'concluir'])->name('concluir');

        // APIs
        Route::get('/estabelecimento/{estabelecimento_id}/coletas', [ColetaController::class, 'getColetasPorEstabelecimento'])->name('por-estabelecimento');
        Route::get('/{id}/pecas', [ColetaController::class, 'getPecasColeta'])->name('pecas');
        Route::get('/{id}/detalhes', [ColetaController::class, 'getDetalhesColeta'])->name('detalhes');
        Route::get('/tipos/lista', [ColetaController::class, 'getTipos'])->name('tipos');
    });
    
    // Coletas
    Route::prefix('coletas')->name('coletas.')->group(function () {
        Route::get('/', [ColetaController::class, 'index'])->name('index');
        Route::get('/nova', [ColetaController::class, 'create'])->name('create');
        Route::post('/', [ColetaController::class, 'store'])->name('store');
        Route::get('/{id}', [ColetaController::class, 'show'])->name('show');
        Route::put('/{id}/cancelar', [ColetaController::class, 'cancelar'])->name('cancelar');
        Route::put('/{id}/concluir', [ColetaController::class, 'concluir'])->name('concluir');
    });
    
    // Pesagem
    Route::prefix('pesagem')->name('pesagem.')->group(function () {
        Route::get('/', [PesagemController::class, 'index'])->name('index');
        Route::get('/cadastrar', [PesagemController::class, 'create'])->name('create');
        Route::post('/', [PesagemController::class, 'store'])->name('store');
        Route::get('/{id}/editar', [PesagemController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PesagemController::class, 'update'])->name('update');
    });
    
    // Empacotamento
    Route::prefix('empacotamento')->name('empacotamento.')->group(function () {
        Route::get('/', [EmpacotamentoController::class, 'index'])->name('index');
        Route::get('/novo', [EmpacotamentoController::class, 'create'])->name('create');
        Route::post('/', [EmpacotamentoController::class, 'store'])->name('store');
        Route::get('/{id}', [EmpacotamentoController::class, 'show'])->name('show');
        Route::put('/{id}/confirmar-entrega', [EmpacotamentoController::class, 'confirmarEntrega'])->name('confirmar-entrega');
        Route::get('/{id}/reimprimir-qr', [EmpacotamentoController::class, 'reimprimirQR'])->name('reimprimir-qr');
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
    
});

// Rotas para API (AJAX)
Route::prefix('api')->middleware(['auth'])->group(function () {
    Route::get('/coletas/{estabelecimento_id}', [ColetaController::class, 'getColetasPorEstabelecimento']);
    Route::get('/coleta/{id}/pecas', [ColetaController::class, 'getPecasColeta']);
    Route::get('/coleta/{id}/detalhes', [ColetaController::class, 'getDetalhesColeta']);
});
