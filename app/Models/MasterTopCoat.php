<?php

namespace App\Models;

use App\Models\Concerns\HasUserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MasterTopCoat extends Model
{
    use SoftDeletes, HasUserStamps;

    protected $fillable = ['diameter_id', 'thickness', 'created_by', 'updated_by'];

    public function diameter(): BelongsTo
    {
        return $this->belongsTo(MasterDiameter::class, 'diameter_id');
    }
}