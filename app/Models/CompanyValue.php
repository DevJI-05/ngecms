<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyValue extends Model
{
    protected $fillable = [
        'icon',
        'name',
        'description',
        'accent',
        'sort_order',
    ];
}
