<?php

namespace App\Models;

use App\Models\Concerns\HasUserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThicknessLinerLayer extends Model
{
    use SoftDeletes, HasUserStamps;
    
    protected $fillable = [
        'liner_id',
        'layer_no',
        'material_type_id',
        'material_code',
        'engineering_value',
        'created_by',
        'updated_by'
    ];

    public function liner()
    {
        return $this->belongsTo(ThicknessLiner::class, 'liner_id');
    }

    public function resinType()
    {
        return $this->belongsTo(MasterMaterialType::class, 'material_type_id');
    }
}
