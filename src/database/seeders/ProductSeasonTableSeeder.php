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
             1  => [3, 4],       // キウイ → 秋, 冬
             2  => [1],          // ストロベリー → 春
             3  => [4],          // オレンジ → 冬
             4  => [2],          // スイカ → 夏
             5  => [2],          // ピーチ → 夏
             6  => [2, 3],       // シャインマスカット → 夏, 秋
             7  => [1, 2],       // パイナップル → 春, 夏
             8  => [2, 3],       // ブドウ → 夏, 秋
             9  => [2],          // バナナ → 夏
            10 => [1, 2],       // メロン → 春, 夏
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