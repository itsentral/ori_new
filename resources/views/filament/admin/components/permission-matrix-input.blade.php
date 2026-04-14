@php
    $statePath = $getStatePath();
    $modules   = $getModules();
    $actions   = $getActions();
    $state     = $getState() ?? [];
    $isDisabled = $isDisabled();

    $actionLabels = [
        'view'   => 'View',
        'add'    => 'Add',
        'manage' => 'Manage',
        'delete' => 'Delete',
    ];
@endphp

<style>
    .perm-wrap { overflow-x: auto; width: 100%; }

    .perm-table {
        border-collapse: collapse;
        width: 100%;
        min-width: 500px;
        font-size: 13px;
        table-layout: fixed;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        overflow: hidden;
    }
    .dark .perm-table { border-color: #374151; }

    .perm-table th, .perm-table td {
        border-bottom: 1px solid #e5e7eb;
        padding: 10px 14px;
        white-space: nowrap;
    }
    .dark .perm-table th,
    .dark .perm-table td { border-color: #374151; }

    /* Header */
    .perm-thead-row {
        background-color: #f9fafb;
    }
    .dark .perm-thead-row { background-color: #1f2937; }

    .perm-th {
        color: #374151;
        font-weight: 600;
        font-size: 12px;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }
    .dark .perm-th { color: #d1d5db; }

    .perm-th-left { text-align: left; }
    .perm-th-center { text-align: center; }

    /* Body rows */
    .perm-tr-even { background-color: #f9fafb; }
    .dark .perm-tr-even { background-color: #111827; }

    .perm-tr-odd { background-color: #ffffff; }
    .dark .perm-tr-odd { background-color: #1f2937; }

    .perm-td-label {
        color: #111827;
        font-weight: 500;
        font-size: 13px;
        text-align: left;
    }
    .dark .perm-td-label { color: #f3f4f6; }

    .perm-td-center { text-align: center; }

    .perm-checkbox {
        width: 16px;
        height: 16px;
        border-radius: 4px;
        cursor: pointer;
        accent-color: #6366f1;
    }
    .perm-checkbox:disabled {
        cursor: not-allowed;
        opacity: 0.6;
    }
</style>

<div x-data="{
    state: $wire.entangle('{{ $statePath }}').live,
    toggle(permission) {
        if (this.state.includes(permission)) {
            this.state = this.state.filter(p => p !== permission);
        } else {
            this.state = [...this.state, permission];
        }
    },
    toggleAll(module, actions) {
        const perms = actions.map(a => a + '_' + module);
        const allChecked = perms.every(p => this.state.includes(p));
        if (allChecked) {
            this.state = this.state.filter(p => !perms.includes(p));
        } else {
            const newState = [...this.state];
            perms.forEach(p => { if (!newState.includes(p)) newState.push(p); });
            this.state = newState;
        }
    },
    isAllChecked(module, actions) {
        return actions.map(a => a + '_' + module).every(p => this.state.includes(p));
    },
    isIndeterminate(module, actions) {
        const perms = actions.map(a => a + '_' + module);
        const checkedCount = perms.filter(p => this.state.includes(p)).length;
        return checkedCount > 0 && checkedCount < perms.length;
    }
}" class="perm-wrap">

    <div style="border-radius: 0.75rem; overflow: hidden; border: 1px solid #e5e7eb;" class="dark:border-gray-700">
        <table class="perm-table">
            <colgroup>
                <col style="width: 35%">
                @foreach ($actions as $action)
                    <col style="width: {{ 55 / count($actions) }}%">
                @endforeach
                <col style="width: 10%">
            </colgroup>

            <thead>
                <tr class="perm-thead-row">
                    <th class="perm-th perm-th-left">Module</th>
                    @foreach ($actions as $action)
                        <th class="perm-th perm-th-center">
                            {{ $actionLabels[$action] ?? ucfirst($action) }}
                        </th>
                    @endforeach
                    <th class="perm-th perm-th-center">All</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($modules as $moduleKey => $moduleLabel)
                    @php
                        $actions_js = json_encode($actions);
                        $rowClass = $loop->even ? 'perm-tr-even' : 'perm-tr-odd';
                    @endphp
                    <tr class="{{ $rowClass }}">
                        <td class="perm-td-label">{{ $moduleLabel }}</td>

                        @foreach ($actions as $action)
                            @php $permName = "{$action}_{$moduleKey}"; @endphp
                            <td class="perm-td-center">
                                <input
                                    type="checkbox"
                                    class="perm-checkbox"
                                    :checked="state.includes('{{ $permName }}')"
                                    @if($isDisabled) disabled @endif
                                    @unless($isDisabled) @change="toggle('{{ $permName }}')" @endunless
                                />
                            </td>
                        @endforeach

                        <td class="perm-td-center">
                            <input
                                type="checkbox"
                                class="perm-checkbox"
                                :checked="isAllChecked('{{ $moduleKey }}', {{ $actions_js }})"
                                :indeterminate="isIndeterminate('{{ $moduleKey }}', {{ $actions_js }})"
                                @if($isDisabled) disabled @endif
                                @unless($isDisabled) @change="toggleAll('{{ $moduleKey }}', {{ $actions_js }})" @endunless
                            />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>