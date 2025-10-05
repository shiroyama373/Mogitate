<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// トップページ
Route::get('/', function () {
    return view('welcome');
});

// 商品一覧
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// 商品登録
Route::get('/products/register', [ProductController::class, 'create'])->name('products.create');
Route::post('/products/register', [ProductController::class, 'store'])->name('products.store');

// 商品編集（詳細も兼用）
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

// 商品削除
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

// テスト用
Route::get('/test', function() {
    return 'Laravel is working!';
});
