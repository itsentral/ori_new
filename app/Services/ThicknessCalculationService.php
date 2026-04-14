<?php

namespace App\Services;

use App\Models\MasterDiameter;
use App\Models\MasterLayer;
use App\Models\MasterLayerThickness;
use App\Models\MasterTopCoat;
use App\Models\MasterThicknessExternal;
use App\Models\ThicknessPressureTemp;
use App\Models\ThicknessStiffness;
use App\Models\ThicknessVacuum;

class ThicknessCalculationService
{
    const MIN_TOTAL = 3.5;

    public function generateDetails(array $params): array
    {
        $diameters = MasterDiameter::orderBy('diameter_mm')->get();
        $details   = [];

        foreach ($diameters as $diameter) {
            $thicknessPN = ThicknessPressureTemp::where('master_diameter_id', $diameter->id)
                ->where('master_pressure_nominal_id', $params['pressure_nominal_id'])
                ->where('temperature', $params['temperature'])
                ->value('thickness') ?? 0;

            $thicknessVC = ThicknessVacuum::where('master_diameter_id', $diameter->id)
                ->where('vacuum_type', $params['vacuum_type'])
                ->where('vacuum_load', $params['vacuum_load'])
                ->value('thickness') ?? 0;

            $thicknessSN = ThicknessStiffness::where('master_diameter_id', $diameter->id)
                ->where('stiffness', $params['stiffness'])
                ->value('thickness') ?? 0;

            $thicknessEXT = 0;
            if (!empty($params['external_layer'])) {
                $thicknessEXT = MasterThicknessExternal::where('diameter_id', $diameter->id)
                    ->where('layer', $params['external_layer'])
                    ->value('thickness') ?? 0;
            }

            $thicknessTC = 0;
            if (!empty($params['use_top_coat'])) {
                $thicknessTC = MasterTopCoat::where('diameter_id', $diameter->id)
                    ->value('thickness') ?? 0;
            }

            $thicknessLiner = (float) ($params['liner_thickness'] ?? 0);

            if ($thicknessLiner == 0 && !empty($params['liner_id'])) {
                $thicknessLiner = (float) \App\Models\ThicknessLiner::find($params['liner_id'])?->thickness_teori ?? 0;
            }
            $structureRaw    = max($thicknessPN, $thicknessVC, $thicknessSN);
            $totalBeforeRule = $thicknessLiner + $structureRaw + $thicknessEXT;

            if ($totalBeforeRule < self::MIN_TOTAL) {
                $structureUsed = self::MIN_TOTAL - $thicknessLiner - $thicknessEXT;
                $rule          = 'adjusted';
            } else {
                $structureUsed = $structureRaw;
                $rule          = 'as_is';
            }

            $totalThickness = $thicknessLiner + $structureUsed + $thicknessEXT + $thicknessTC;

            $details[] = [
                'diameter_id'              => $diameter->id,
                'diameter_inch_snapshot'   => $diameter->diameter_inch,
                'diameter_mm_snapshot'     => $diameter->diameter_mm,
                'thickness_liner'          => $thicknessLiner,
                'thickness_pressure_temp'  => $thicknessPN,
                'thickness_vacuum'         => $thicknessVC,
                'thickness_stiffness'      => $thicknessSN,
                'thickness_external'       => $thicknessEXT,
                'thickness_top_coat'       => $thicknessTC,
                'thickness_structure_raw'  => $structureRaw,
                'thickness_structure_used' => $structureUsed,
                'total_thickness'          => $totalThickness,
                'structure_rule'           => $rule,
            ];
        }

        return $details;
    }

    public function matchLayerForDetails(array $details, string $category): array
    {
        foreach ($details as &$detail) {
            $diameterMm = (float) $detail['diameter_mm_snapshot'];

            // Cari layer yang cocok berdasarkan kategori dan range diameter
            $layer = MasterLayer::where('category', $category)
                ->where(function ($q) use ($diameterMm) {
                    $q->where(function ($q2) use ($diameterMm) {
                        $q2->where('operator', '<')
                            ->whereHas('diameter1', fn($d) => $d->where('diameter_mm', '>', $diameterMm));
                    })->orWhere(function ($q2) use ($diameterMm) {
                        $q2->where('operator', '>')
                            ->whereHas('diameter1', fn($d) => $d->where('diameter_mm', '<', $diameterMm));
                    })->orWhere(function ($q2) use ($diameterMm) {
                        $q2->where('operator', 'between')
                            ->whereHas('diameter1', fn($d) => $d->where('diameter_mm', '<=', $diameterMm))
                            ->whereHas('diameter2', fn($d) => $d->where('diameter_mm', '>=', $diameterMm));
                    });
                })
                ->first();

            if (!$layer) {
                $detail['matched_layer_id']            = null;
                $detail['matched_layer_code_snapshot'] = null;
                $detail['thickness_lower_id']          = null;
                $detail['thickness_lower_value']       = null;
                $detail['thickness_upper_id']          = null;
                $detail['thickness_upper_value']       = null;
                continue;
            }

            $detail['matched_layer_id']            = $layer->id;
            $detail['matched_layer_code_snapshot'] = $layer->layer_code;

            $target = (float) $detail['total_thickness'];

            $lower = MasterLayerThickness::where('master_layer_id', $layer->id)
                ->where('thickness', '<=', $target)
                ->orderByDesc('thickness')
                ->first();

            $upper = MasterLayerThickness::where('master_layer_id', $layer->id)
                ->where('thickness', '>=', $target)
                ->orderBy('thickness')
                ->first();

            // Fallback jika tidak ada lower
            if (!$lower) {
                $lower = MasterLayerThickness::where('master_layer_id', $layer->id)
                    ->orderBy('thickness')
                    ->first();
            }

            // Fallback jika tidak ada upper
            if (!$upper) {
                $upper = MasterLayerThickness::where('master_layer_id', $layer->id)
                    ->orderByDesc('thickness')
                    ->first();
            }

            $detail['thickness_lower_id']    = $lower?->id;
            $detail['thickness_lower_value'] = $lower?->thickness;
            $detail['thickness_upper_id']    = $upper?->id;
            $detail['thickness_upper_value'] = $upper?->thickness;
        }

        return $details;
    }
}
