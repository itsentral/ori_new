<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterTechnology extends Model
{
    use HasFactory, SoftDeletes, \App\Models\Concerns\HasUserStamps;

    protected $fillable = [
        'technology_option',
        'recommended',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
