<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioProject extends Model
{
    protected $fillable = [
        'cat',
        'year',
        'name',
        'location',
        'client',
        'scale',
        'specs',
        'status',
        'icon',
        'color',
        'bg_light',
        'accent_text',
        'stats',
        'stat_labels',
        'scope',
        'highlights',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'specs' => 'array',
            'stats' => 'array',
            'stat_labels' => 'array',
            'scope' => 'array',
            'highlights' => 'array',
        ];
    }
}
