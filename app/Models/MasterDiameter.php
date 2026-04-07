<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\MasterThicknessExternal;
use App\Models\ThicknessPressureTemp;
use App\Models\ThicknessVacuum;
use App\Models\MasterTopCoat;

class MasterDiameter extends Model
{
    protected $table = 'master_diameters';

    protected $fillable = [
        'diameter_inch',
        'diameter_mm',
        'created_by',
        'updated_by'
    ];

    public function thicknessExternals(): HasMany
    {
        return $this->hasMany(MasterThicknessExternal::class, 'diameter_id');
    }

    public function thicknessStiffnesses(): HasMany
    {
        return $this->hasMany(ThicknessStiffness::class, 'master_diameter_id');
    }

    public function thicknessPressureTemps(): HasMany
    {
        return $this->hasMany(ThicknessPressureTemp::class, 'master_diameter_id');
    }

    public function thicknessVacuums(): HasMany
    {
        return $this->hasMany(ThicknessVacuum::class, 'master_diameter_id');
    }

    public function topCoat(): HasOne
    {
        return $this->hasOne(MasterTopCoat::class, 'diameter_id');
    }

    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->created_by = auth()->id();
            $model->updated_by = auth()->id();
        });

        static::updating(function ($model) {
            $model->updated_by = auth()->id();
        });
    }
}
