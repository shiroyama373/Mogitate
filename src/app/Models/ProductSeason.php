<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSeason extends Model
{
    use HasFactory;

    // テーブル名が product_season の場合は明示
    protected $table = 'product_season';

    // 登録可能なカラム
    protected $fillable = ['product_id', 'season_id', 'created_at', 'updated_at'];
}