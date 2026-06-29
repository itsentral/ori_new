<?php

namespace App\Http\Controllers;

use App\Models\ThicknessCalculation;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductCatalogExportController extends Controller
{
    public function export(ThicknessCalculation $record): StreamedResponse
    {
        $details = $record->details()->orderBy('diameter_mm_snapshot')->get();
        $fileName = 'product-catalog-' . str_replace(' ', '-', strtolower($record->brand_name)) . '.csv';

        return response()->streamDownload(function () use ($record, $details) {
            $handle = fopen('php://output', 'w');

            // BOM for Excel UTF-8 compatibility
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header info
            fputcsv($handle, ['Product Catalog - ' . $record->brand_name]);
            fputcsv($handle, []);

            $liner = $record->liner;
            $corrosionMap = [1 => 'Low', 2 => 'Medium', 3 => 'High'];
            $tempMap = [1 => 'Low', 2 => 'Medium', 3 => 'High'];
            $linerLabel = $liner
                ? 'Corrosion: ' . ($corrosionMap[$liner->corrosion] ?? '-') . ' | Temp: ' . ($tempMap[$liner->temprature] ?? '-')
                : '-';

            fputcsv($handle, ['Brand Name', $record->brand_name]);
            fputcsv($handle, ['Layer Category', ucfirst(str_replace('_', ' ', $record->layer_category))]);
            fputcsv($handle, ['Liner', $linerLabel]);
            fputcsv($handle, ['Temperature', $record->temperature == 80 ? '>80°C' : '65°C']);
            fputcsv($handle, ['Pressure Nominal', $record->pn_name_snapshot ?? '-']);
            fputcsv($handle, ['Vacuum', ucfirst($record->vacuum_type ?? '-')]);
            fputcsv($handle, ['Stiffness (SN)', 'SN' . $record->stiffness_snapshot]);
            fputcsv($handle, ['External', $record->external_thickness_snapshot ? $record->external_thickness_snapshot . ' mm' : '-']);
            fputcsv($handle, ['Top Coat', $record->use_top_coat ? 'Yes' : 'No']);
            fputcsv($handle, ['Applications', $record->applications->pluck('application_name')->join(', ')]);
            fputcsv($handle, []);

            // Table header
            fputcsv($handle, [
                'Diameter',
                'Inch',
                'Liner (mm)',
                'Structure / Nearest Layer (mm)',
                'External (mm)',
                'Top Coat (mm)',
                'Total Thickness Theory (mm)',
                'Total Final Thickness (mm)',
                'Thickness Brocure (mm)',
            ]);

            // Data rows
            foreach ($details as $detail) {
                $selectedStructure = $detail->selected_thickness_value ?? 0;
                $totalFinal = $detail->thickness_liner + $selectedStructure + $detail->thickness_external + $detail->thickness_top_coat;

                // Force Excel to treat inch as text using ="value" format
                $inchValue = '="' . $detail->diameter_inch_snapshot . '"';

                fputcsv($handle, [
                    'DN' . $detail->diameter_mm_snapshot,
                    $inchValue,
                    number_format($detail->thickness_liner, 2),
                    $detail->selected_thickness_value ? number_format($detail->selected_thickness_value, 2) : '-',
                    number_format($detail->thickness_external, 2),
                    number_format($detail->thickness_top_coat, 2),
                    number_format($detail->total_thickness, 2),
                    number_format($totalFinal, 2),
                    $detail->thickness_brocure ? number_format($detail->thickness_brocure, 2) : '-',
                ]);
            }

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
}
