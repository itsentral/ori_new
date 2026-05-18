<?php


// Ganti ID dengan calculation yang baru dibuat
$record = App\Models\ThicknessCalculation::find(2);
dump([
    'vacuum_type'          => $record->vacuum_type,
    'vacuum_load_snapshot' => $record->vacuum_load_snapshot,
]);