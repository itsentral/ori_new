<?php

namespace App\Models;

use App\Models\Concerns\HasUserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterStandardEngineering extends Model
{
    use SoftDeletes, HasUserStamps;

    protected $fillable = [
        'engineering_name',
        'engineering_unit',
        'engineering_code',
        'created_by',
        'updated_by'
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->engineering_code)) {
                $latest = static::query()->latest('id')->first();
                $nextNumber = $latest ? ((int) substr($latest->engineering_code, 1)) + 1 : 1;

                $model->engineering_code = 'C' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            }
        });
    }
}
