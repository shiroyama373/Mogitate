<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Season;

class ProductsTableSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'キウイ',
                'price' => 800,
                'description' => 'キウイは甘みと酸味のバランスが絶妙なフルーツです。ビタミンCなどの栄養素も豊富のため、美肌効果や疲労回復効果も期待できます。もぎたてフルーツのスムージーをお召し上がりください！',
                'image' => 'kiwi.png',
                'seasons' => ['秋','冬'],
            ],
            [
                'name' => 'ストロベリー',
                'price' => 1200,
                'description' => '大人から子供まで大人気のストロベリー。当店では鮮度抜群の完熟いちごを使用しています。',
                'image' => 'strawberry.png',
                'seasons' => ['春'],
            ],
            [
                'name' => 'オレンジ',
                'price' => 850,
                'description' => '当店では酸味と甘みのバランスが抜群のネーブルオレンジを使用しています。',
                'image' => 'orange.png',
                'seasons' => ['冬'],
            ],
            [
                'name' => 'スイカ',
                'price' => 700,
                'description' => '甘くてシャリシャリ食感が魅力のスイカ。全体の90％が水分のため、暑い日の水分補給や熱中症予防におすすめです。',
                'image' => 'watermelon.png',
                'seasons' => ['夏'],
            ],
            [
                'name' => 'ピーチ',
                'price' => 1000,
                'description' => '豊潤な香りととろけるような甘さが魅力のピーチ。ビタミンEが豊富です。',
                'image' => 'peach.png',
                'seasons' => ['夏'],
            ],
            [
                'name' => 'シャインマスカット',
                'price' => 1400,
                'description' => '爽やかな香りと上品な甘みが特長的なシャインマスカット。',
                'image' => 'muscat.png',
                'seasons' => ['夏','秋'],
            ],
            [
                'name' => 'パイナップル',
                'price' => 800,
                'description' => '甘酸っぱさとトロピカルな香りが特徴のパイナップル。',
                'image' => 'pineapple.png',
                'seasons' => ['春','夏'],
            ],
            [
                'name' => 'ブドウ',
                'price' => 1100,
                'description' => 'ブドウの中でも人気の高い国産の「巨峰」を使用。',
                'image' => 'grapes.png',
                'seasons' => ['夏','秋'],
            ],
            [
                'name' => 'バナナ',
                'price' => 600,
                'description' => '低カロリーで栄養満点のバナナ。ダイエット中の方にもおすすめ。',
                'image' => 'banana.png',
                'seasons' => ['夏'],
            ],
            [
                'name' => 'メロン',
                'price' => 900,
                'description' => 'ジューシーで甘みたっぷりのメロン。見た目も華やかで贈り物にも最適です。',
                'image' => 'melon.png',
                'seasons' => ['春','夏'],
            ],
        ];

        foreach ($products as $data) {
            $seasons = $data['seasons'];
            unset($data['seasons']); // 中間テーブル用に取り除く

            $product = Product::create($data);

            // 季節のIDを取得して中間テーブルに紐付け
            $seasonIds = \App\Models\Season::whereIn('name', $seasons)->pluck('id');
            $product->seasons()->sync($seasonIds);
        }
    }
}