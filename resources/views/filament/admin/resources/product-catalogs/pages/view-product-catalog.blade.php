<x-filament-panels::page>

    <style>
    .pc-card {
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb;
        overflow: hidden;
        margin-bottom: 16px;
    }
    .dark .pc-card { border-color: #374151; }

    .pc-card-header {
        background: #f9fafb;
        padding: 12px 16px;
        border-bottom: 1px solid #e5e7eb;
    }
    .dark .pc-card-header { background: #1f2937; border-color: #374151; }

    .pc-card-title {
        font-weight: 600;
        font-size: 14px;
        color: #111827;
        margin: 0;
    }
    .dark .pc-card-title { color: #f9fafb; }

    .pc-info-grid {
        padding: 16px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }

    .pc-info-label {
        font-size: 11px;
        color: #6b7280;
        text-transform: uppercase;
        font-weight: 600;
        margin: 0 0 2px;
    }
    .dark .pc-info-label { color: #9ca3af; }

    .pc-info-value {
        font-size: 13px;
        color: #111827;
        font-weight: 500;
        margin: 0;
    }
    .dark .pc-info-value { color: #f3f4f6; }

    .pc-wrap { overflow-x: auto; width: 100%; }

    .pc-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .pc-thead-tr {
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
    }
    .dark .pc-thead-tr { background: #1f2937; border-color: #374151; }

    .pc-th {
        padding: 10px 8px;
        font-weight: 600;
        color: #374151;
        text-align: center;
        white-space: nowrap;
    }
    .dark .pc-th { color: #d1d5db; }

    .pc-th-left { text-align: left; padding: 10px 16px; }

    .pc-tr-even { background: #ffffff; border-bottom: 1px solid #f3f4f6; }
    .dark .pc-tr-even { background: #1f2937; border-color: #374151; }

    .pc-tr-odd { background: #f9fafb; border-bottom: 1px solid #f3f4f6; }
    .dark .pc-tr-odd { background: #111827; border-color: #374151; }

    .pc-td { text-align: center; padding: 10px 8px; color: #374151; }
    .dark .pc-td { color: #d1d5db; }

    .pc-td-left { text-align: left; padding: 10px 16px; }

    .pc-diameter {
        font-weight: 600;
        color: #111827;
        font-size: 13px;
    }
    .dark .pc-diameter { color: #f3f4f6; }

    .pc-diameter-sub { font-size: 11px; color: #6b7280; }
    .dark .pc-diameter-sub { color: #9ca3af; }

    .pc-total { font-weight: 700; color: #f97316; }
    .dark .pc-total { color: #fb923c; }

    .pc-brocure { font-weight: 700; color: #2563eb; }
    .dark .pc-brocure { color: #60a5fa; }

    .pc-note {
        padding: 12px 16px;
        background: #fffbeb;
        border: 1px solid #fcd34d;
        border-radius: 8px;
        margin-bottom: 16px;
        font-size: 12px;
        color: #92400e;
    }
    .dark .pc-note { background: #451a03; border-color: #d97706; color: #fcd34d; }
    </style>

    {{-- Informasi Kalkulasi --}}
    <div class="pc-card">
        <div class="pc-card-header">
            <h3 class="pc-card-title">Informasi Kalkulasi</h3>
        </div>
        <div class="pc-info-grid">
            <div>
                <p class="pc-info-label">Brand Name</p>
                <p class="pc-info-value">{{ $this->record->brand_name }}</p>
            </div>
            <div>
                <p class="pc-info-label">Layer Category</p>
                <p class="pc-info-value">{{ ucfirst(str_replace('_', ' ', $this->record->layer_category)) }}</p>
            </div>
            <div>
                <p class="pc-info-label">Liner</p>
                <p class="pc-info-value">
                    @php
                        $liner = $this->record->liner;
                        $corrosionMap = [1 => 'Low', 2 => 'Medium', 3 => 'High'];
                        $tempMap = [1 => 'Low', 2 => 'Medium', 3 => 'High'];
                    @endphp
                    @if ($liner)
                        Corrosion: {{ $corrosionMap[$liner->corrosion] ?? '-' }} | Temp: {{ $tempMap[$liner->temprature] ?? '-' }}
                    @else
                        -
                    @endif
                </p>
            </div>
            <div>
                <p class="pc-info-label">Applications</p>
                <p class="pc-info-value">
                    {{ $this->record->applications->pluck('application_name')->join(', ') ?: '-' }}
                </p>
            </div>
        </div>
    </div>

    <div class="pc-note">
        <strong>Note:</strong> Standard ORI Pipe — Data ini merupakan hasil dari Process Calculation. Thickness yang ditampilkan berdasarkan Nearest Layer Structure yang telah dipilih.
    </div>

    {{-- Tabel Detail Thickness --}}
    <div class="pc-card">
        <div class="pc-card-header">
            <h3 class="pc-card-title">Detail Thickness per Diameter</h3>
        </div>
        <div class="pc-wrap">
            <table class="pc-table">
                <thead>
                    <tr class="pc-thead-tr">
                        <th class="pc-th pc-th-left">Diameter</th>
                        <th class="pc-th">Liner</th>
                        <th class="pc-th">Structure (Nearest Layer)</th>
                        <th class="pc-th">External</th>
                        <th class="pc-th">Top Coat</th>
                        <th class="pc-th">Total Thickness Theory</th>
                        <th class="pc-th">Total Final Thickness</th>
                        <th class="pc-th">Thickness Brocure</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->record->details()->orderBy('diameter_mm_snapshot')->get() as $index => $detail)
                        @php
                            $selectedStructure = $detail->selected_thickness_value ?? 0;
                            $totalFinal = $detail->thickness_liner + $selectedStructure + $detail->thickness_external + $detail->thickness_top_coat;
                        @endphp
                        <tr class="{{ $index % 2 === 0 ? 'pc-tr-even' : 'pc-tr-odd' }}">
                            <td class="pc-td pc-td-left">
                                <span class="pc-diameter">DN{{ $detail->diameter_mm_snapshot }}</span>
                                <span class="pc-diameter-sub">({{ $detail->diameter_inch_snapshot }})</span>
                            </td>
                            <td class="pc-td">{{ number_format($detail->thickness_liner, 2) }}</td>
                            <td class="pc-td">
                                @if ($detail->selected_thickness_value)
                                    {{ number_format($detail->selected_thickness_value, 2) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="pc-td">{{ number_format($detail->thickness_external, 2) }}</td>
                            <td class="pc-td">{{ number_format($detail->thickness_top_coat, 2) }}</td>
                            <td class="pc-td"><span class="pc-total">{{ number_format($detail->total_thickness, 2) }}</span></td>
                            <td class="pc-td">
                                <span class="pc-total">{{ number_format($totalFinal, 2) }}</span>
                            </td>
                            <td class="pc-td">
                                @if ($detail->thickness_brocure)
                                    <span class="pc-brocure">{{ number_format($detail->thickness_brocure, 2) }}</span>
                                @else
                                    <span style="color: #9ca3af;">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-filament-panels::page>
