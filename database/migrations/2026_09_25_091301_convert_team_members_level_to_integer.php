<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $rows = DB::table('team_members')->select('id', 'parent_id')->get();

        $childrenByParent = [];
        foreach ($rows as $row) {
            $childrenByParent[$row->parent_id ?? 0][] = $row->id;
        }

        $levels = [];
        $queue = array_map(fn (int $id): array => [$id, 0], $childrenByParent[0] ?? []);

        while ($queue !== []) {
            [$id, $level] = array_shift($queue);
            $levels[$id] = $level;

            foreach ($childrenByParent[$id] ?? [] as $childId) {
                $queue[] = [$childId, $level + 1];
            }
        }

        // MySQL validates existing row data against the new column type
        // during the ALTER itself, before any UPDATE can run — so the old
        // string values (e.g. "komisaris") must be zeroed out first.
        DB::table('team_members')->update(['level' => '0']);

        Schema::table('team_members', function (Blueprint $table): void {
            $table->unsignedInteger('level')->default(0)->change();
        });

        foreach ($levels as $id => $level) {
            DB::table('team_members')->where('id', $id)->update(['level' => $level]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $table): void {
            $table->string('level')->default('staff')->change();
        });
    }
};
