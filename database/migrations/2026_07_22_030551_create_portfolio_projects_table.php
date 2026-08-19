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
        Schema::create('portfolio_projects', function (Blueprint $table) {
            $table->id();
            $table->string('cat');
            $table->unsignedSmallInteger('year');
            $table->string('name');
            $table->string('location');
            $table->string('client');
            $table->unsignedTinyInteger('scale')->default(1);
            $table->json('specs')->nullable();
            $table->string('status')->default('done');
            $table->string('icon');
            $table->string('color');
            $table->string('bg_light');
            $table->string('accent_text');
            $table->json('stats')->nullable();
            $table->json('stat_labels')->nullable();
            $table->json('scope')->nullable();
            $table->json('highlights')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_projects');
    }
};
