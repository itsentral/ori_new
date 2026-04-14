<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MasterFittingDetail extends Model
{
    use SoftDeletes;
    protected $table = 'master_fitting_details';
    protected $guarded = [];

    public function masterFitting(): BelongsTo
    {
        return $this->belongsTo(MasterFitting::class);
    }

    public function materialType(): BelongsTo
    {
        return $this->belongsTo(MasterMaterialType::class, 'material_type_id');
    }
}
