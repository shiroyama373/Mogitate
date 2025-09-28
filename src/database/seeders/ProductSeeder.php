<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // 商品データを配列で定義
        $products = [
            [
                'name' => '商品A',
                'description' => '商品Aの説明',
                'price' => 1000,
                'image' => 'a.jpg',
            ],
            [
                'name' => '商品B',
                'description' => '商品Bの説明',
                'price' => 2000,
                'image' => 'b.jpg',
            ],
            // 必要な分だけ追加
        ];

        // DBに登録
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}