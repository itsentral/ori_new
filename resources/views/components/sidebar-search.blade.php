<div
    x-data="{
        search: '',
        hasResults: true,
        filterNav(query) {
            const items = document.querySelectorAll('.fi-sidebar-item')
            const groups = document.querySelectorAll('.fi-sidebar-group')
            let totalVisible = 0

            items.forEach(item => {
                const label = item.querySelector('.fi-sidebar-item-label')
                if (!label) return

                const text = label.textContent.toLowerCase()
                const match = query === '' || text.includes(query.toLowerCase())
                item.style.display = match ? '' : 'none'
                if (match) totalVisible++
            })

            groups.forEach(group => {
                const visibleItems = group.querySelectorAll('.fi-sidebar-item:not([style*=\'display: none\'])')
                group.style.display = visibleItems.length > 0 ? '' : 'none'
            })

            this.hasResults = query === '' || totalVisible > 0
        }
    }"
    x-init="$watch('search', value => filterNav(value))"
    style="padding: 8px 12px 6px 12px;"
>
    <div style="position: relative;">
        {{-- Icon search --}}
        <div style="pointer-events: none; position: absolute; top: 0; bottom: 0; left: 0; display: flex; align-items: center; padding-left: 8px;">
            <svg style="height: 13px; width: 13px; flex-shrink: 0; color: var(--gray-400);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.197 5.197a7.5 7.5 0 0 0 10.606 10.606Z" />
            </svg>
        </div>

        {{-- Input --}}
        <input
            x-model="search"
            type="text"
            placeholder="Search menu..."
            style="
                width: 100%;
                border-radius: 6px;
                border: 1px solid var(--gray-200);
                background-color: var(--gray-50);
                color: var(--gray-700);
                padding: 5px 26px 5px 26px;
                font-size: 12px;
                outline: none;
                box-sizing: border-box;
                transition: border-color 0.15s, background-color 0.15s;
            "
            onfocus="this.style.borderColor='rgb(var(--primary-400))'; this.style.backgroundColor='var(--gray-50)'"
            onblur="this.style.borderColor='var(--gray-200)'"
        />

        {{-- Tombol clear --}}
        <button
            x-show="search !== ''"
            x-on:click="search = ''"
            x-transition
            style="position: absolute; top: 0; bottom: 0; right: 0; display: flex; align-items: center; padding-right: 7px; color: var(--gray-400); background: none; border: none; cursor: pointer;"
        >
            <svg style="height: 11px; width: 11px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Pesan tidak ditemukan --}}
    <div
        x-show="!hasResults"
        x-transition
        style="margin-top: 6px; display: flex; align-items: center; gap: 6px; border-radius: 6px; background-color: var(--gray-100); padding: 7px 10px;"
    >
        <svg style="height: 13px; width: 13px; flex-shrink: 0; color: var(--gray-400);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
        </svg>
        <span style="font-size: 11px; color: var(--gray-500);">
            Menu "<span x-text="search" style="font-weight: 600; color: var(--gray-700);"></span>" tidak ditemukan
        </span>
    </div>
</div>