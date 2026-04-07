<?php

namespace App\Models;

use App\Models\Concerns\HasUserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThicknessLiner extends Model
{
    use SoftDeletes, HasUserStamps;

    protected $fillable = [
        'liner_code',
        'corrosion',
        'temprature',
        'material_type_code',
        'material_type_name',
        'material_type_id',
        'material_id',
        'thickness_actual',
        'thickness_teori',
        'layers_formula',
        'created_by',
        'updated_by',
    ];

    public static function generateLinerCode(string $materialTypeCode): string
    {
        $prefix = strtoupper(substr($materialTypeCode, 0, 3));

        $last = static::withTrashed()
            ->where('liner_code', 'like', "{$prefix}%")
            ->orderByDesc('liner_code')
            ->value('liner_code');

        $nextNumber = 1;
        if ($last) {
            $numeric = (int) substr($last, 3);
            $nextNumber = $numeric + 1;
        }

        return $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public static function isDuplicate(array $data, ?int $excludeId = null): bool
    {
        $query = static::where('corrosion', $data['corrosion'])
            ->where('temprature', $data['temprature'])
            ->where('material_type_id', $data['material_type_id'])
            // ->where('material_id', $data['material_id'])
            ->where('thickness_actual', $data['thickness_actual'])
            ->where('layers_formula', $data['layers_formula']);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (ThicknessLiner $model) {
            if (empty($model->liner_code) && $model->material_type_code) {
                $model->liner_code = static::generateLinerCode($model->material_type_code);
            }
        });
    }

    public function layers(): HasMany
    {
        return $this->hasMany(ThicknessLinerLayer::class, 'liner_id');
    }

    public function resinType(): BelongsTo
    {
        return $this->belongsTo(MasterMaterialType::class, 'material_type_id');
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(MasterMaterial::class, 'material_id');
    }
}
