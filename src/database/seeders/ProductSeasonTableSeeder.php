<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Season;

class ProductSeasonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 商品ごとに紐付けたいシーズンIDを配列で定義
        $productSeasons = [
            1 => [1],       // 商品ID 1 → 春
            2 => [1, 2],    // 商品ID 2 → 春, 夏
            3 => [3],       // 商品ID 3 → 秋
            4 => [2],       // 商品ID 4 → 夏
            5 => [1],       // 商品ID 5 → 春
            6 => [2],       // 商品ID 6 → 夏
            7 => [2],       // 商品ID 7 → 夏
            8 => [3],       // 商品ID 8 → 秋
            9 => [4],       // 商品ID 9 → 冬
            10 => [4],      // 商品ID 10 → 冬
        ];

        foreach ($productSeasons as $productId => $seasonIds) {
            $product = Product::find($productId);
            if ($product) {
                // sync() を使うことで重複を防ぎつつ中間テーブルを整理
                $product->seasons()->sync($seasonIds);
            }
        }
    }
}