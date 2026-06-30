<x-filament-panels::page>

<style>
.ef-card {
    border-radius: 0.75rem;
    border: 1px solid #e5e7eb;
    overflow: hidden;
    margin-bottom: 6px;
}
.dark .ef-card { border-color: #374151; }

.ef-card-header {
    background: #f9fafb;
    padding: 12px 16px;
    border-bottom: 1px solid #e5e7eb;
}
.dark .ef-card-header { background: #1f2937; border-color: #374151; }

.ef-card-title {
    font-weight: 600;
    font-size: 14px;
    color: #111827;
    margin: 0;
}
.dark .ef-card-title { color: #f9fafb; }

.ef-section {
    padding: 16px;
}

.ef-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}

.ef-grid-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
}

.ef-field {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.ef-label {
    font-size: 11px;
    color: #6b7280;
    font-weight: 600;
    text-transform: uppercase;
}
.dark .ef-label { color: #9ca3af; }

.ef-input {
    padding: 8px 12px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 13px;
    color: #111827;
    background: #fff;
    width: 100%;
}
.dark .ef-input { background: #1f2937; border-color: #4b5563; color: #f3f4f6; }
.ef-input:focus { outline: none; border-color: #f97316; box-shadow: 0 0 0 2px rgba(249, 115, 22, 0.1); }

.ef-input-disabled {
    background: #f3f4f6 !important;
    color: #6b7280 !important;
    cursor: not-allowed;
}
.dark .ef-input-disabled {
    background: #374151 !important;
    color: #9ca3af !important;
    border-color: #4b5563 !important;
}

.ef-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}
.ef-table th {
    text-align: left;
    padding: 8px 12px;
    background: #f3f4f6;
    color: #374151;
    font-weight: 600;
    border: 1px solid #e5e7eb;
}
.dark .ef-table th { background: #1f2937; color: #d1d5db; border-color: #374151; }
.ef-table td {
    padding: 8px 12px;
    border: 1px solid #e5e7eb;
    vertical-align: middle;
}
.dark .ef-table td { border-color: #374151; }

.ef-sub-title {
    font-size: 12px;
    font-weight: 600;
    color: #6b7280;
    margin: 12px 0 8px;
    padding-left: 4px;
}
.dark .ef-sub-title { color: #9ca3af; }
</style>

{{-- Header Info --}}
<div class="ef-card">
    <div class="ef-card-header">
        <h3 class="ef-card-title">Informasi Formula</h3>
    </div>
    <div class="ef-section">
        <div class="ef-grid-3">
            <div class="ef-field">
                <label class="ef-label">Code</label>
                <input type="text" class="ef-input ef-input-disabled" value="{{ $record->formula_code }}" disabled>
            </div>
            <div class="ef-field">
                <label class="ef-label">Formula Name</label>
                <input type="text" class="ef-input" wire:model.lazy="formula_name">
            </div>
            <div class="ef-field">
                <label class="ef-label">Tipe Formula</label>
                <select class="ef-input" wire:model.live="formula_type">
                    <option value="pipe">Pipe</option>
                    <option value="fitting">Fitting</option>
                </select>
            </div>
        </div>
    </div>
</div>

{{-- Fitting Params (only for fitting) --}}
@if ($formula_type === 'fitting')
<div class="ef-card">
    <div class="ef-card-header">
        <h3 class="ef-card-title">Parameter Fitting</h3>
    </div>
    <div class="ef-section">
        <table class="ef-table">
            <thead>
                <tr>
                    <th style="width: 220px;">Parameter</th>
                    <th>Rumus / Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fitting_params as $key => $value)
                <tr>
                    <td style="font-weight: 600;">{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                    <td><input type="text" class="ef-input" wire:model.lazy="fitting_params.{{ $key }}"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Waste Pipe (only for pipe) --}}
@if ($formula_type === 'pipe' && !empty($waste_pipe))
<div class="ef-card">
    <div class="ef-card-header">
        <h3 class="ef-card-title">Waste Pipe</h3>
    </div>
    <div class="ef-section">
        {{-- Waste Potongan --}}
        @if (isset($waste_pipe['waste_potongan']))
        <p class="ef-sub-title">Waste Potongan</p>
        <div class="ef-grid-3" style="grid-template-columns: 1.5fr 1fr 1fr;">
            <div class="ef-field">
                <label class="ef-label">Rumus</label>
                <input type="text" class="ef-input" wire:model.lazy="waste_pipe.waste_potongan.rumus">
            </div>
            <div class="ef-field">
                <label class="ef-label">Lokal (mm)</label>
                <input type="number" class="ef-input" wire:model.lazy="waste_pipe.waste_potongan.lokal">
            </div>
            <div class="ef-field">
                <label class="ef-label">Ekspor (mm)</label>
                <input type="number" class="ef-input" wire:model.lazy="waste_pipe.waste_potongan.ekspor">
            </div>
        </div>
        @endif

        {{-- Waste Ceceran --}}
        @if (isset($waste_pipe['waste_ceceran']))
        <p class="ef-sub-title">Waste Ceceran</p>
        <table class="ef-table">
            <thead><tr><th>DN Min</th><th>DN Max</th><th>Value (%)</th></tr></thead>
            <tbody>
                @foreach ($waste_pipe['waste_ceceran']['ranges'] ?? [] as $idx => $range)
                <tr>
                    <td><input type="number" class="ef-input" wire:model.lazy="waste_pipe.waste_ceceran.ranges.{{ $idx }}.dn_min"></td>
                    <td><input type="number" class="ef-input" wire:model.lazy="waste_pipe.waste_ceceran.ranges.{{ $idx }}.dn_max"></td>
                    <td><input type="number" step="0.01" class="ef-input" wire:model.lazy="waste_pipe.waste_ceceran.ranges.{{ $idx }}.value"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        {{-- Waste Diptank --}}
        @if (isset($waste_pipe['waste_diptank']))
        <p class="ef-sub-title">Waste Diptank</p>
        <table class="ef-table">
            <thead><tr><th>DN Min</th><th>DN Max</th><th>Value (%)</th></tr></thead>
            <tbody>
                @foreach ($waste_pipe['waste_diptank']['ranges'] ?? [] as $idx => $range)
                <tr>
                    <td><input type="number" class="ef-input" wire:model.lazy="waste_pipe.waste_diptank.ranges.{{ $idx }}.dn_min"></td>
                    <td><input type="number" class="ef-input" wire:model.lazy="waste_pipe.waste_diptank.ranges.{{ $idx }}.dn_max"></td>
                    <td><input type="number" step="0.01" class="ef-input" wire:model.lazy="waste_pipe.waste_diptank.ranges.{{ $idx }}.value"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        {{-- Glass Overlap --}}
        @if (isset($waste_pipe['glass_overlap']))
        <p class="ef-sub-title">Glass Overlap</p>
        <div class="ef-grid">
            <div class="ef-field">
                <label class="ef-label">Overlap Glass</label>
                <input type="number" step="0.01" class="ef-input" wire:model.lazy="waste_pipe.glass_overlap.overlap_glass">
            </div>
            <div class="ef-field">
                <label class="ef-label">Factor Overlap Glass</label>
                <input type="number" step="0.01" class="ef-input" wire:model.lazy="waste_pipe.glass_overlap.factor_overlap_glass">
            </div>
        </div>
        @endif
    </div>
</div>
@endif

{{-- Luas Area --}}
@if (!empty($luas_area))
<div class="ef-card">
    <div class="ef-card-header">
        <h3 class="ef-card-title">Luas Area</h3>
    </div>
    <div class="ef-section">
        <div class="ef-field">
            <label class="ef-label">Rumus</label>
            <input type="text" class="ef-input" wire:model.lazy="luas_area.rumus">
        </div>
        @if (isset($luas_area['note']))
        <div class="ef-field" style="margin-top: 8px;">
            <label class="ef-label">Note</label>
            <input type="text" class="ef-input" wire:model.lazy="luas_area.note">
        </div>
        @endif
    </div>
</div>
@endif

{{-- Setting FW (pipe only) --}}
@if ($formula_type === 'pipe' && !empty($setting_fw))
<div class="ef-card">
    <div class="ef-card-header">
        <h3 class="ef-card-title">Setting Filament Winding</h3>
    </div>
    <div class="ef-section">
        <table class="ef-table">
            <thead>
                <tr>
                    <th>Diameter Range</th>
                    <th>Thickness Per Layer</th>
                    <th>Bandwidth</th>
                    <th>Jumlah Benang</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($setting_fw['ranges'] ?? [] as $idx => $range)
                <tr>
                    <td><input type="text" class="ef-input" wire:model.lazy="setting_fw.ranges.{{ $idx }}.label"></td>
                    <td><input type="number" step="0.01" class="ef-input" wire:model.lazy="setting_fw.ranges.{{ $idx }}.thickness_per_layer"></td>
                    <td><input type="number" class="ef-input" wire:model.lazy="setting_fw.ranges.{{ $idx }}.bandwidth"></td>
                    <td><input type="number" class="ef-input" wire:model.lazy="setting_fw.ranges.{{ $idx }}.jumlah_benang"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Resin Contain --}}
@if (!empty($resin_contain))
<div class="ef-card">
    <div class="ef-card-header">
        <h3 class="ef-card-title">Resin Contain (Standard Ratio)</h3>
    </div>
    <div class="ef-section">
        <table class="ef-table">
            <thead><tr><th>Section</th><th>Material</th><th>Ratio</th></tr></thead>
            <tbody>
                @foreach ($resin_contain as $section => $materials)
                    @foreach ($materials as $material => $ratio)
                    <tr>
                        @if ($loop->first)
                            <td style="font-weight: 600;" rowspan="{{ count($materials) }}">{{ ucfirst($section) }}</td>
                        @endif
                        <td>{{ ucwords(str_replace('_', ' ', $material)) }}</td>
                        <td><input type="text" class="ef-input" wire:model.lazy="resin_contain.{{ $section }}.{{ $material }}"></td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Glass Weight --}}
@if (!empty($glass_weight))
<div class="ef-card">
    <div class="ef-card-header">
        <h3 class="ef-card-title">Glass Weight</h3>
    </div>
    <div class="ef-section">
        <table class="ef-table">
            <thead><tr><th>Section</th><th>Material</th><th>Rumus</th></tr></thead>
            <tbody>
                @foreach ($glass_weight as $section => $data)
                    @if (is_array($data))
                        @foreach ($data as $material => $formula)
                        <tr>
                            @if ($loop->first)
                                <td style="font-weight: 600;" rowspan="{{ count($data) }}">{{ ucfirst($section) }}</td>
                            @endif
                            <td>{{ ucwords(str_replace('_', ' ', $material)) }}</td>
                            <td><input type="text" class="ef-input" wire:model.lazy="glass_weight.{{ $section }}.{{ $material }}"></td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td style="font-weight: 600;" colspan="2">{{ ucfirst($section) }}</td>
                            <td><input type="text" class="ef-input" wire:model.lazy="glass_weight.{{ $section }}"></td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Resin Weight --}}
@if (!empty($resin_weight))
<div class="ef-card">
    <div class="ef-card-header">
        <h3 class="ef-card-title">Resin Weight</h3>
    </div>
    <div class="ef-section">
        <table class="ef-table">
            <thead><tr><th style="width: 200px;">Komponen</th><th>Rumus</th></tr></thead>
            <tbody>
                @foreach ($resin_weight as $key => $formula)
                <tr>
                    <td style="font-weight: 600;">{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                    <td><input type="text" class="ef-input" wire:model.lazy="resin_weight.{{ $key }}"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Additive --}}
@if (!empty($additive))
<div class="ef-card">
    <div class="ef-card-header">
        <h3 class="ef-card-title">Additive</h3>
    </div>
    <div class="ef-section">
        <table class="ef-table">
            <thead><tr><th style="width: 220px;">Komponen</th><th>Rumus</th></tr></thead>
            <tbody>
                @foreach ($additive as $key => $formula)
                <tr>
                    <td style="font-weight: 600;">{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                    <td><input type="text" class="ef-input" wire:model.lazy="additive.{{ $key }}"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Mirror Glaze --}}
@if (!empty($mirror_glaze))
<div class="ef-card">
    <div class="ef-card-header">
        <h3 class="ef-card-title">Mirror Glaze</h3>
    </div>
    <div class="ef-section">
        <div class="ef-field">
            <label class="ef-label">Rumus</label>
            <input type="text" class="ef-input" wire:model.lazy="mirror_glaze.rumus">
        </div>
    </div>
</div>
@endif

{{-- Additional Additive --}}
@if (!empty($additional_additive))
<div class="ef-card">
    <div class="ef-card-header">
        <h3 class="ef-card-title">Additional Additive</h3>
    </div>
    <div class="ef-section">
        <table class="ef-table">
            <thead><tr><th style="width: 180px;">Kategori</th><th style="width: 150px;">Komponen</th><th>Rumus</th></tr></thead>
            <tbody>
                @foreach ($additional_additive as $category => $data)
                    @if (is_array($data))
                        @foreach ($data as $component => $formula)
                        <tr>
                            @if ($loop->first)
                                <td style="font-weight: 600;" rowspan="{{ count($data) }}">{{ ucwords(str_replace('_', ' ', $category)) }}</td>
                            @endif
                            <td>{{ ucwords(str_replace('_', ' ', $component)) }}</td>
                            <td><input type="text" class="ef-input" wire:model.lazy="additional_additive.{{ $category }}.{{ $component }}"></td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td style="font-weight: 600;" colspan="2">{{ ucwords(str_replace('_', ' ', $category)) }}</td>
                            <td><input type="text" class="ef-input" wire:model.lazy="additional_additive.{{ $category }}"></td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Total Weight --}}
@if (!empty($total_weight))
<div class="ef-card">
    <div class="ef-card-header">
        <h3 class="ef-card-title">Total Berat</h3>
    </div>
    <div class="ef-section">
        <div class="ef-field">
            <label class="ef-label">Rumus</label>
            <input type="text" class="ef-input" wire:model.lazy="total_weight.rumus">
        </div>
    </div>
</div>
@endif

</x-filament-panels::page>
