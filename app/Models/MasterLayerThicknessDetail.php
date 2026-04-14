<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MasterLayerThicknessDetail extends Model
{
    use SoftDeletes;

    protected $table = 'master_layer_thickness_details';
    protected $guarded = [];

    public function layerThickness(): BelongsTo
    {
        return $this->belongsTo(MasterLayerThickness::class, 'layer_thickness_id');
    }

    public function materialType(): BelongsTo
    {
        return $this->belongsTo(MasterMaterialType::class, 'material_type_id');
    }
}