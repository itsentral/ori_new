<?php

namespace App\Models;

use App\Models\Concerns\HasUserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialTypeEngineering extends Model
{
    // app/Models/MaterialTypeEngineering.php

    use SoftDeletes, HasUserStamps;
    protected $fillable = [
        'material_type_id',
        'engineering_id',
        'engineering_value',
        'created_by',
        'updated_by'
    ];

    public function engineering()
    {
        return $this->belongsTo(MasterStandardEngineering::class, 'engineering_id');
    }
}
