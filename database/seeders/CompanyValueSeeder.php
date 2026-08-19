<?php

namespace Database\Seeders;

use App\Models\CompanyValue;
use Illuminate\Database\Seeder;

class CompanyValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            ['icon' => '🛡️', 'name' => 'Safety First', 'description' => 'Keselamatan kerja adalah prioritas utama di setiap proyek, tanpa kompromi.', 'accent' => '#185FA5'],
            ['icon' => '⚙️', 'name' => 'Integritas Teknis', 'description' => 'Setiap pekerjaan dikerjakan sesuai standar teknis tertinggi dan regulasi yang berlaku.', 'accent' => '#EF9F27'],
            ['icon' => '🤝', 'name' => 'Kemitraan Jangka Panjang', 'description' => 'Kami membangun hubungan kepercayaan, bukan sekadar menyelesaikan kontrak.', 'accent' => '#3B6D11'],
            ['icon' => '💡', 'name' => 'Inovasi', 'description' => 'Terus mengadopsi teknologi terkini untuk solusi gas yang lebih efisien dan berkelanjutan.', 'accent' => '#534AB7'],
            ['icon' => '🌿', 'name' => 'Keberlanjutan', 'description' => 'Gas bumi sebagai energi transisi menuju Indonesia yang lebih bersih dan rendah emisi.', 'accent' => '#0F6E56'],
            ['icon' => '✅', 'name' => 'Ketepatan Waktu', 'description' => '96% proyek diselesaikan tepat waktu — komitmen kami kepada setiap klien.', 'accent' => '#B53556'],
        ];

        foreach ($values as $i => $value) {
            CompanyValue::query()->updateOrCreate(
                ['name' => $value['name']],
                [...$value, 'sort_order' => $i],
            );
        }
    }
}
