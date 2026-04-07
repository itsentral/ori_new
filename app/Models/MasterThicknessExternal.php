<?php

namespace App\Models;

use App\Models\Concerns\HasUserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MasterThicknessExternal extends Model
{
    use SoftDeletes, HasUserStamps;

    protected $fillable = ['diameter_id', 'layer', 'thickness', 'created_by', 'updated_by'];

    public function diameter(): BelongsTo
    {
        return $this->belongsTo(MasterDiameter::class, 'diameter_id');
    }

    public function thicknessExternals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\MasterThicknessExternal::class, 'diameter_id');
    }
}
