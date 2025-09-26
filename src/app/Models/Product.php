<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // 一括代入可能なカラム
    protected $fillable = ['name', 'price', 'image', 'description'];

    // 多対多リレーション
    public function seasons()
    {
        return $this->belongsToMany(Season::class, 'product_season');
    }
}