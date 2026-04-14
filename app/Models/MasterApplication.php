<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class MasterApplication extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'application_name',
        'application_code',
        'description',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->created_by && Auth::check()) {
                $model->created_by = Auth::id();
            }

            // Auto generate application_code
            if (!$model->application_code) {
                $model->application_code = self::generateCode();
            }
        });
    }

    private static function generateCode(): string
    {
        $last = self::withTrashed()
            ->where('application_code', 'like', 'APP-%')
            ->get()
            ->map(fn($m) => (int) substr($m->application_code, 4))
            ->max() ?? 0;

        return 'APP-' . str_pad($last + 1, 3, '0', STR_PAD_LEFT);
    }

    public function calculation()
    {
        return $this->belongsTo(ThicknessCalculation::class, 'calculation_id');
    }
}
