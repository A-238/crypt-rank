<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('digital_currency_rankings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('digital_currency_id')->constrained('digital_currencies');
            $table->integer('ranking')->comment('時価総額ランキング');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_currency_rankings');
    }
};
