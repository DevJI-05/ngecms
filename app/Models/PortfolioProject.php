<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'image',
        'color',
        'bg_light',
        'accent_text',
        'stats',
        'stat_labels',
        'scope',
        'highlights',
        'sort_order',
    ];

    protected $appends = [
        'image_url',
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

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }
}
