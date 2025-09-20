<?php

use App\Http\Controllers\PaginaInicialController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GerenciadorProdutoController;
use App\Http\Controllers\ProductController;

Route::get('/', [PaginaInicialController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('pagina-inicial');

Route::get('admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {

    Route::resource('produtos', GerenciadorProdutoController::class)
         ->only(['index', 'create', 'store']);

    Route::get('/produtos/{product_id}/{seller_id}/{category_id}', [ProductController::class, 'show'])->name('produtos.show');
    Route::get('/produtos/{product_id}/{seller_id}/{category_id}/edit', [GerenciadorProdutoController::class, 'edit'])->name('produtos.edit');
    Route::put('/produtos/{product_id}/{seller_id}/{category_id}', [GerenciadorProdutoController::class, 'update'])->name('produtos.update');
    Route::delete('/produtos/{product_id}/{seller_id}/{category_id}', [GerenciadorProdutoController::class, 'destroy'])->name('produtos.destroy');
});


require __DIR__ . '/auth.php';