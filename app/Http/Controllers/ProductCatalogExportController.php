<?php

namespace App\Http\Controllers;

use App\Models\ThicknessCalculation;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductCatalogExportController extends Controller
{
    public function export(ThicknessCalculation $record): StreamedResponse
    {
        $details = $record->details()->orderBy('diameter_mm_snapshot')->get();
        $fileName = 'product-catalog-' . str_replace(' ', '-', strtolower($record->brand_name)) . '.xlsx';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Product Catalog');

        // --- Header Info ---
        $liner = $record->liner;
        $corrosionMap = [1 => 'Low', 2 => 'Medium', 3 => 'High'];
        $tempMap = [1 => 'Low', 2 => 'Medium', 3 => 'High'];
        $linerLabel = $liner
            ? 'Corrosion: ' . ($corrosionMap[$liner->corrosion] ?? '-') . ' | Temp: ' . ($tempMap[$liner->temprature] ?? '-')
            : '-';

        $row = 1;
        $sheet->setCellValue("A{$row}", 'Product Catalog - ' . $record->brand_name);
        $sheet->getStyle("A{$row}")->getFont()->setBold(true)->setSize(14);
        $sheet->mergeCells("A{$row}:I{$row}");
        $row += 2;

        $headerInfo = [
            ['Brand Name', $record->brand_name],
            ['Layer Category', ucfirst(str_replace('_', ' ', $record->layer_category))],
            ['Liner', $linerLabel],
            ['Temperature', $record->temperature == 80 ? '>80°C' : '65°C'],
            ['Pressure Nominal', $record->pn_name_snapshot ?? '-'],
            ['Vacuum', ucfirst($record->vacuum_type ?? '-')],
            ['Stiffness (SN)', 'SN' . $record->stiffness_snapshot],
            ['External', $record->external_thickness_snapshot ? $record->external_thickness_snapshot . ' mm' : '-'],
            ['Top Coat', $record->use_top_coat ? 'Yes' : 'No'],
            ['Applications', $record->applications->pluck('application_name')->join(', ')],
        ];

        foreach ($headerInfo as $info) {
            $sheet->setCellValue("A{$row}", $info[0]);
            $sheet->setCellValue("B{$row}", $info[1]);
            $sheet->getStyle("A{$row}")->getFont()->setBold(true);
            $row++;
        }

        $row += 1;

        // --- Table Header ---
        $tableHeaders = [
            'A' => 'Diameter',
            'B' => 'Inch',
            'C' => 'Liner (mm)',
            'D' => 'Structure / Nearest Layer (mm)',
            'E' => 'External (mm)',
            'F' => 'Top Coat (mm)',
            'G' => 'Total Thickness Theory (mm)',
            'H' => 'Total Final Thickness (mm)',
            'I' => 'Thickness Brocure (mm)',
        ];

        foreach ($tableHeaders as $col => $header) {
            $sheet->setCellValue("{$col}{$row}", $header);
        }

        // Style header row
        $headerRange = "A{$row}:I{$row}";
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F97316']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);
        $sheet->getRowDimension($row)->setRowHeight(24);

        $row++;

        // --- Data Rows ---
        foreach ($details as $detail) {
            $selectedStructure = $detail->selected_thickness_value ?? 0;
            $totalFinal = $detail->thickness_liner + $selectedStructure + $detail->thickness_external + $detail->thickness_top_coat;

            $sheet->setCellValue("A{$row}", 'DN' . $detail->diameter_mm_snapshot);

            // Set inch as explicit text to prevent Excel date interpretation
            $sheet->setCellValueExplicit("B{$row}", $detail->diameter_inch_snapshot, DataType::TYPE_STRING);

            $sheet->setCellValue("C{$row}", round($detail->thickness_liner, 2));
            $sheet->setCellValue("D{$row}", $detail->selected_thickness_value ? round($detail->selected_thickness_value, 2) : '-');
            $sheet->setCellValue("E{$row}", round($detail->thickness_external, 2));
            $sheet->setCellValue("F{$row}", round($detail->thickness_top_coat, 2));
            $sheet->setCellValue("G{$row}", round($detail->total_thickness, 2));
            $sheet->setCellValue("H{$row}", round($totalFinal, 2));
            $sheet->setCellValue("I{$row}", $detail->thickness_brocure ? round($detail->thickness_brocure, 2) : '-');

            // Borders for data
            $sheet->getStyle("A{$row}:I{$row}")->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);

            $row++;
        }

        // Auto-size columns
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Return as download
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
}
