(function () {
    'use strict';
    const configNode = document.getElementById('tm-column-config');
    if (!configNode) return;
    const config = JSON.parse(configNode.textContent);
    const definitions = config.definitions;
    const keys = Object.keys(definitions);
    let preferences = config.preferences;
    let saveTimer, dragKey, saving = false, pendingSave = false;
    const fixed = keys.slice(0, 4);
    const defaults = () => ({ order: [...keys], visible: [...keys], widths: Object.fromEntries(keys.map(key => [key, definitions[key].width])) });
    function status(text) { document.querySelectorAll('[data-preferences-status]').forEach(node => { node.textContent = text; }); }
    async function save() {
        if (saving) { pendingSave = true; return; }
        saving = true;
        status('Saving…');
        try {
            const response = await fetch(config.url, { method: 'PATCH', headers: { 'Content-Type': 'application/json', Accept: 'application/json', 'X-CSRF-TOKEN': config.token }, body: JSON.stringify(preferences), keepalive: true });
            if (!response.ok) throw new Error('Unable to save preferences');
            status('Preferences saved.');
        } catch (error) { status('Unable to save preferences. Change a setting to retry.'); }
        finally { saving = false; if (pendingSave) { pendingSave = false; save(); } }
    }
    function changed() { apply(); clearTimeout(saveTimer); saveTimer = undefined; save(); }
    function apply(render = true) {
        const table = document.getElementById('products-list');
        if (table) {
            const visible = preferences.order.filter(key => preferences.visible.includes(key));
            table.style.width = visible.reduce((sum, key) => sum + preferences.widths[key], 0) + 'px';
            table.querySelectorAll('tr, colgroup').forEach(row => {
                const cells = new Map([...row.children].filter(cell => cell.dataset.column).map(cell => [cell.dataset.column, cell]));
                let left = 0;
                preferences.order.forEach(key => {
                    const cell = cells.get(key);
                    if (!cell) return;
                    const index = preferences.order.indexOf(key);
                    if (row.children[index] !== cell) row.insertBefore(cell, row.children[index] || null);
                    cell.hidden = !preferences.visible.includes(key);
                    cell.style.width = preferences.widths[key] + 'px';
                    const handle = cell.querySelector?.('.tm-column-resize');
                    if (handle) { handle.setAttribute('aria-valuenow', preferences.widths[key]); handle.setAttribute('aria-valuemin', key === 'select' ? 36 : 48); handle.setAttribute('aria-valuemax', 800); }
                    if (fixed.includes(key)) {
                        cell.classList.add('tm-frozen-column');
                        cell.style.left = left + 'px';
                        left += preferences.widths[key];
                    }
                });
            });
            table.querySelectorAll('.tm-empty-results').forEach(cell => { cell.colSpan = visible.length; });
        }
        if (render) renderOptions();
    }
    function renderOptions() {
        document.querySelectorAll('[data-column-options]').forEach(container => {
            container.replaceChildren();
            preferences.order.forEach((key, index) => {
                const row = document.createElement('div'); row.className = 'tm-column-option';
                const label = document.createElement('label');
                const check = document.createElement('input'); check.type = 'checkbox'; check.checked = preferences.visible.includes(key); check.disabled = fixed.includes(key);
                check.addEventListener('change', () => { preferences.visible = check.checked ? [...preferences.visible, key] : preferences.visible.filter(item => item !== key); changed(); });
                label.append(check, document.createTextNode(definitions[key].label || 'Selection'));
                const width = document.createElement('input'); width.type = 'number'; width.min = key === 'select' ? 36 : 48; width.max = 800; width.value = preferences.widths[key]; width.setAttribute('aria-label', 'Width of ' + (definitions[key].label || 'selection'));
                width.addEventListener('input', () => { if (width.checkValidity()) { preferences.widths[key] = Number(width.value); apply(false); clearTimeout(saveTimer); saveTimer = setTimeout(() => { saveTimer = undefined; save(); }, 400); } });
                row.append(label, width);
                [-1, 1].forEach(delta => {
                    const button = document.createElement('button'); button.type = 'button'; button.textContent = delta < 0 ? '↑' : '↓'; button.setAttribute('aria-label', 'Move ' + definitions[key].label + (delta < 0 ? ' left' : ' right'));
                    button.disabled = fixed.includes(key) || index + delta < 4 || index + delta >= keys.length;
                    button.addEventListener('click', () => { const other = index + delta; [preferences.order[index], preferences.order[other]] = [preferences.order[other], preferences.order[index]]; changed(); }); row.append(button);
                });
                container.append(row);
            });
        });
    }
    document.addEventListener('click', event => {
        if (event.target.closest('[data-columns-toggle]')) { const panel = document.querySelector('[data-column-preferences]'); panel.hidden = !panel.hidden; event.target.closest('button').setAttribute('aria-expanded', String(!panel.hidden)); }
        if (event.target.closest('[data-columns-reset]')) { preferences = defaults(); changed(); }
    });
    document.addEventListener('dragstart', event => {
        const th = event.target.closest('#products-list th[draggable]');
        if (!th || event.target.closest('.tm-column-resize')) { event.preventDefault(); return; }
        dragKey = th.dataset.column; event.dataTransfer.setData('text/plain', dragKey); event.dataTransfer.effectAllowed = 'move';
    });
    document.addEventListener('dragover', event => { if (dragKey && event.target.closest('#products-list th[draggable]')) event.preventDefault(); });
    document.addEventListener('drop', event => {
        const target = event.target.closest('#products-list th[draggable]');
        if (!target || !dragKey) return;
        event.preventDefault(); const key = dragKey; dragKey = null;
        if (key === target.dataset.column) return;
        const targetIndex = preferences.order.indexOf(target.dataset.column);
        preferences.order = preferences.order.filter(item => item !== key);
        preferences.order.splice(targetIndex, 0, key); changed();
    });
    document.addEventListener('dragend', () => { dragKey = null; });
    function setWidth(key, width) { preferences.widths[key] = Math.max(key === 'select' ? 36 : 48, Math.min(800, Math.round(width))); apply(); }
    document.addEventListener('pointerdown', event => {
        const handle = event.target.closest('.tm-column-resize'); if (!handle) return;
        event.preventDefault(); event.stopPropagation();
        const key = handle.parentElement.dataset.column, start = event.clientX, width = preferences.widths[key];
        handle.setPointerCapture(event.pointerId);
        const move = e => setWidth(key, width + e.clientX - start);
        const end = () => { handle.removeEventListener('pointermove', move); handle.removeEventListener('pointerup', end); handle.removeEventListener('pointercancel', end); changed(); };
        handle.addEventListener('pointermove', move); handle.addEventListener('pointerup', end); handle.addEventListener('pointercancel', end);
    });
    document.addEventListener('keydown', event => {
        if (!event.target.matches('.tm-column-resize') || !['ArrowLeft', 'ArrowRight'].includes(event.key)) return;
        event.preventDefault(); const key = event.target.parentElement.dataset.column;
        setWidth(key, preferences.widths[key] + (event.key === 'ArrowLeft' ? -10 : 10)); changed();
    });
    window.addEventListener('pagehide', () => { if (saveTimer) { clearTimeout(saveTimer); saveTimer = undefined; save(); } });
    const settings = document.querySelector('.account-panel [data-column-preferences]'); if (settings) settings.hidden = false;
    window.RomeroColumns = { apply, keys: () => keys.filter(key => !fixed.slice(0, 2).includes(key)), label: key => definitions[key].label };
    apply();
})();
