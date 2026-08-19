<?php

namespace Database\Seeders;

use App\Models\Milestone;
use Illuminate\Database\Seeder;

class MilestoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $milestones = [
            ['year_label' => '2008 — Pendirian', 'year' => 2008, 'dot_color' => '#185FA5', 'badge' => 'Milestone', 'badge_bg' => '#E6F1FB', 'badge_color' => '#0C447C', 'name' => 'PT. Nusantara Gas Energy Berdiri', 'description' => 'Didirikan oleh 3 engineer berpengalaman dari industri migas nasional. Proyek pertama: jaringan gas industri 8 km di Tangerang. Tim awal 12 orang.'],
            ['year_label' => '2010', 'year' => 2010, 'dot_color' => '#185FA5', 'badge' => 'Sertifikasi', 'badge_bg' => '#E6F1FB', 'badge_color' => '#0C447C', 'name' => 'Memperoleh Izin BPH MIGAS & ISO 9001:2008', 'description' => 'Resmi terdaftar sebagai kontraktor gas bumi berlisensi. Merekrut 50 tenaga ahli bersertifikat MIGAS Level 2 & 3.'],
            ['year_label' => '2012 — Ekspansi CNG', 'year' => 2012, 'dot_color' => '#EF9F27', 'badge' => 'CNG', 'badge_bg' => '#FAEEDA', 'badge_color' => '#633806', 'name' => 'Divisi CNG & Virtual Pipeline Diluncurkan', 'description' => 'Memenangkan tender SPBG pertama di Bekasi. Membuka lini bisnis CNG Station & Virtual Pipeline untuk kawasan industri yang belum terjangkau pipa gas.'],
            ['year_label' => '2014', 'year' => 2014, 'dot_color' => '#B53556', 'badge' => 'Penghargaan', 'badge_bg' => '#FBEAF0', 'badge_color' => '#993556', 'name' => 'Best EPC Contractor — Indonesia Gas & Energy Award', 'description' => 'Penghargaan pertama atas kinerja keselamatan dan kualitas konstruksi pipeline gas di Jawa Barat. Zero accident dalam 500.000 man-hours.'],
            ['year_label' => '2016 — Ekspansi Nasional', 'year' => 2016, 'dot_color' => '#185FA5', 'badge' => 'Milestone', 'badge_bg' => '#E6F1FB', 'badge_color' => '#0C447C', 'name' => 'Proyek Pertama di Luar Jawa — Sumatera & Kalimantan', 'description' => 'Membuka kantor cabang di Palembang dan Balikpapan. Menyelesaikan 2 proyek transmisi gas di Sumatera Selatan (75 km) dan pipeline industri di Kaltim.'],
            ['year_label' => '2018', 'year' => 2018, 'dot_color' => '#3B6D11', 'badge' => 'Maintenance', 'badge_bg' => '#EAF3DE', 'badge_color' => '#27500A', 'name' => 'Divisi Maintenance & Inspection Terbentuk', 'description' => 'Melengkapi layanan dengan unit O&M — termasuk intelligent pigging dan cathodic protection survey. Kontrak pertama dengan PGN untuk inspeksi 200 km pipeline.'],
            ['year_label' => '2020', 'year' => 2020, 'dot_color' => '#534AB7', 'badge' => 'Engineering', 'badge_bg' => '#EEEDFE', 'badge_color' => '#3C3489', 'name' => 'ISO 9001:2015 & OHSAS 18001 Diraih', 'description' => 'Upgrade sertifikasi mutu & K3. Meluncurkan divisi Engineering & Consulting — menerima proyek FEED & feasibility study pertama dari pemerintah daerah.'],
            ['year_label' => '2022', 'year' => 2022, 'dot_color' => '#B53556', 'badge' => 'Penghargaan', 'badge_bg' => '#FBEAF0', 'badge_color' => '#993556', 'name' => 'Top 10 EPC Gas — Kementerian ESDM RI', 'description' => 'Masuk daftar 10 perusahaan EPC gas terbaik versi Kementerian ESDM. Total pipeline terpasang melampaui 400 km. Karyawan tumbuh menjadi 300+.'],
            ['year_label' => '2024 — Kini', 'year' => 2024, 'dot_color' => '#185FA5', 'badge' => 'Milestone', 'badge_bg' => '#E6F1FB', 'badge_color' => '#0C447C', 'name' => '500 km Pipeline & 200+ Proyek Selesai', 'description' => 'Merayakan 16 tahun dengan pencapaian: 500 km pipeline terpasang, 200+ proyek selesai, 32 klien aktif di 15 provinsi, dan 350+ karyawan. Ekspansi ke Sulawesi dimulai.'],
        ];

        foreach ($milestones as $i => $milestone) {
            Milestone::query()->updateOrCreate(
                ['name' => $milestone['name']],
                [...$milestone, 'sort_order' => $i],
            );
        }
    }
}
