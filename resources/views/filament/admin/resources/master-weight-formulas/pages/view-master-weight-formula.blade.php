<x-filament-panels::page>

<style>
.mwf-card {
    border-radius: 0.75rem;
    border: 1px solid #e5e7eb;
    overflow: hidden;
    margin-bottom: 6px;
}
.dark .mwf-card { border-color: #374151; }

.mwf-card-header {
    background: #f9fafb;
    padding: 12px 16px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    gap: 8px;
}
.dark .mwf-card-header { background: #1f2937; border-color: #374151; }

.mwf-card-title {
    font-weight: 600;
    font-size: 14px;
    color: #111827;
    margin: 0;
}
.dark .mwf-card-title { color: #f9fafb; }

.mwf-card-badge {
    padding: 2px 8px;
    border-radius: 9999px;
    font-size: 11px;
    font-weight: 600;
}
.mwf-badge-pipe { background: #d1fae5; color: #065f46; }
.dark .mwf-badge-pipe { background: #022c22; color: #6ee7b7; }
.mwf-badge-fitting { background: #fef3c7; color: #92400e; }
.dark .mwf-badge-fitting { background: #451a03; color: #fcd34d; }

.mwf-info-grid {
    padding: 16px;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
}

.mwf-info-label {
    font-size: 11px;
    color: #6b7280;
    text-transform: uppercase;
    font-weight: 600;
    margin: 0 0 2px;
}
.dark .mwf-info-label { color: #9ca3af; }

.mwf-info-value {
    font-size: 13px;
    color: #111827;
    font-weight: 500;
    margin: 0;
}
.dark .mwf-info-value { color: #f3f4f6; }

.mwf-section {
    padding: 16px;
}

.mwf-section-title {
    font-size: 13px;
    font-weight: 700;
    color: #374151;
    margin: 0 0 12px;
    padding-bottom: 6px;
    border-bottom: 1px solid #e5e7eb;
}
.dark .mwf-section-title { color: #d1d5db; border-color: #374151; }

.mwf-formula-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
}

.mwf-formula-table th {
    text-align: left;
    padding: 8px 12px;
    background: #f3f4f6;
    color: #374151;
    font-weight: 600;
    border: 1px solid #e5e7eb;
}
.dark .mwf-formula-table th { background: #1f2937; color: #d1d5db; border-color: #374151; }

.mwf-formula-table td {
    padding: 8px 12px;
    border: 1px solid #e5e7eb;
    color: #374151;
    vertical-align: top;
}
.dark .mwf-formula-table td { border-color: #374151; color: #d1d5db; }

.mwf-formula-code {
    font-family: 'Fira Code', 'JetBrains Mono', monospace;
    font-size: 11px;
    background: #f9fafb;
    padding: 4px 8px;
    border-radius: 4px;
    color: #7c3aed;
    white-space: pre-wrap;
    word-break: break-word;
}
.dark .mwf-formula-code { background: #111827; color: #a78bfa; }

.mwf-label {
    font-weight: 600;
    color: #111827;
    white-space: nowrap;
}
.dark .mwf-label { color: #f3f4f6; }

.mwf-sub-label {
    font-weight: 500;
    color: #6b7280;
    padding-left: 16px;
}
.dark .mwf-sub-label { color: #9ca3af; }

.mwf-note {
    padding: 10px 16px;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 8px;
    margin-bottom: 6px;
    font-size: 12px;
    color: #1d4ed8;
}
.dark .mwf-note { background: #1e3a5f; border-color: #1d4ed8; color: #60a5fa; }

.fi-page-content {
    row-gap: calc(var(--spacing) * 5)
}
</style>

<div class="mwf-note">
    <strong>ℹ️ View Only</strong> — Data formula ini hanya bisa diubah oleh Super Admin.
</div>

{{-- Header Info --}}
<div class="mwf-card">
    <div class="mwf-card-header">
        <h3 class="mwf-card-title">Informasi Formula</h3>
        <span class="mwf-card-badge {{ $record->formula_type === 'pipe' ? 'mwf-badge-pipe' : 'mwf-badge-fitting' }}">
            {{ ucfirst($record->formula_type) }}
        </span>
    </div>
    <div class="mwf-info-grid">
        <div>
            <p class="mwf-info-label">Code</p>
            <p class="mwf-info-value">{{ $record->formula_code }}</p>
        </div>
        <div>
            <p class="mwf-info-label">Formula Name</p>
            <p class="mwf-info-value">{{ $record->formula_name }}</p>
        </div>
        <div>
            <p class="mwf-info-label">Tipe Formula</p>
            <p class="mwf-info-value">{{ ucfirst($record->formula_type) }}</p>
        </div>
    </div>
</div>

{{-- Fitting Parameters (only for fitting type) --}}
@if ($record->formula_type === 'fitting' && $record->fitting_params)
<div class="mwf-card">
    <div class="mwf-card-header">
        <h3 class="mwf-card-title">Parameter Fitting</h3>
    </div>
    <div class="mwf-section">
        <table class="mwf-formula-table">
            <thead>
                <tr>
                    <th style="width: 200px;">Parameter</th>
                    <th>Formula</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($record->fitting_params as $key => $value)
                <tr>
                    <td class="mwf-label">{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                    <td><span class="mwf-formula-code">{{ $value }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Waste Pipe (only for pipe type) --}}
@if ($record->formula_type === 'pipe' && $record->waste_pipe)
<div class="mwf-card">
    <div class="mwf-card-header">
        <h3 class="mwf-card-title">Waste Pipe</h3>
    </div>
    <div class="mwf-section">
        <table class="mwf-formula-table">
            <thead>
                <tr>
                    <th style="width: 200px;">Parameter</th>
                    <th>Rumus / Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($record->waste_pipe as $key => $data)
                <tr>
                    <td class="mwf-label">{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                    <td>
                        @if (is_array($data) && isset($data['rumus']))
                            <span class="mwf-formula-code">{{ $data['rumus'] }}</span>
                        @elseif (is_array($data))
                            <span class="mwf-formula-code">{{ json_encode($data, JSON_PRETTY_PRINT) }}</span>
                        @else
                            <span class="mwf-formula-code">{{ $data }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Luas Area --}}
@if ($record->luas_area)
<div class="mwf-card">
    <div class="mwf-card-header">
        <h3 class="mwf-card-title">Luas Area</h3>
    </div>
    <div class="mwf-section">
        <table class="mwf-formula-table">
            <thead>
                <tr>
                    <th style="width: 200px;">Parameter</th>
                    <th>Rumus</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="mwf-label">Rumus</td>
                    <td><span class="mwf-formula-code">{{ $record->luas_area['rumus'] ?? '-' }}</span></td>
                </tr>
                @if (isset($record->luas_area['note']))
                <tr>
                    <td class="mwf-label">Note</td>
                    <td>{{ $record->luas_area['note'] }}</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Setting FW (only for pipe type) --}}
@if ($record->formula_type === 'pipe' && $record->setting_fw)
<div class="mwf-card">
    <div class="mwf-card-header">
        <h3 class="mwf-card-title">Setting Filament Winding</h3>
    </div>
    <div class="mwf-section">
        <table class="mwf-formula-table">
            <thead>
                <tr>
                    <th>Diameter Range</th>
                    <th>Thickness Per Layer</th>
                    <th>Bandwidth</th>
                    <th>Jumlah Benang</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($record->setting_fw['ranges'] ?? [] as $range)
                <tr>
                    <td class="mwf-label">{{ $range['label'] }}</td>
                    <td><span class="mwf-formula-code">{{ $range['thickness_per_layer'] }}</span></td>
                    <td>{{ $range['bandwidth'] }}</td>
                    <td>{{ $range['jumlah_benang'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Resin Contain --}}
@if ($record->resin_contain)
<div class="mwf-card">
    <div class="mwf-card-header">
        <h3 class="mwf-card-title">Resin Contain (Standard Ratio)</h3>
    </div>
    <div class="mwf-section">
        <table class="mwf-formula-table">
            <thead>
                <tr>
                    <th style="width: 120px;">Section</th>
                    <th style="width: 150px;">Material</th>
                    <th>Ratio</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($record->resin_contain as $section => $materials)
                    @foreach ($materials as $material => $ratio)
                    <tr>
                        @if ($loop->first)
                            <td class="mwf-label" rowspan="{{ count($materials) }}">{{ ucfirst($section) }}</td>
                        @endif
                        <td class="mwf-sub-label">{{ ucwords(str_replace('_', ' ', $material)) }}</td>
                        <td><span class="mwf-formula-code">{{ $ratio }}</span></td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Glass Config --}}
@if ($record->glass_config)
<div class="mwf-card">
    <div class="mwf-card-header">
        <h3 class="mwf-card-title">Konfigurasi Glass (Jumlah Layer)</h3>
    </div>
    <div class="mwf-section">
        <table class="mwf-formula-table">
            <thead>
                <tr>
                    <th style="width: 120px;">Section</th>
                    <th style="width: 150px;">Material</th>
                    <th>Sumber</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($record->glass_config as $section => $materials)
                    @foreach ($materials as $material => $source)
                    <tr>
                        @if ($loop->first)
                            <td class="mwf-label" rowspan="{{ count($materials) }}">{{ ucfirst($section) }}</td>
                        @endif
                        <td class="mwf-sub-label">{{ ucwords(str_replace('_', ' ', $material)) }}</td>
                        <td><span class="mwf-formula-code">{{ $source }}</span></td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Glass Weight --}}
@if ($record->glass_weight)
<div class="mwf-card">
    <div class="mwf-card-header">
        <h3 class="mwf-card-title">Glass Weight</h3>
    </div>
    <div class="mwf-section">
        <table class="mwf-formula-table">
            <thead>
                <tr>
                    <th style="width: 120px;">Section</th>
                    <th style="width: 150px;">Material</th>
                    <th>Rumus</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($record->glass_weight as $section => $data)
                    @if (is_array($data))
                        @foreach ($data as $material => $formula)
                        <tr>
                            @if ($loop->first)
                                <td class="mwf-label" rowspan="{{ count($data) }}">{{ ucfirst($section) }}</td>
                            @endif
                            <td class="mwf-sub-label">{{ ucwords(str_replace('_', ' ', $material)) }}</td>
                            <td><span class="mwf-formula-code">{{ $formula }}</span></td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="mwf-label" colspan="2">{{ ucfirst($section) }}</td>
                            <td><span class="mwf-formula-code">{{ $data }}</span></td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Resin Weight --}}
@if ($record->resin_weight)
<div class="mwf-card">
    <div class="mwf-card-header">
        <h3 class="mwf-card-title">Resin Weight</h3>
    </div>
    <div class="mwf-section">
        <table class="mwf-formula-table">
            <thead>
                <tr>
                    <th style="width: 200px;">Komponen</th>
                    <th>Rumus</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($record->resin_weight as $key => $formula)
                <tr>
                    <td class="mwf-label">{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                    <td><span class="mwf-formula-code">{{ $formula }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Additive --}}
@if ($record->additive)
<div class="mwf-card">
    <div class="mwf-card-header">
        <h3 class="mwf-card-title">Additive</h3>
    </div>
    <div class="mwf-section">
        <table class="mwf-formula-table">
            <thead>
                <tr>
                    <th style="width: 220px;">Komponen</th>
                    <th>Rumus</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($record->additive as $key => $formula)
                <tr>
                    <td class="mwf-label">{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                    <td><span class="mwf-formula-code">{{ $formula }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Mirror Glaze --}}
@if ($record->mirror_glaze)
<div class="mwf-card">
    <div class="mwf-card-header">
        <h3 class="mwf-card-title">Mirror Glaze</h3>
    </div>
    <div class="mwf-section">
        <table class="mwf-formula-table">
            <thead>
                <tr>
                    <th style="width: 200px;">Parameter</th>
                    <th>Rumus</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="mwf-label">Mirror Glaze</td>
                    <td><span class="mwf-formula-code">{{ $record->mirror_glaze['rumus'] ?? '-' }}</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Additional Additive --}}
@if ($record->additional_additive)
<div class="mwf-card">
    <div class="mwf-card-header">
        <h3 class="mwf-card-title">Additional Additive</h3>
    </div>
    <div class="mwf-section">
        <table class="mwf-formula-table">
            <thead>
                <tr>
                    <th style="width: 180px;">Kategori</th>
                    <th style="width: 150px;">Komponen</th>
                    <th>Rumus</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($record->additional_additive as $category => $data)
                    @if (is_array($data))
                        @foreach ($data as $component => $formula)
                        <tr>
                            @if ($loop->first)
                                <td class="mwf-label" rowspan="{{ count($data) }}">{{ ucwords(str_replace('_', ' ', $category)) }}</td>
                            @endif
                            <td class="mwf-sub-label">{{ ucwords(str_replace('_', ' ', $component)) }}</td>
                            <td><span class="mwf-formula-code">{{ $formula }}</span></td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="mwf-label" colspan="2">{{ ucwords(str_replace('_', ' ', $category)) }}</td>
                            <td><span class="mwf-formula-code">{{ $data }}</span></td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Total Weight --}}
@if ($record->total_weight)
<div class="mwf-card">
    <div class="mwf-card-header">
        <h3 class="mwf-card-title">Total Berat</h3>
    </div>
    <div class="mwf-section">
        <table class="mwf-formula-table">
            <thead>
                <tr>
                    <th style="width: 200px;">Parameter</th>
                    <th>Rumus</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="mwf-label">Total Berat</td>
                    <td><span class="mwf-formula-code">{{ $record->total_weight['rumus'] ?? '-' }}</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endif

</x-filament-panels::page>
