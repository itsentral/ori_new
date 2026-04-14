<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThicknessCalculationLayerSelection extends Model
{
    protected $fillable = [
        'calculation_id',
        'detail_id',
        'diameter_inch_snapshot',
        'diameter_mm_snapshot',
        'layer_id',
        'layer_code_snapshot',
        'layer_category_snapshot',
        'layer_thickness_id',
        'thickness_value_snapshot',
        'selected_by',
    ];

    protected $casts = [
        'diameter_mm_snapshot'     => 'decimal:2',
        'thickness_value_snapshot' => 'decimal:2',
    ];

    public function calculation()
    {
        return $this->belongsTo(ThicknessCalculation::class);
    }

    public function detail()
    {
        return $this->belongsTo(ThicknessCalculationDetail::class);
    }

    public function layer()
    {
        return $this->belongsTo(MasterLayer::class);
    }

    public function layerThickness()
    {
        return $this->belongsTo(MasterLayerThickness::class);
    }

    public function selectedBy()
    {
        return $this->belongsTo(User::class, 'selected_by');
    }
}