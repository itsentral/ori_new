<x-filament-panels::page>

    <div wire:init="recalculate"></div>

    {{-- Loading --}}
    <div wire:loading.flex wire:target="recalculate" class="pt-spinner">
        <div class="pt-spinner-circle"></div>
        <p class="pt-spinner-text">Menghitung ulang thickness...</p>
        <p class="pt-spinner-sub">Mencocokkan data terbaru dari semua master data</p>
    </div>


    <style>
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .fi-header-heading {
            font-size: 1.4rem !important;
        }

        .fi-page-content {
            row-gap: calc(var(--spacing) * 2);
        }

        /* ===== MAIN TABLE ===== */
        .pt-wrap {
            overflow-x: auto;
            overflow-y: auto;
            width: 100%;
            max-height: 80vh;
        }

        .pt-card {
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            margin-bottom: 16px;
        }

        .dark .pt-card {
            border-color: #374151;
        }

        .pt-card-header {
            background: #f9fafb;
            padding: 12px 16px;
            border-bottom: 1px solid #e5e7eb;
        }

        .dark .pt-card-header {
            background: #1f2937;
            border-color: #374151;
        }

        .pt-card-title {
            font-weight: 600;
            font-size: 14px;
            color: #111827;
            margin: 0;
        }

        .dark .pt-card-title {
            color: #f9fafb;
        }

        .pt-info-grid {
            padding: 16px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        .pt-info-label {
            font-size: 11px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: 600;
            margin: 0 0 2px;
        }

        .dark .pt-info-label {
            color: #9ca3af;
        }

        .pt-info-value {
            font-size: 13px;
            color: #111827;
            font-weight: 500;
            margin: 0;
        }

        .dark .pt-info-value {
            color: #f3f4f6;
        }

        /* ===== MAIN TABLE ===== */
        .pt-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .pt-thead-tr {
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .dark .pt-thead-tr {
            background: #1f2937;
            border-color: #374151;
        }

        .pt-th {
            padding: 10px 8px;
            font-weight: 600;
            color: #374151;
            text-align: center;
        }

        .dark .pt-th {
            color: #d1d5db;
        }

        .pt-th-left {
            text-align: left;
            padding: 10px 16px;
        }

        .pt-tr-even {
            background: #ffffff;
            border-bottom: 1px solid #f3f4f6;
        }

        .dark .pt-tr-even {
            background: #1f2937;
            border-color: #374151;
        }

        .pt-tr-odd {
            background: #f9fafb;
            border-bottom: 1px solid #f3f4f6;
        }

        .dark .pt-tr-odd {
            background: #111827;
            border-color: #374151;
        }

        .pt-td {
            text-align: center;
            padding: 10px 8px;
            color: #374151;
        }

        .dark .pt-td {
            color: #d1d5db;
        }

        .pt-td-left {
            text-align: left;
            padding: 10px 16px;
        }

        .pt-diameter {
            font-weight: 600;
            color: #111827;
            font-size: 13px;
        }

        .dark .pt-diameter {
            color: #f3f4f6;
        }

        .pt-diameter-sub {
            font-size: 11px;
            color: #6b7280;
        }

        .dark .pt-diameter-sub {
            color: #9ca3af;
        }

        .pt-total {
            font-weight: 700;
            color: #f97316;
        }

        .dark .pt-total {
            color: #fb923c;
        }

        .pt-badge-adjusted {
            background: #fef3c7;
            color: #92400e;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 600;
        }

        .dark .pt-badge-adjusted {
            background: #451a03;
            color: #fcd34d;
        }

        .pt-badge-asis {
            background: #d1fae5;
            color: #065f46;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 600;
        }

        .dark .pt-badge-asis {
            background: #022c22;
            color: #6ee7b7;
        }

        .pt-layer-btn {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 6px;
            border: 1px solid #6366f1;
            background: #eef2ff;
            color: #4338ca;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
        }

        .dark .pt-layer-btn {
            border-color: #818cf8;
            background: #1e1b4b;
            color: #a5b4fc;
        }

        .pt-no-layer {
            color: #9ca3af;
            font-size: 12px;
        }

        .dark .pt-no-layer {
            color: #6b7280;
        }

        /* Radio buttons */
        .pt-radio-label {
            display: flex;
            align-items: center;
            gap: 4px;
            cursor: pointer;
            padding: 4px 10px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            background: #ffffff;
            font-size: 12px;
        }

        .dark .pt-radio-label {
            border-color: #4b5563;
            background: #1f2937;
        }

        .pt-radio-label.selected {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        .dark .pt-radio-label.selected {
            border-color: #3b82f6;
            background: #1e3a5f;
        }

        .pt-radio-value {
            font-weight: 600;
            color: #1d4ed8;
        }

        .dark .pt-radio-value {
            color: #60a5fa;
        }

        .pt-radio-sub {
            font-size: 10px;
            color: #6b7280;
        }

        .dark .pt-radio-sub {
            color: #9ca3af;
        }

        .pt-selected-badge {
            background: #eff6ff;
            color: #1d4ed8;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid #3b82f6;
        }

        .dark .pt-selected-badge {
            background: #1e3a5f;
            color: #60a5fa;
            border-color: #3b82f6;
        }

        .pt-not-selected {
            color: #9ca3af;
            font-size: 12px;
        }

        .dark .pt-not-selected {
            color: #6b7280;
        }

        /* ===== MODAL ===== */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 24px;
        }

        .modal-box {
            background: #fff;
            border-radius: 12px;
            width: 100%;
            max-width: 900px;
            max-height: 85vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            border: 1px solid #e5e7eb;
        }

        .dark .modal-box {
            background: #1f2937;
            border-color: #374151;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            border-bottom: 1px solid #e5e7eb;
            background: #f9fafb;
        }

        .dark .modal-header {
            border-color: #374151;
            background: #111827;
        }

        .modal-title {
            font-size: 15px;
            font-weight: 700;
            color: #111827;
            margin: 0;
        }

        .dark .modal-title {
            color: #f9fafb;
        }

        .modal-subtitle {
            font-size: 12px;
            color: #6b7280;
            margin: 2px 0 0;
        }

        .dark .modal-subtitle {
            color: #9ca3af;
        }

        .modal-close-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: #6b7280;
            padding: 4px;
        }

        .dark .modal-close-btn {
            color: #9ca3af;
        }

        .modal-selected-bar {
            padding: 10px 20px;
            background: #eff6ff;
            border-bottom: 1px solid #bfdbfe;
            font-size: 12px;
            color: #1d4ed8;
            font-weight: 600;
        }

        .dark .modal-selected-bar {
            background: #1e3a5f;
            border-color: #1d4ed8;
            color: #60a5fa;
        }

        .modal-body {
            overflow-y: auto;
            padding: 20px;
        }

        /* ===== LAYER MATRIX TABLE ===== */
        .lm-wrap {
            overflow-x: auto;
            width: 100%;
        }

        .lm-table {
            border-collapse: collapse;
            width: max-content;
            min-width: 100%;
            font-size: 12px;
            text-align: center;
            border: 2px solid #9ca3af;
        }

        .dark .lm-table {
            border-color: #4b5563;
        }

        .lm-table th,
        .lm-table td {
            border: 1px solid #d1d5db;
            padding: 6px 10px;
            white-space: nowrap;
        }

        .dark .lm-table th,
        .dark .lm-table td {
            border-color: #4b5563;
        }

        .lm-stage-sep {
            border-left: 2px solid #9ca3af !important;
        }

        .dark .lm-stage-sep {
            border-left-color: #6b7280 !important;
        }

        .lm-th-stage {
            background-color: #f3f4f6;
            color: #111827;
            font-weight: 700;
            border: 2px solid #9ca3af;
        }

        .dark .lm-th-stage {
            background-color: #1f2937;
            color: #f9fafb;
            border-color: #4b5563;
        }

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

        .lm-th-step {
            background-color: #e5e7eb;
            color: #374151;
            font-weight: 600;
            min-width: 60px;
        }

        .dark .lm-th-step {
            background-color: #374151;
            color: #d1d5db;
        }

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

        .lm-td-even {
            background-color: #f9fafb;
            color: #374151;
        }

        .dark .lm-td-even {
            background-color: #111827;
            color: #d1d5db;
        }

        .lm-td-odd {
            background-color: #ffffff;
            color: #374151;
        }

        .dark .lm-td-odd {
            background-color: #1f2937;
            color: #d1d5db;
        }

        .lm-val {
            color: #f97316;
            font-weight: 600;
        }

        .dark .lm-val {
            color: #fb923c;
        }

        .lm-empty {
            color: #d1d5db;
        }

        .dark .lm-empty {
            color: #4b5563;
        }

        .lm-selected-row td {
            outline: 2px solid #3b82f6;
        }

        .lm-selected-label {
            background: #eff6ff !important;
            color: #1d4ed8 !important;
        }

        .dark .lm-selected-label {
            background: #1e3a5f !important;
            color: #60a5fa !important;
        }

        .lm-selected-badge {
            font-size: 10px;
            background: #3b82f6;
            color: #fff;
            padding: 1px 5px;
            border-radius: 9999px;
            margin-left: 4px;
        }

        /* Loading spinner */
        .pt-spinner {
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 80px 0;
            gap: 16px;
        }

        .pt-spinner-circle {
            width: 48px;
            height: 48px;
            border: 4px solid #e5e7eb;
            border-top-color: #f97316;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        .dark .pt-spinner-circle {
            border-color: #374151;
            border-top-color: #f97316;
        }

        .pt-spinner-text {
            font-size: 14px;
            color: #6b7280;
            font-weight: 500;
        }

        .dark .pt-spinner-text {
            color: #9ca3af;
        }

        .pt-spinner-sub {
            font-size: 12px;
            color: #9ca3af;
        }

        .dark .pt-spinner-sub {
            color: #6b7280;
        }

        .pt-adj-trigger {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 16px;
            height: 16px;
            border-radius: 9999px;
            background: #f97316;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            cursor: pointer;
            margin-left: 4px;
            vertical-align: middle;
            user-select: none;
        }

        .dark .pt-adj-trigger {
            background: #ea580c;
        }

        .pt-adj-popover {
            position: fixed;
            z-index: 99999;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px 14px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
            min-width: 200px;
            font-size: 12px;
        }

        .dark .pt-adj-popover {
            background: #1f2937;
            border-color: #374151;
        }

        .pt-adj-popover-title {
            font-weight: 700;
            font-size: 12px;
            color: #f97316;
            margin: 0 0 8px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .dark .pt-adj-popover-title {
            color: #fb923c;
        }

        .pt-adj-row {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 4px;
            color: #374151;
        }

        .dark .pt-adj-row {
            color: #d1d5db;
        }

        .pt-adj-row:last-child {
            margin-bottom: 0;
        }

        .pt-adj-label {
            color: #6b7280;
        }

        .dark .pt-adj-label {
            color: #9ca3af;
        }

        .pt-adj-value {
            font-weight: 600;
            color: #111827;
        }

        .dark .pt-adj-value {
            color: #f3f4f6;
        }

        .pt-adj-value-orange {
            font-weight: 600;
            color: #f97316;
        }

        .dark .pt-adj-value-orange {
            color: #fb923c;
        }

        .pt-adj-divider {
            border: none;
            border-top: 1px solid #e5e7eb;
            margin: 6px 0;
        }

        .dark .pt-adj-divider {
            border-color: #374151;
        }
    </style>


    <div wire:loading.remove wire:target="recalculate">

        {{-- Info Kalkulasi --}}
        <div class="pt-card">
            <div class="pt-card-header">
                <h3 class="pt-card-title">Informasi Kalkulasi</h3>
            </div>
            <div class="pt-info-grid">
                <div>
                    <p class="pt-info-label">Kode</p>
                    <p class="pt-info-value">{{ $this->record->calculation_code }}</p>
                </div>
                <div>
                    <p class="pt-info-label">Brand</p>
                    <p class="pt-info-value">{{ $this->record->brand_name }}</p>
                </div>
                <div>
                    <p class="pt-info-label">Layer Category</p>
                    <p class="pt-info-value">{{ ucfirst(str_replace('_', ' ', $this->record->layer_category)) }}</p>
                </div>
                <div>
                    <p class="pt-info-label">Applications</p>
                    <p class="pt-info-value">{{ $this->record->applications->pluck('application_name')->join(', ') ?: '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Tabel Utama --}}
        <div class="pt-card">
            <div class="pt-wrap">
                <table class="pt-table">
                    <thead>
                        <tr class="pt-thead-tr">
                            <th class="pt-th pt-th-left">Diameter</th>
                            <th class="pt-th">Liner</th>
                            <th class="pt-th">Structure</th>
                            <th class="pt-th">External</th>
                            <th class="pt-th">Top Coat</th>
                            <th class="pt-th">Total Thickness Theory</th>
                            <th class="pt-th">Layer</th>
                            <th class="pt-th">Nearest Layer Structure</th>
                            <th class="pt-th">Total Final Thickness (Low)</th>
                            <th class="pt-th">Total Final Thickness (High)</th>
                            <th class="pt-th" style="min-width: 200px;">Pilih Final Thickness</th>
                            <th class="pt-th" style="min-width: 120px;">Thickness Brocure</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->record->details()->orderBy('diameter_mm_snapshot')->get() as $index => $detail)
                        @php
                        // Calculate Total Final Thickness (Low) = Liner + Nearest Layer Structure (bawah) + External + Top Coat
                        $totalFinalLow = $detail->thickness_lower_value
                        ? number_format($detail->thickness_liner + $detail->thickness_lower_value + $detail->thickness_external + $detail->thickness_top_coat, 2)
                        : '-';
                        // Calculate Total Final Thickness (High) = Liner + Nearest Layer Structure (atas) + External + Top Coat
                        $totalFinalHigh = $detail->thickness_upper_value
                        ? number_format($detail->thickness_liner + $detail->thickness_upper_value + $detail->thickness_external + $detail->thickness_top_coat, 2)
                        : '-';
                        @endphp
                        <tr class="{{ $index % 2 === 0 ? 'pt-tr-even' : 'pt-tr-odd' }}">
                            <td class="pt-td pt-td-left">
                                <span class="pt-diameter">DN{{ $detail->diameter_mm_snapshot }}</span>
                                <span class="pt-diameter-sub">({{ $detail->diameter_inch_snapshot }})</span>
                            </td>
                            <td class="pt-td">{{ $detail->thickness_liner }}</td>
                            <td class="pt-td" style="position: relative;">
                                {{ $detail->thickness_structure_used }}

                                @if ($detail->thickness_structure_adjustment > 0)
                                <span
                                    class="pt-adj-trigger"
                                    onclick="toggleAdjPopover(this)"
                                    data-raw="{{ number_format($detail->thickness_structure_raw, 2) }}"
                                    data-adj="{{ number_format($detail->thickness_structure_adjustment, 2) }}"
                                    data-used="{{ number_format($detail->thickness_structure_used, 2) }}">!</span>
                                @endif
                            </td>
                            <td class="pt-td">{{ $detail->thickness_external }}</td>
                            <td class="pt-td">{{ $detail->thickness_top_coat }}</td>
                            <td class="pt-td"><span class="pt-total">{{ $detail->total_thickness }}</span></td>
                            <td class="pt-td">
                                @if ($detail->matched_layer_id)
                                <button class="pt-layer-btn" wire:click="viewLayerDetail({{ $detail->id }})">
                                    <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    {{ $detail->matched_layer_code_snapshot }}
                                </button>
                                @else
                                <span class="pt-no-layer">-</span>
                                @endif
                            </td>
                            {{-- Nearest Layer Structure (statis, tampilkan kedua nilai) --}}
                            <td class="pt-td">
                                @if ($detail->matched_layer_id)
                                <div style="display: flex; flex-direction: column; gap: 2px; align-items: center;">
                                    @if ($detail->thickness_lower_value)
                                    <span style="font-size: 12px; color: #059669; font-weight: 600;">↓ {{ number_format($detail->thickness_lower_value, 2) }} mm</span>
                                    @endif
                                    @if ($detail->thickness_upper_value && $detail->thickness_upper_id != $detail->thickness_lower_id)
                                    <span style="font-size: 12px; color: #7c3aed; font-weight: 600;">↑ {{ number_format($detail->thickness_upper_value, 2) }} mm</span>
                                    @endif
                                </div>
                                @else
                                <span class="pt-no-layer">-</span>
                                @endif
                            </td>
                            {{-- Total Final Thickness (Low) --}}
                            <td class="pt-td">
                                <span style="font-weight: 600; color: #059669;">{{ $totalFinalLow }}</span>
                            </td>
                            {{-- Total Final Thickness (High) --}}
                            <td class="pt-td">
                                <span style="font-weight: 600; color: #7c3aed;">{{ $totalFinalHigh }}</span>
                            </td>
                            {{-- Pilih Final Thickness (Low atau High) --}}
                            <td class="pt-td">
                                @if ($detail->matched_layer_id)
                                @if ($this->isViewMode)
                                @if ($detail->selected_thickness_value)
                                <span class="pt-selected-badge">
                                    {{ number_format($detail->selected_thickness_value, 2) }} mm
                                </span>
                                @else
                                <span class="pt-not-selected">Belum dipilih</span>
                                @endif
                                @else
                                <div style="display: flex; gap: 8px; justify-content: center; flex-wrap: wrap;">
                                    @if ($detail->thickness_lower_id)
                                    <label class="pt-radio-label {{ isset($selections[$detail->id]) && $selections[$detail->id] == $detail->thickness_lower_id ? 'selected' : '' }}">
                                        <input type="radio" wire:model.live="selections.{{ $detail->id }}" value="{{ $detail->thickness_lower_id }}" style="accent-color: #3b82f6;" />
                                        <span class="pt-radio-value">{{ $totalFinalLow }}</span>
                                        <span class="pt-radio-sub">(Low)</span>
                                    </label>
                                    @endif
                                    @if ($detail->thickness_upper_id && $detail->thickness_upper_id != $detail->thickness_lower_id)
                                    <label class="pt-radio-label {{ isset($selections[$detail->id]) && $selections[$detail->id] == $detail->thickness_upper_id ? 'selected' : '' }}">
                                        <input type="radio" wire:model.live="selections.{{ $detail->id }}" value="{{ $detail->thickness_upper_id }}" style="accent-color: #3b82f6;" />
                                        <span class="pt-radio-value">{{ $totalFinalHigh }}</span>
                                        <span class="pt-radio-sub">(High)</span>
                                    </label>
                                    @endif
                                </div>
                                @endif
                                @else
                                <span class="pt-no-layer">Tidak ada layer</span>
                                @endif
                            </td>
                            {{-- Thickness Brocure --}}
                            <td class="pt-td">
                                @if (!$this->isViewMode)
                                <input
                                    type="number"
                                    step="0.01"
                                    wire:model.lazy="thicknessBrocure.{{ $detail->id }}"
                                    style="width: 80px; padding: 4px 8px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 12px; text-align: center;"
                                    placeholder="mm" />
                                @else
                                <span style="font-weight: 600;">{{ $detail->thickness_brocure ? number_format($detail->thickness_brocure, 2) . ' mm' : '-' }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal Layer Detail --}}
        @if ($showLayerModal)
        @php
        $modalDetail = $this->getSelectedDetail();
        $modalLayer = $this->getSelectedLayer();
        $maxStage = 0;
        $maxStep = 7;
        if ($modalLayer) {
        foreach ($modalLayer->thicknesses as $t) {
        $stageMax = $t->details->max('stage_number') ?? 0;
        $maxStage = max($maxStage, $stageMax);
        }
        }
        $d1 = $modalLayer?->diameter1?->diameter_mm;
        $d2 = $modalLayer?->diameter2?->diameter_mm;
        $op = $modalLayer?->operator;
        $param = match($op) {
        '<'=> "< {$d1} mm", '>'=> "> {$d1} mm",
                'between' => "{$d1} mm - {$d2} mm",
                default => '-',
                };
                @endphp
                <div class="modal-overlay" wire:click.self="closeLayerModal">
                    <div class="modal-box">
                        <div class="modal-header">
                            <div>
                                <h3 class="modal-title">Layer: {{ $modalLayer?->layer_code ?? '-' }}</h3>
                                <p class="modal-subtitle">
                                    DN{{ $modalDetail?->diameter_mm_snapshot }} ({{ $modalDetail?->diameter_inch_snapshot }})
                                    — Total: <strong style="color: #f97316;">{{ $modalDetail?->total_thickness }} mm</strong>
                                    — Parameter: {{ $param }}
                                </p>
                            </div>
                            <button class="modal-close-btn" wire:click="closeLayerModal">
                                <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        @php
                        $selectedVal = $modalDetail?->selected_thickness_value
                        ?? \App\Models\MasterLayerThickness::find($selections[$modalDetail?->id] ?? null)?->thickness;
                        @endphp
                        @if ($selectedVal)
                        <div class="modal-selected-bar">
                            ✓ Thickness dipilih: {{ number_format($selectedVal, 2) }} mm
                        </div>
                        @endif

                        <div class="modal-body">
                            @if ($modalLayer && $maxStage > 0)
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
                                                @for ($step=1; $step <=$maxStep; $step++)
                                                <th class="lm-th-step {{ $step === 1 ? 'lm-stage-sep' : '' }}">
                                                {{ $step }}
                                                </th>
                                                @endfor
                                                @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($modalLayer->thicknesses as $tIdx => $thickness)
                                        @php
                                        $detailMap = [];
                                        foreach ($thickness->details as $det) {
                                        $detailMap[$det->stage_number][$det->step_number] = $det;
                                        }
                                        $rowClass = $tIdx % 2 === 0 ? 'lm-td-even' : 'lm-td-odd';
                                        $selectedThicknessId = $modalDetail?->selected_thickness_id
                                        ?? ($selections[$modalDetail?->id] ?? null);
                                        $isSelected = $selectedThicknessId && $thickness->id == $selectedThicknessId;
                                        @endphp
                                        <tr>
                                            <td class="lm-td-label {{ $rowClass }} {{ $isSelected ? 'lm-selected-label' : '' }}">
                                                {{ number_format($thickness->thickness, 2) }}
                                                @if ($isSelected)
                                                <span class="lm-selected-badge">dipilih</span>
                                                @endif
                                            </td>
                                            <td class="lm-td-label {{ $rowClass }}">{{ $param }}</td>
                                            @for ($stage = 1; $stage <= $maxStage; $stage++)
                                                @for ($step=1; $step <=$maxStep; $step++)
                                                @php
                                                $det=$detailMap[$stage][$step] ?? null;
                                                $hasValue=$det && $det->material_type_id;
                                                @endphp
                                                <td class="{{ $rowClass }} {{ $step === 1 ? 'lm-stage-sep' : '' }}">
                                                    @if ($hasValue)
                                                    <span class="lm-val">{{ $det->materialType?->type_code ?? '-' }}</span>
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
                            @else
                            <p class="pt-no-layer" style="text-align: center; padding: 32px 0;">Tidak ada data layer matrix.</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

    </div>


    <script>
        let activePopover = null;
        let activeTrigger = null;

        function positionPopover(trigger, popover) {
            const rect = trigger.getBoundingClientRect();
            const popW = popover.offsetWidth || 220;
            const popH = popover.offsetHeight || 120;

            let left = rect.right + 8;
            let top = rect.top + (rect.height / 2) - (popH / 2);

            // Jika terlalu ke kanan, tampilkan ke kiri
            if (left + popW > window.innerWidth - 16) {
                left = rect.left - popW - 8;
            }

            // Jika terlalu ke bawah
            if (top + popH > window.innerHeight - 16) {
                top = window.innerHeight - popH - 16;
            }

            // Jika terlalu ke atas
            if (top < 8) top = 8;

            popover.style.left = left + 'px';
            popover.style.top = top + 'px';
        }

        function toggleAdjPopover(trigger) {
            // Kalau klik trigger yang sama, tutup
            if (activePopover && activeTrigger === trigger) {
                closePopover();
                return;
            }

            // Tutup yang lama dulu
            closePopover();

            const raw = trigger.dataset.raw;
            const adj = trigger.dataset.adj;
            const used = trigger.dataset.used;

            const popover = document.createElement('div');
            popover.className = 'pt-adj-popover';
            popover.innerHTML = `
        <p class="pt-adj-popover-title">⚠ Structure Adjusted</p>
        <div class="pt-adj-row">
            <span class="pt-adj-label">Raw (hasil hitung)</span>
            <span class="pt-adj-value">${raw} mm</span>
        </div>
        <hr class="pt-adj-divider">
        <div class="pt-adj-row">
            <span class="pt-adj-label">Penambahan</span>
            <span class="pt-adj-value-orange">+${adj} mm</span>
        </div>
        <hr class="pt-adj-divider">
        <div class="pt-adj-row">
            <span class="pt-adj-label">Final (dipakai)</span>
            <span class="pt-adj-value">${used} mm</span>
        </div>
    `;

            // Render dulu biar bisa ukur tingginya
            popover.style.visibility = 'hidden';
            popover.style.position = 'fixed';
            document.body.appendChild(popover);

            // Posisikan setelah render
            requestAnimationFrame(() => {
                positionPopover(trigger, popover);
                popover.style.visibility = 'visible';
            });

            activePopover = popover;
            activeTrigger = trigger;
        }

        function closePopover() {
            if (activePopover) {
                activePopover.remove();
                activePopover = null;
                activeTrigger = null;
            }
        }

        // Tutup saat klik di luar
        document.addEventListener('click', function(e) {
            if (
                activePopover &&
                !activePopover.contains(e.target) &&
                !e.target.classList.contains('pt-adj-trigger')
            ) {
                closePopover();
            }
        });

        // Reposisi saat scroll (pakai capture agar tangkap scroll di dalam elemen)
        document.addEventListener('scroll', function() {
            if (activePopover && activeTrigger) {
                positionPopover(activeTrigger, activePopover);
            }
        }, true);

        // Tutup saat Livewire navigasi/update
        document.addEventListener('livewire:navigating', closePopover);
    </script>
</x-filament-panels::page>