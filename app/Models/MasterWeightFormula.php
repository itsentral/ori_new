<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MasterWeightFormula extends Model
{
    protected $fillable = [
        'formula_code',
        'formula_name',
        'formula_type',
        'waste_pipe',
        'luas_area',
        'resin_contain',
        'setting_fw',
        'glass_config',
        'glass_weight',
        'resin_weight',
        'additive',
        'mirror_glaze',
        'additional_additive',
        'total_weight',
        'fitting_params',
        'created_by',
    ];

    protected $casts = [
        'waste_pipe'           => 'array',
        'luas_area'            => 'array',
        'resin_contain'        => 'array',
        'setting_fw'           => 'array',
        'glass_config'         => 'array',
        'glass_weight'         => 'array',
        'resin_weight'         => 'array',
        'additive'             => 'array',
        'mirror_glaze'         => 'array',
        'additional_additive'  => 'array',
        'total_weight'         => 'array',
        'fitting_params'       => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (!$model->created_by && Auth::check()) {
                $model->created_by = Auth::id();
            }
            if (!$model->formula_code) {
                $model->formula_code = self::generateCode();
            }
        });
    }

    private static function generateCode(): string
    {
        $last = self::where('formula_code', 'like', 'FRM-%')
            ->get()
            ->map(fn($m) => (int) substr($m->formula_code, 4))
            ->max() ?? 0;

        return 'FRM-' . str_pad($last + 1, 3, '0', STR_PAD_LEFT);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
