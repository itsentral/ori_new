<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Concerns\HasUserStamps;

class MasterMaterial extends Model
{
    use SoftDeletes, HasUserStamps;

    protected $fillable = [
        'material_id', 'trade_name', 'id_material_type', 'id_measurement', 
        'unit_measurement', 'conversion_value', 'id_packing', 'unit_packing',
        'description', 'material_name', 'international_name', 
        'min_stock_day', 'max_stock_day', 'monthly_requirement', 'created_by', 'updated_by'];

    public function materialType(): BelongsTo {
        return $this->belongsTo(MasterMaterialType::class, 'id_material_type');
    }

    public function measurement(): BelongsTo {
        return $this->belongsTo(MasterPiece::class, 'id_measurement');
    }

    public function packing(): BelongsTo {
        return $this->belongsTo(MasterPiece::class, 'id_packing');
    }
}