<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var array<int, string>
     */
    private array $columns = [
        'stat_projects_completed',
        'stat_pipeline_km',
        'stat_years_experience',
        'stat_provinces',
        'stat_employees',
        'stat_active_clients',
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach (DB::table('site_settings')->get() as $row) {
            $update = [];

            foreach ($this->columns as $column) {
                $update[$column] = (int) preg_replace('/\D/', '', (string) $row->{$column});
            }

            DB::table('site_settings')->where('id', $row->id)->update($update);
        }

        Schema::table('site_settings', function (Blueprint $table): void {
            foreach ($this->columns as $column) {
                $table->unsignedInteger($column)->default(0)->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            foreach ($this->columns as $column) {
                $table->string($column)->change();
            }
        });
    }
};
