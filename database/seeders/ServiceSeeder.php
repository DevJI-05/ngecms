<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'cat' => 'pipeline', 'icon' => 'ti-line-dashed', 'icon_bg' => '#E6F1FB', 'icon_color' => '#185FA5',
                'name' => 'Gas Pipeline Construction', 'tagline' => 'Perencanaan, instalasi & komisioning jaringan pipa gas bumi',
                'badge_bg' => '#E6F1FB', 'badge_color' => '#0C447C', 'badges' => ['Tekanan Tinggi', 'Tekanan Menengah', 'Tekanan Rendah'],
                'description' => 'Kami menangani konstruksi jaringan distribusi dan transmisi gas bumi dari hulu ke hilir — mulai dari survei rute, FEED, pengadaan material, instalasi pipa, hingga pressure test dan komisioning. Dikerjakan sesuai standar SNI, ASME B31.8, dan regulasi BPH MIGAS.',
                'sections' => [
                    ['title' => 'Lingkup Pekerjaan', 'items' => ['Survei rute & studi kelayakan', 'FEED & detailed engineering', 'Pengadaan pipa API 5L & fitting', 'Pengelasan & NDT inspection', 'Hydrostatic / pneumatic test', 'Komisioning & serah terima']],
                    ['title' => 'Spesifikasi Teknis', 'items' => ['Diameter: 2" — 36" nominal', 'Tekanan operasi: s/d 100 bar', 'Material: CS, Stainless, PE80/100', 'Coating: 3LPE, FBE, Coal Tar', 'Standar: ASME B31.8 / SNI 4452']],
                ],
                'accent' => '#185FA5', 'foot_note' => 'Estimasi proyek: 3 — 18 bulan',
                'prompt' => 'Saya ingin tanya lebih detail tentang layanan Gas Pipeline Construction dan estimasi biayanya',
            ],
            [
                'cat' => 'cng', 'icon' => 'ti-gas-station', 'icon_bg' => '#FAEEDA', 'icon_color' => '#BA7517',
                'name' => 'CNG Station & Distribution', 'tagline' => 'Pembangunan SPBG, mother/daughter station, dan virtual pipeline CNG',
                'badge_bg' => '#FAEEDA', 'badge_color' => '#633806', 'badges' => ['SPBG Publik', 'Mother Station', 'Virtual Pipeline'],
                'description' => 'Layanan EPC (Engineering, Procurement & Construction) untuk fasilitas CNG lengkap — mulai dari compressor station, storage cascade, dispenser unit, hingga sistem keselamatan dan SCADA. Cocok untuk armada kendaraan, kawasan industri, dan daerah yang belum terjangkau jaringan pipa gas.',
                'sections' => [
                    ['title' => 'Jenis Fasilitas', 'items' => ['Mother Station (produksi CNG)', 'Daughter / Daughter-in-box', 'SPBG Publik & SPBG Tertutup', 'Mobile Refueling Unit (MRU)', 'Virtual Pipeline (truk CNG)']],
                    ['title' => 'Kapasitas & Spesifikasi', 'items' => ['Kapasitas: 50 — 2.000 MMBtu/hari', 'Tekanan pengisian: 200 — 250 bar', 'Compressor: reciprocating / diaphragm', 'Sistem SCADA & telemetri', 'Izin BPH MIGAS & K3LL']],
                ],
                'accent' => '#BA7517', 'foot_note' => 'Estimasi proyek: 4 — 12 bulan',
                'prompt' => 'Saya ingin konsultasi layanan CNG Station dan virtual pipeline untuk kawasan industri',
            ],
            [
                'cat' => 'maintenance', 'icon' => 'ti-settings-2', 'icon_bg' => '#EAF3DE', 'icon_color' => '#3B6D11',
                'name' => 'Maintenance & Inspection', 'tagline' => 'Inspeksi berkala, pigging, cathodic protection, dan perbaikan sistem gas',
                'badge_bg' => '#EAF3DE', 'badge_color' => '#27500A', 'badges' => ['Preventive', 'Corrective', 'Predictive'],
                'description' => 'Program pemeliharaan terpadu untuk memastikan integritas dan keandalan sistem perpipaan gas Anda. Didukung peralatan inspeksi terkini — ILI tool, corrosion coupon, dan CCTV pipeline — serta tenaga ahli bersertifikat MIGAS Level 3.',
                'sections' => [
                    ['title' => 'Layanan Utama', 'items' => ['Intelligent pigging (ILI / MFL)', 'Cathodic protection survey', 'Leak detection & survey', 'Penggantian valve & fitting', 'Pressure test & leak test']],
                    ['title' => 'Dukungan Teknis', 'items' => ['Laporan inspeksi & rekomendasi', 'Jadwal pemeliharaan tahunan', 'Suku cadang tersertifikasi', 'Respon emergency 24/7']],
                ],
                'accent' => '#3B6D11', 'foot_note' => 'Kontrak tahunan tersedia',
                'prompt' => 'Saya butuh informasi maintenance dan inspeksi pipeline gas secara rutin',
            ],
            [
                'cat' => 'engineering', 'icon' => 'ti-chart-dots-2', 'icon_bg' => '#E1F5EE', 'icon_color' => '#0F6E56',
                'name' => 'Engineering & Consulting', 'tagline' => 'FEED, feasibility study, dan konsultasi teknis proyek gas',
                'badge_bg' => '#E1F5EE', 'badge_color' => '#0F6E56', 'badges' => ['FEED', 'Feasibility Study', 'DED'],
                'description' => 'Tim engineer berpengalaman kami membantu Anda dari tahap konseptual hingga dokumen tender — termasuk FEED, Detailed Engineering Design (DED), cost estimation, dan dukungan perizinan ke BPH MIGAS / Kementerian ESDM.',
                'sections' => [
                    ['title' => 'Lingkup Konsultasi', 'items' => ['Pre-feasibility & feasibility study', 'Front End Engineering Design', 'Detailed Engineering Design', 'HAZOP & risk assessment', 'Dokumen perizinan MIGAS']],
                    ['title' => 'Deliverables', 'items' => ['P&ID, isometric, general layout', 'Pipeline hydraulic simulation', 'Cost estimation & BOQ', 'Dokumen tender & spesifikasi']],
                ],
                'accent' => '#0F6E56', 'foot_note' => 'Durasi: 1 — 6 bulan',
                'prompt' => 'Saya tertarik layanan engineering consulting untuk proyek gas, bisa jelaskan prosesnya?',
            ],
            [
                'cat' => 'safety', 'icon' => 'ti-shield-check', 'icon_bg' => '#EEEDFE', 'icon_color' => '#534AB7',
                'name' => 'Safety, HSE & Commissioning', 'tagline' => 'Manajemen K3LL, HAZOP study, commissioning test, dan sertifikasi operasional',
                'badge_bg' => '#EEEDFE', 'badge_color' => '#3C3489', 'badges' => ['HSE Management', 'HAZOP', 'Commissioning'],
                'description' => 'Keselamatan adalah prioritas utama di setiap proyek gas. Kami menyediakan layanan HSE terintegrasi — dari penyusunan dokumen K3LL, safety induction, hingga pendampingan sertifikasi operasional fasilitas gas oleh Dirjen MIGAS.',
                'sections' => [
                    ['title' => 'Layanan Safety', 'items' => ['HAZOP & SIL assessment', 'Job Safety Analysis (JSA)', 'Emergency Response Plan', 'Safety induction & pelatihan', 'Audit K3LL internal']],
                    ['title' => 'Komisioning & Sertifikasi', 'items' => ['Pre-commissioning & purging', 'Gas tightness test', 'Performance test & tuning', 'Pendampingan sidang teknis MIGAS']],
                ],
                'accent' => '#534AB7', 'foot_note' => 'Dapat digabung dengan paket EPC',
                'prompt' => 'Saya butuh layanan HSE management dan pendampingan komisioning fasilitas gas',
            ],
        ];

        foreach ($services as $i => $service) {
            Service::query()->updateOrCreate(
                ['name' => $service['name']],
                [...$service, 'sort_order' => $i],
            );
        }
    }
}
