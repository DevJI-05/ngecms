<?php

namespace Database\Seeders;

use App\Models\Certification;
use Illuminate\Database\Seeder;

class CertificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $certifications = [
            ['icon' => 'ti-certificate', 'icon_bg' => '#E6F1FB', 'icon_color' => '#185FA5', 'name' => 'Izin Usaha BPH MIGAS', 'issuer' => 'Badan Pengatur Hilir Minyak & Gas Bumi — Kementerian ESDM RI', 'valid_text' => 'Berlaku s/d 2027'],
            ['icon' => 'ti-rosette', 'icon_bg' => '#EAF3DE', 'icon_color' => '#3B6D11', 'name' => 'ISO 9001:2015', 'issuer' => 'Sistem Manajemen Mutu — TÜV Rheinland Indonesia', 'valid_text' => 'Berlaku s/d 2026'],
            ['icon' => 'ti-shield-check', 'icon_bg' => '#FAEEDA', 'icon_color' => '#BA7517', 'name' => 'OHSAS 18001 / ISO 45001', 'issuer' => 'Sistem Manajemen K3 — Bureau Veritas Indonesia', 'valid_text' => 'Berlaku s/d 2026'],
            ['icon' => 'ti-license', 'icon_bg' => '#EEEDFE', 'icon_color' => '#534AB7', 'name' => 'IUJPTL — Instalasi Gas', 'issuer' => 'Izin Usaha Jasa Penunjang Tenaga Listrik & Gas — Kementerian ESDM', 'valid_text' => 'Berlaku s/d 2026'],
            ['icon' => 'ti-building', 'icon_bg' => '#E1F5EE', 'icon_color' => '#0F6E56', 'name' => 'Member APINDO & GAPENSI', 'issuer' => 'Asosiasi Pengusaha Indonesia & Gabungan Pelaksana Konstruksi Nasional', 'valid_text' => 'Aktif 2024'],
            ['icon' => 'ti-award', 'icon_bg' => '#FBEAF0', 'icon_color' => '#B53556', 'name' => 'Sertifikasi Kompetensi SDM', 'issuer' => 'Tenaga Ahli Bersertifikat MIGAS Level 2 & 3 — Ditjen Migas', 'valid_text' => '85 Tenaga Ahli Aktif'],
        ];

        foreach ($certifications as $i => $certification) {
            Certification::query()->updateOrCreate(
                ['name' => $certification['name']],
                [...$certification, 'sort_order' => $i],
            );
        }
    }
}
