<?php

$detail = App\Models\ThicknessCalculationDetail::find(190);

echo "diameter_mm: " . $detail->diameter_mm_snapshot . "\n";
echo "thickness_structure_used: " . $detail->thickness_structure_used . "\n";
echo "matched_layer_id: " . $detail->matched_layer_id . "\n";

$target = (float) $detail->thickness_structure_used;
$layerId = $detail->matched_layer_id;

$lower = App\Models\MasterLayerThickness::where('master_layer_id', $layerId)
    ->where('thickness', '<=', $target)
    ->orderByDesc('thickness')
    ->first();

$upper = App\Models\MasterLayerThickness::where('master_layer_id', $layerId)
    ->where('thickness', '>=', $target)
    ->orderBy('thickness')
    ->first();

echo "target: " . $target . "\n";
echo "lower: " . $lower?->thickness . " (id: " . $lower?->id . ")\n";
echo "upper: " . $upper?->thickness . " (id: " . $upper?->id . ")\n";