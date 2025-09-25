<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// トップページ
Route::get('/', function () {
    return view('welcome');
});

// 商品一覧
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// 商品登録（固定パス） ← これを先頭に
Route::get('/products/register', [ProductController::class, 'create'])->name('products.create');
Route::post('/products/register', [ProductController::class, 'store'])->name('products.store');

// 商品詳細（動的パス）
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// 商品更新
Route::get('/products/{product}/update', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}/update', [ProductController::class, 'update'])->name('products.update');

// 商品削除
Route::delete('/products/{product}/delete', [ProductController::class, 'destroy'])->name('products.destroy');



Route::get('/test', function() {
    return 'Laravel is working!';
});