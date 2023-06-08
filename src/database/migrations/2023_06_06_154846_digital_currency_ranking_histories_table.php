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
        Schema::create('digital_currency_ranking_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('digital_currency_id')->constrained('digital_currencies');
            $table->decimal('price', 20, 8)->comment('市場価格');
            $table->decimal('market_cap', 20, 8)->comment('時価総額');
            $table->integer('ranking')->comment('時価総額ランキング');
            $table->date('fetched_date')->comment('データ取得日');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_currency_ranking_histories');
    }
};
