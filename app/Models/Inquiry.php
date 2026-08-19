<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'nama',
        'jabatan',
        'email',
        'telepon',
        'perusahaan',
        'layanan',
        'estimasi',
        'lokasi',
        'pesan',
        'sumber',
        'status',
    ];
}
