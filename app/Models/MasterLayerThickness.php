<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterLayerThickness extends Model
{
    use SoftDeletes;

    protected $table = 'master_layer_thicknesses';
    protected $guarded = [];

    public function masterLayer(): BelongsTo
    {
        return $this->belongsTo(MasterLayer::class, 'master_layer_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(MasterLayerThicknessDetail::class, 'layer_thickness_id');
    }
}