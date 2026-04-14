@php
    $thicknesses = $getRecord()->thicknesses()->with('details.materialType')->get();

    $maxStage = 0;
    $maxStep = 7;

    foreach ($thicknesses as $thickness) {
        $stageMax = $thickness->details->max('stage_number') ?? 0;
        $maxStage = max($maxStage, $stageMax);
    }

    $record = $getRecord();
    $d1 = $record->diameter1?->diameter_mm;
    $d2 = $record->diameter2?->diameter_mm;
    $op = $record->operator;

    $param = match($op) {
        '<'       => "< DN{$d1}",
        '>'       => "> DN{$d1}",
        'between' => "DN{$d1} - DN{$d2}",
        default   => '-',
    };
@endphp

<style>
    .lm-wrap { overflow-x: auto; width: 100%; }

    .lm-table {
        border-collapse: collapse;
        width: max-content;
        min-width: 100%;
        font-size: 13px;
        text-align: center;
        border: 2px solid #9ca3af;
    }
    .dark .lm-table { border-color: #4b5563; }

    /* TH & TD base border */
    .lm-table th, .lm-table td {
        border: 1px solid #d1d5db;
        padding: 8px 12px;
        white-space: nowrap;
    }
    .dark .lm-table th,
    .dark .lm-table td { border-color: #4b5563; }

    /* Stage separator */
    .lm-stage-sep { border-left: 2px solid #9ca3af !important; }
    .dark .lm-stage-sep { border-left-color: #6b7280 !important; }

    /* Header stage row */
    .lm-th-stage {
        background-color: #f3f4f6;
        color: #111827;
        font-weight: 700;
        letter-spacing: 0.05em;
        border: 2px solid #9ca3af;
    }
    .dark .lm-th-stage {
        background-color: #1f2937;
        color: #f9fafb;
        border-color: #4b5563;
    }

    /* Header label (Thickness & Parameter) */
    .lm-th-label {
        background-color: #f3f4f6;
        color: #111827;
        font-weight: 700;
        text-align: left;
        border: 2px solid #9ca3af;
    }
    .dark .lm-th-label {
        background-color: #1f2937;
        color: #f9fafb;
        border-color: #4b5563;
    }

    /* Header step number row */
    .lm-th-step {
        background-color: #e5e7eb;
        color: #374151;
        font-weight: 600;
        min-width: 75px;
    }
    .dark .lm-th-step {
        background-color: #374151;
        color: #d1d5db;
    }

    /* Body rows */
    .lm-td-label {
        background-color: #f9fafb;
        color: #111827;
        font-weight: 600;
        text-align: left;
        border: 2px solid #9ca3af;
    }
    .dark .lm-td-label {
        background-color: #111827;
        color: #f9fafb;
        border-color: #4b5563;
    }

    .lm-td-param {
        background-color: #f9fafb;
        color: #6b7280;
        text-align: left;
        border: 2px solid #9ca3af;
    }
    .dark .lm-td-param {
        background-color: #111827;
        color: #9ca3af;
        border-color: #4b5563;
    }

    .lm-td-even { background-color: #f9fafb; }
    .dark .lm-td-even { background-color: #111827; }

    .lm-td-odd { background-color: #ffffff; }
    .dark .lm-td-odd { background-color: #1f2937; }

    .lm-val { color: #f97316; font-weight: 600; }
    .dark .lm-val { color: #fb923c; }

    .lm-empty { color: #d1d5db; }
    .dark .lm-empty { color: #4b5563; }
</style>

<div class="lm-wrap">
    <table class="lm-table">
        <thead>
            <tr>
                <th class="lm-th-label" rowspan="2">Thickness</th>
                <th class="lm-th-label" rowspan="2">Parameter</th>
                @for ($stage = 1; $stage <= $maxStage; $stage++)
                    <th class="lm-th-stage lm-stage-sep" colspan="{{ $maxStep }}">
                        STAGE {{ $stage }}
                    </th>
                @endfor
            </tr>
            <tr>
                @for ($stage = 1; $stage <= $maxStage; $stage++)
                    @for ($step = 1; $step <= $maxStep; $step++)
                        <th class="lm-th-step {{ $step === 1 ? 'lm-stage-sep' : '' }}">
                            {{ $step }}
                        </th>
                    @endfor
                @endfor
            </tr>
        </thead>

        <tbody>
            @forelse ($thicknesses as $index => $thickness)
                @php
                    $detailMap = [];
                    foreach ($thickness->details as $detail) {
                        $detailMap[$detail->stage_number][$detail->step_number] = $detail;
                    }
                    $rowClass = $index % 2 === 0 ? 'lm-td-even' : 'lm-td-odd';
                @endphp
                <tr>
                    <td class="lm-td-label {{ $rowClass }}">
                        {{ number_format($thickness->thickness, 2) }}
                    </td>
                    <td class="lm-td-param {{ $rowClass }}">
                        {{ $param }}
                    </td>
                    @for ($stage = 1; $stage <= $maxStage; $stage++)
                        @for ($step = 1; $step <= $maxStep; $step++)
                            @php
                                $detail = $detailMap[$stage][$step] ?? null;
                                $hasValue = $detail && $detail->material_type_id;
                            @endphp
                            <td class="{{ $rowClass }} {{ $step === 1 ? 'lm-stage-sep' : '' }}">
                                @if ($hasValue)
                                    <span class="lm-val">
                                        {{ $detail->materialType?->type_code ?? '-' }}
                                    </span>
                                @else
                                    <span class="lm-empty">—</span>
                                @endif
                            </td>
                        @endfor
                    @endfor
                </tr>
            @empty
                <tr>
                    <td colspan="{{ 2 + ($maxStage * $maxStep) }}" class="lm-empty" style="padding: 16px; text-align: center;">
                        No data available
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>