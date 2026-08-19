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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('cat');
            $table->string('icon');
            $table->string('icon_bg');
            $table->string('icon_color');
            $table->string('name');
            $table->string('tagline');
            $table->string('badge_bg');
            $table->string('badge_color');
            $table->json('badges')->nullable();
            $table->text('description');
            $table->json('sections')->nullable();
            $table->string('accent');
            $table->string('foot_note');
            $table->text('prompt');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
