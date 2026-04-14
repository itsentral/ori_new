<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThicknessCalculationDetail extends Model
{
    protected $fillable = [
        'calculation_id',
        'diameter_id',
        'diameter_inch_snapshot',
        'diameter_mm_snapshot',
        'thickness_liner',
        'thickness_pressure_temp',
        'thickness_vacuum',
        'thickness_stiffness',
        'thickness_external',
        'thickness_top_coat',
        'thickness_structure_raw',
        'thickness_structure_used',
        'total_thickness',
        'structure_rule',
        'matched_layer_id',
        'matched_layer_code_snapshot',
        'thickness_lower_id',
        'thickness_lower_value',
        'thickness_upper_id',
        'thickness_upper_value',
        'selected_thickness_id',
        'selected_thickness_value',
    ];

    protected $casts = [
        'thickness_liner'          => 'decimal:2',
        'thickness_pressure_temp'  => 'decimal:2',
        'thickness_vacuum'         => 'decimal:2',
        'thickness_stiffness'      => 'decimal:2',
        'thickness_external'       => 'decimal:2',
        'thickness_top_coat'       => 'decimal:2',
        'thickness_structure_raw'  => 'decimal:2',
        'thickness_structure_used' => 'decimal:2',
        'total_thickness'          => 'decimal:2',
        'thickness_lower_value'    => 'decimal:2',
        'thickness_upper_value'    => 'decimal:2',
        'selected_thickness_value' => 'decimal:2',
    ];

    public function calculation()
    {
        return $this->belongsTo(ThicknessCalculation::class, 'calculation_id');
    }

    public function diameter()
    {
        return $this->belongsTo(MasterDiameter::class, 'diameter_id');
    }

    public function matchedLayer()
{
    return $this->belongsTo(MasterLayer::class, 'matched_layer_id');
}

public function thicknessLower()
{
    return $this->belongsTo(MasterLayerThickness::class, 'thickness_lower_id');
}

public function thicknessUpper()
{
    return $this->belongsTo(MasterLayerThickness::class, 'thickness_upper_id');
}

public function selectedThickness()
{
    return $this->belongsTo(MasterLayerThickness::class, 'selected_thickness_id');
}
}
