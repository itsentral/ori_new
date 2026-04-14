<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MasterLayerDetail extends Model
{
    use SoftDeletes;
    protected $table = 'master_layer_details';
    protected $guarded = [];

    public function masterFitting(): BelongsTo
    {
        return $this->belongsTo(MasterLayer::class);
    }

    public function materialType(): BelongsTo
    {
        return $this->belongsTo(MasterMaterialType::class, 'material_type_id');
    }
}
