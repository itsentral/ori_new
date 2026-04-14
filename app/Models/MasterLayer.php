<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterLayer extends Model
{
    use SoftDeletes;

    protected $table = 'master_layers';
    protected $guarded = [];

    public function thicknesses(): HasMany
    {
        return $this->hasMany(MasterLayerThickness::class, 'master_layer_id');
    }

    public function diameter1()
    {
        return $this->belongsTo(MasterDiameter::class, 'diameter_id_1');
    }

    public function diameter2()
    {
        return $this->belongsTo(MasterDiameter::class, 'diameter_id_2');
    }
}