<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->string('token')->nullable();
            $table->json('preffered_columns')->nullable();
            $table->string('view_id')->nullable()->comment('Google Analytics View');

            // Add columns for different periods
            $table->json('stats_1h')->nullable();
            $table->json('stats_1d')->nullable();
            $table->json('stats_1w')->nullable();
            $table->json('stats_1mo')->nullable();
            $table->json('stats_3mo')->nullable();
            $table->json('stats_6mo')->nullable();
            $table->json('stats_12mo')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('websites');
    }
};
