<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $komisaris = TeamMember::query()->updateOrCreate(
            ['name' => 'Ir. Darmawan Kurniawan'],
            ['role' => 'Komisaris Utama', 'level' => 'komisaris', 'parent_id' => null, 'initials' => 'DK', 'avatar_bg' => '#E6F1FB', 'avatar_color' => '#0C447C', 'sort_order' => 0],
        );

        $direkturUtama = TeamMember::query()->updateOrCreate(
            ['name' => 'Ir. Hendra Santoso, M.T.'],
            ['role' => 'Direktur Utama', 'level' => 'direksi', 'parent_id' => $komisaris->id, 'initials' => 'HS', 'avatar_bg' => '#042C53', 'avatar_color' => '#B5D4F4', 'sort_order' => 1],
        );

        $direkturTeknik = TeamMember::query()->updateOrCreate(
            ['name' => 'Rudi Pratama, S.T.'],
            ['role' => 'Direktur Teknik & Operasi', 'level' => 'manajer', 'parent_id' => $direkturUtama->id, 'initials' => 'RP', 'avatar_bg' => '#FAEEDA', 'avatar_color' => '#633806', 'sort_order' => 2],
        );

        $direkturBisnis = TeamMember::query()->updateOrCreate(
            ['name' => 'Sari Andini, M.B.A.'],
            ['role' => 'Direktur Bisnis & Keuangan', 'level' => 'manajer', 'parent_id' => $direkturUtama->id, 'initials' => 'SA', 'avatar_bg' => '#FAEEDA', 'avatar_color' => '#633806', 'sort_order' => 3],
        );

        $direkturHse = TeamMember::query()->updateOrCreate(
            ['name' => 'Agus Wibowo, S.T.'],
            ['role' => 'Direktur HSE & QA/QC', 'level' => 'manajer', 'parent_id' => $direkturUtama->id, 'initials' => 'AW', 'avatar_bg' => '#FAEEDA', 'avatar_color' => '#633806', 'sort_order' => 4],
        );

        $departments = [
            ['name' => 'Engineering', 'role' => 'Dept. Pipeline', 'parent_id' => $direkturTeknik->id, 'initials' => 'EP', 'avatar_bg' => '#EAF3DE', 'avatar_color' => '#3B6D11', 'sort_order' => 5],
            ['name' => 'Engineering', 'role' => 'Dept. CNG', 'parent_id' => $direkturTeknik->id, 'initials' => 'EC', 'avatar_bg' => '#FAEEDA', 'avatar_color' => '#BA7517', 'sort_order' => 6],
            ['name' => 'Business', 'role' => 'Development', 'parent_id' => $direkturBisnis->id, 'initials' => 'BD', 'avatar_bg' => '#EEEDFE', 'avatar_color' => '#534AB7', 'sort_order' => 7],
            ['name' => 'Keuangan', 'role' => '& Akuntansi', 'parent_id' => $direkturBisnis->id, 'initials' => 'KU', 'avatar_bg' => '#FBEAF0', 'avatar_color' => '#B53556', 'sort_order' => 8],
            ['name' => 'HSE', 'role' => 'Dept.', 'parent_id' => $direkturHse->id, 'initials' => 'HS', 'avatar_bg' => '#EAF3DE', 'avatar_color' => '#3B6D11', 'sort_order' => 9],
            ['name' => 'QA / QC', 'role' => 'Dept.', 'parent_id' => $direkturHse->id, 'initials' => 'QA', 'avatar_bg' => '#E1F5EE', 'avatar_color' => '#0F6E56', 'sort_order' => 10],
        ];

        foreach ($departments as $department) {
            TeamMember::query()->updateOrCreate(
                ['name' => $department['name'], 'parent_id' => $department['parent_id']],
                [...$department, 'level' => 'staff'],
            );
        }
    }
}
