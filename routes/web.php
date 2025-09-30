<?php

use App\Http\Controllers\CepController;
use App\Http\Controllers\PaginaInicialController;
use App\Http\Controllers\PagSeguroController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GerenciadorProdutoController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HistoricoVendaController;
use App\Http\Controllers\GerenciadorUsuarioController;
use App\Http\Controllers\HistoricoCompraController;

Route::get('/', [PaginaInicialController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('pagina-inicial');

Route::get('admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('produtos', GerenciadorProdutoController::class)->only(['index', 'create', 'store']);
    Route::get('/produtos/{product_id}/{seller_id}/{category_id}', [ProductController::class, 'show'])->name('produtos.show');
    Route::get('/produtos/{product_id}/{seller_id}/{category_id}/edit', [GerenciadorProdutoController::class, 'edit'])->name('produtos.edit');
    Route::put('/produtos/{product_id}/{seller_id}/{category_id}', [GerenciadorProdutoController::class, 'update'])->name('produtos.update');
    Route::delete('/produtos/{product_id}/{seller_id}/{category_id}', [GerenciadorProdutoController::class, 'destroy'])->name('produtos.destroy');
    Route::get('/historico-vendas', [HistoricoVendaController::class, 'index'])->name('historico-vendas.index');
    Route::get('/historico-vendas/pdf', [HistoricoVendaController::class, 'generatePdf'])->name('historico-vendas.pdf');
    Route::get('/historico-compras', [HistoricoCompraController::class, 'index'])->name('historico-compras.index');
    Route::post('/checkout', [PagSeguroController::class, 'createCheckout']);
});

Route::middleware(['auth', 'is.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', GerenciadorUsuarioController::class);
});

Route::get('/cep/{cep}', [CepController::class, 'show']);

require __DIR__ . '/auth.php';