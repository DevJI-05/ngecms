<?php

namespace App\Support;

class ServiceIconOptions
{
    /**
     * Curated Tabler Icons (ti-*) relevant to gas & energy services, used to
     * populate the icon picker on the Service resource form.
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        return [
            'ti-line-dashed' => 'Pipeline / Jalur Pipa',
            'ti-gas-station' => 'Stasiun Gas / SPBG',
            'ti-flame' => 'Gas / Api',
            'ti-droplet' => 'Cairan / LNG',
            'ti-engine' => 'Mesin / Kompresor',
            'ti-flask' => 'Laboratorium / Uji Gas',
            'ti-settings-2' => 'Maintenance / Pengaturan',
            'ti-tool' => 'Perbaikan / Peralatan',
            'ti-clipboard-check' => 'Inspeksi / Checklist',
            'ti-alert-triangle' => 'Peringatan / Risiko',
            'ti-chart-dots-2' => 'Engineering / Analisis',
            'ti-file-description' => 'Dokumen / Laporan',
            'ti-calendar-event' => 'Jadwal / Perencanaan',
            'ti-shield-check' => 'Safety / Sertifikasi',
            'ti-shield' => 'Keamanan / Perlindungan',
            'ti-certificate' => 'Sertifikasi / Izin',
            'ti-award' => 'Penghargaan / Kualitas',
            'ti-headset' => 'Dukungan / Customer Service',
            'ti-users' => 'Tim / SDM',
            'ti-building' => 'Perusahaan / Kantor',
            'ti-building-factory' => 'Industri / Pabrik',
            'ti-briefcase' => 'Bisnis / Klien',
            'ti-bolt' => 'Energi / Listrik',
            'ti-check' => 'Selesai / Terverifikasi',
            'ti-clock' => 'Waktu / Estimasi',
            'ti-send' => 'Pengiriman / Pengajuan',
        ];
    }
}
