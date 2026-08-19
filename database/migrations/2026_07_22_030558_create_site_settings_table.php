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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('tagline');
            $table->string('address');
            $table->string('phone');
            $table->string('fax')->nullable();
            $table->string('email_info');
            $table->string('email_project')->nullable();
            $table->string('hours_weekday');
            $table->string('hours_saturday');
            $table->string('hours_sunday');
            $table->string('emergency_phone');
            $table->string('whatsapp_number');
            $table->string('pic1_name');
            $table->string('pic1_role');
            $table->string('pic1_phone');
            $table->string('pic2_name');
            $table->string('pic2_role');
            $table->string('pic2_phone');
            $table->string('map_query')->nullable();
            $table->string('stat_projects_completed');
            $table->string('stat_pipeline_km');
            $table->string('stat_years_experience');
            $table->string('stat_provinces');
            $table->string('stat_employees');
            $table->string('stat_active_clients');
            $table->unsignedSmallInteger('established_year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
