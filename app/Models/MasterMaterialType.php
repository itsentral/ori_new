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
        'created_by',
        'updated_by'
    ];

    protected $cast = [
        'category_types' => 'integer'
    ];

    public function engineeringDetails()
    {
        return $this->hasMany(MaterialTypeEngineering::class, 'material_type_id');
    }
}
