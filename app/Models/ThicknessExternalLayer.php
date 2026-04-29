<?php

namespace App\Models;

use App\Models\Concerns\HasUserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThicknessExternalLayer extends Model
{
    use HasUserStamps;

    protected $fillable = [
        'external_id',
        'layer_no',
        'material_code',
        'material_type_id',
        'engineering_value',
        'created_by',
        'updated_by',
    ];

    public function resinType(): BelongsTo
    {
        return $this->belongsTo(MasterMaterialType::class, 'material_type_id');
    }

    public function external(): BelongsTo
    {
        return $this->belongsTo(ThicknessExternal::class, 'external_id');
    }
}