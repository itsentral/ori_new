<?php

namespace App\Models;

use App\Models\Concerns\HasUserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterPressureNominal extends Model
{
    use SoftDeletes, HasUserStamps;
    
    protected $fillable = [
        'pn_name',
        'remark',
        'created_by',
        'updated_by'
    ];
}
