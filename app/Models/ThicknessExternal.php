<?php

namespace App\Models;

use App\Models\Concerns\HasUserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThicknessExternal extends Model
{
    use SoftDeletes, HasUserStamps;

    protected $fillable = [
        'external_code',
        'thickness_actual',
        'thickness_teori',
        'layers_formula',
        'created_by',
        'updated_by',
    ];

    public static function generateExternalCode(): string
    {
        $prefix = 'EXT';

        $last = static::withTrashed()
            ->where('external_code', 'like', "{$prefix}%")
            ->orderByDesc('external_code')
            ->value('external_code');

        $nextNumber = 1;
        if ($last) {
            $numeric = (int) substr($last, 3);
            $nextNumber = $numeric + 1;
        }

        return $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public static function isDuplicate(array $data, ?int $excludeId = null): bool
    {
        $query = static::where('thickness_actual', $data['thickness_actual'])
            ->where('layers_formula', $data['layers_formula']);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (ThicknessExternal $model) {
            if (empty($model->external_code)) {
                $model->external_code = static::generateExternalCode();
            }
        });
    }

    public function layers(): HasMany
    {
        return $this->hasMany(ThicknessExternalLayer::class, 'external_id');
    }
}