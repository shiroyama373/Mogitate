<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_season', function (Blueprint $table) {
            $table->id();                       // id
            $table->foreignId('product_id')     // products テーブルの id
                  ->constrained()              // 外部キー制約
                  ->onDelete('cascade');       // products が削除されたら連動して削除
            $table->foreignId('season_id')      // seasons テーブルの id
                  ->constrained()              // 外部キー制約
                  ->onDelete('cascade');       // seasons が削除されたら連動して削除
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_season');
    }
};
