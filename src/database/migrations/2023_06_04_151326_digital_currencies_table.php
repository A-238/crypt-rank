<?php

declare(strict_types=1);

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
        Schema::create('digital_currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('通貨名');
            $table->string('symbol')->comment('シンボル');
            $table->decimal('price', 20, 8)->comment('市場価格');
            $table->decimal('market_cap', 20, 8)->comment('時価総額');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_currencies');
    }
};
