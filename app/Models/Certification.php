<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $fillable = [
        'icon',
        'icon_bg',
        'icon_color',
        'name',
        'issuer',
        'valid_text',
        'sort_order',
    ];
}
