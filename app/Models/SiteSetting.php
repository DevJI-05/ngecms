<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'company_name',
        'tagline',
        'address',
        'phone',
        'fax',
        'email_info',
        'email_project',
        'hours_weekday',
        'hours_saturday',
        'hours_sunday',
        'emergency_phone',
        'whatsapp_number',
        'pic1_name',
        'pic1_role',
        'pic1_phone',
        'pic2_name',
        'pic2_role',
        'pic2_phone',
        'map_query',
        'stat_projects_completed',
        'stat_pipeline_km',
        'stat_years_experience',
        'stat_provinces',
        'stat_employees',
        'stat_active_clients',
        'established_year',
    ];

    protected $casts = [
        'stat_projects_completed' => 'integer',
        'stat_pipeline_km' => 'integer',
        'stat_years_experience' => 'integer',
        'stat_provinces' => 'integer',
        'stat_employees' => 'integer',
        'stat_active_clients' => 'integer',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate(['id' => 1], [
            'company_name' => 'Nusantara Gas Energy',
            'tagline' => 'Natural Gas Solutions',
            'address' => 'Gedung Menara Gas Lt. 8, Jl. TB Simatupang No. 45, Jakarta Selatan 12560',
            'phone' => '+62 21 7890 1234',
            'fax' => '+62 21 7890 1235',
            'email_info' => 'info@nusantaragas.co.id',
            'email_project' => 'project@nusantaragas.co.id',
            'hours_weekday' => '08.00 – 17.00 WIB',
            'hours_saturday' => '08.00 – 13.00 WIB',
            'hours_sunday' => 'Tutup',
            'emergency_phone' => '+62 800 1234 5678',
            'whatsapp_number' => '6281298765432',
            'pic1_name' => 'Rudi Hartono',
            'pic1_role' => 'Business Development Manager',
            'pic1_phone' => '+62 812 9876 5432',
            'pic2_name' => 'Sari Andini',
            'pic2_role' => 'Engineering Consultant',
            'pic2_phone' => '+62 821 1234 5678',
            'map_query' => 'TB Simatupang Jakarta Selatan',
            'stat_projects_completed' => 200,
            'stat_pipeline_km' => 500,
            'stat_years_experience' => 15,
            'stat_provinces' => 15,
            'stat_employees' => 350,
            'stat_active_clients' => 32,
            'established_year' => 2008,
        ]);
    }
}
