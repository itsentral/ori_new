<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ThicknessCalculation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'calculation_code',
        'brand_name',
        'standard_product_name',
        'liner_id',
        'liner_code_snapshot',
        'liner_material_type_snapshot',
        'liner_thickness_snapshot',
        'temperature',
        'pressure_nominal_id',
        'pn_name_snapshot',
        'pn_value_snapshot',
        'vacuum_type',
        'vacuum_load_snapshot',
        'stiffness_snapshot',
        'external_id',
        'external_code_snapshot',
        'external_thickness_snapshot',
        'use_external',
        'use_top_coat',
        'status',
        'created_by',
        'layer_category',
        'layer_selection_status',
    ];

    protected $casts = [
        'use_external'  => 'boolean',
        'use_top_coat'  => 'boolean',
        'liner_thickness_snapshot' => 'decimal:2',
        'pn_value_snapshot'        => 'decimal:2',
        'vacuum_load_snapshot'     => 'decimal:2',
        'external_thickness_snapshot' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (!$model->created_by && Auth::check()) {
                $model->created_by = Auth::id();
            }
            if (!$model->calculation_code) {
                $model->calculation_code = self::generateCode();
            }
        });

        static::deleting(function ($model) {
            MasterApplication::where('calculation_id', $model->id)
                ->update(['calculation_id' => null]);
        });

        // Saat di-restore, tidak perlu re-assign otomatis
        // karena aplikasi sudah bebas dan bisa dipilih lagi
    }

    private static function generateCode(): string
    {
        $last = self::withTrashed()
            ->where('calculation_code', 'like', 'CALC-%')
            ->get()
            ->map(fn($m) => (int) substr($m->calculation_code, 5))
            ->max() ?? 0;

        return 'CALC-' . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
    }

    public function details()
    {
        return $this->hasMany(ThicknessCalculationDetail::class, 'calculation_id');
    }

    public function applications()
    {
        return $this->hasMany(MasterApplication::class, 'calculation_id');
    }

    public function liner()
    {
        return $this->belongsTo(ThicknessLiner::class, 'liner_id');
    }

    public function pressureNominal()
    {
        return $this->belongsTo(MasterPressureNominal::class, 'pressure_nominal_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function layerSelections()
    {
        return $this->hasMany(ThicknessCalculationLayerSelection::class, 'calculation_id');
    }

    public function external(): BelongsTo
    {
        return $this->belongsTo(MasterThicknessExternal::class, 'external_id');
    }
}
