<?php

namespace App\Models;

use App\Models\Concerns\HasUserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\MaterialTypeEngineering;

class MasterMaterialType extends Model
{
    use SoftDeletes, HasUserStamps;

    protected $fillable = [
        'type_code',
        'category_types',
        'type_name',
        'remark',
        'price_kurs',
        'price_usd',
        'price_idr',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'category_types' => 'integer',
        'price_kurs'     => 'decimal:2',
        'price_usd'      => 'decimal:2',
        'price_idr'      => 'decimal:2',
    ];

    public function engineeringDetails()
    {
        return $this->hasMany(MaterialTypeEngineering::class, 'material_type_id');
    }
}
