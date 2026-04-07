<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThicknessVacuum extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'master_diameter_id',
        'vacuum_type',
        'vacuum_load',
        'thickness',
        'created_by',
        'updated_by'
    ];

    public function diameter(): BelongsTo
    {
        return $this->belongsTo(MasterDiameter::class, 'master_diameter_id');
    }

    protected static function booted(): void
    {
        static::creating(fn ($model) => $model->created_by = $model->updated_by = auth()->id());
        static::updating(fn ($model) => $model->updated_by = auth()->id());
    }
}
