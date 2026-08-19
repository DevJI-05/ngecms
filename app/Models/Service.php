<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'cat',
        'icon',
        'icon_bg',
        'icon_color',
        'name',
        'tagline',
        'badge_bg',
        'badge_color',
        'badges',
        'description',
        'sections',
        'accent',
        'foot_note',
        'prompt',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'badges' => 'array',
            'sections' => 'array',
        ];
    }
}
