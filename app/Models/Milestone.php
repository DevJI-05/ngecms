<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    protected $fillable = [
        'year_label',
        'year',
        'dot_color',
        'badge',
        'badge_bg',
        'badge_color',
        'name',
        'description',
        'sort_order',
    ];
}
