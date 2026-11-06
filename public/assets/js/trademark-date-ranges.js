(function (root) {
    'use strict';
    const dates = root.TrademarkDates || (typeof require === 'function' ? require('./trademark-dates.js') : null);
    function parse(text) {
        const value = String(text || '').trim();
        if (!value) return { from: '', to: '' };
        const parts = value.split(/\s*[—–]\s*|\s+to\s+|\s+-\s+/i);
        if (parts.length > 2) return null;
        const from = dates.parse(parts[0]);
        const to = parts.length === 1 ? from : dates.parse(parts[1]);
        if (from === null || to === null || (from && to && from > to)) return null;
        return { from, to };
    }
    function format(range) {
        if (!range.from && !range.to) return '';
        if (range.from && range.from === range.to) return dates.format(range.from);
        return `${dates.format(range.from)} — ${dates.format(range.to)}`.trim();
    }
    const api = { parse, format };
    if (typeof module !== 'undefined' && module.exports) module.exports = api;
    if (typeof document === 'undefined') return;
    root.TrademarkDateRanges = api;
    const controls = [];
    const dialog = document.createElement('dialog');
    dialog.className = 'tm-range-dialog';
    dialog.setAttribute('aria-labelledby', 'range-dialog-title');
    dialog.innerHTML = `<div class="tm-range-heading"><h2 id="range-dialog-title"></h2><button type="button" data-close aria-label="Close date range"><i class="bi bi-x-lg" aria-hidden="true"></i></button></div>
        <div class="tm-range-inputs"><label>From<input data-draft-from placeholder="mm/dd/yyyy" autocomplete="off"></label><label>To<input data-draft-to placeholder="mm/dd/yyyy" autocomplete="off"></label></div>
        <p class="tm-range-help">Choose one day twice for an exact date, or two days for a range. Leave either limit empty for an open range.</p>
        <div class="tm-range-month-nav"><button type="button" data-prev aria-label="Previous month">‹</button><button type="button" data-next aria-label="Next month">›</button></div>
        <div class="tm-range-calendars"></div><p data-range-error role="alert" hidden></p>
        <div class="tm-range-footer"><button type="button" data-clear>Clear range</button><button type="button" data-cancel>Cancel</button><button type="button" data-apply>Apply</button></div>`;
    document.body.append(dialog);
    const draftFrom = dialog.querySelector('[data-draft-from]');
    const draftTo = dialog.querySelector('[data-draft-to]');
    const error = dialog.querySelector('[data-range-error]');
    let active, draft, month, waitingForEnd = false;
    const isoDay = date => `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
    function render() {
        const calendars = dialog.querySelector('.tm-range-calendars');
        calendars.replaceChildren();
        for (let offset = 0; offset < 2; offset++) {
            const first = new Date(month.getFullYear(), month.getMonth() + offset, 1);
            const section = document.createElement('section');
            const title = document.createElement('h3');
            title.textContent = first.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
            section.append(title);
            const grid = document.createElement('div'); grid.className = 'tm-range-days';
            ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'].forEach(day => {
                const label = document.createElement('span'); label.textContent = day; grid.append(label);
            });
            for (let i = 0; i < first.getDay(); i++) grid.append(document.createElement('span'));
            const count = new Date(first.getFullYear(), first.getMonth() + 1, 0).getDate();
            for (let day = 1; day <= count; day++) {
                const date = isoDay(new Date(first.getFullYear(), first.getMonth(), day));
                const button = document.createElement('button'); button.type = 'button'; button.textContent = day;
                button.setAttribute('aria-label', dates.format(date));
                button.classList.toggle('is-endpoint', date === draft.from || date === draft.to);
                button.classList.toggle('is-in-range', !!draft.from && !!draft.to && date > draft.from && date < draft.to);
                button.addEventListener('click', () => {
                    if (!waitingForEnd) { draft = { from: date, to: '' }; waitingForEnd = true; }
                    else { draft = { from: date < draft.from ? date : draft.from, to: date < draft.from ? draft.from : date }; waitingForEnd = false; }
                    draftFrom.value = dates.format(draft.from); draftTo.value = dates.format(draft.to); error.hidden = true; render();
                });
                grid.append(button);
            }
            section.append(grid); calendars.append(section);
        }
    }
    function commit(control) {
        const range = parse(control.display.value);
        if (!range) {
            control.display.setCustomValidity('Enter a valid date or range, for example Jul/06/2023 — Jul/10/2023.');
            control.display.setAttribute('aria-invalid', 'true');
            return false;
        }
        control.display.setCustomValidity(''); control.display.removeAttribute('aria-invalid');
        control.from.value = range.from; control.to.value = range.to; control.display.value = format(range);
        control.display.title = control.display.value || 'From — To';
        control.from.dispatchEvent(new Event('change', { bubbles: true }));
        return true;
    }
    document.querySelectorAll('[data-date-range]').forEach(wrapper => {
        const control = { wrapper, display: wrapper.querySelector('[data-range-display]'), from: wrapper.querySelector('[data-range-from]'), to: wrapper.querySelector('[data-range-to]') };
        control.display.value = format({ from: control.from.value, to: control.to.value });
        control.display.title = control.display.value || 'From — To';
        control.display.addEventListener('input', () => { control.display.setCustomValidity(''); control.display.removeAttribute('aria-invalid'); });
        control.display.addEventListener('blur', () => commit(control));
        wrapper.querySelector('[data-range-open]').addEventListener('click', () => {
            active = control; draft = { from: control.from.value, to: control.to.value }; waitingForEnd = false;
            month = draft.from || draft.to ? new Date((draft.from || draft.to) + 'T12:00:00') : new Date();
            month = new Date(month.getFullYear(), month.getMonth(), 1);
            dialog.querySelector('h2').textContent = wrapper.dataset.rangeLabel;
            draftFrom.value = dates.format(draft.from); draftTo.value = dates.format(draft.to); error.hidden = true;
            render(); dialog.showModal();
        });
        controls.push(control);
    });
    function close() { dialog.close(); active?.display.focus(); }
    ['[data-close]', '[data-cancel]'].forEach(selector => dialog.querySelector(selector).addEventListener('click', close));
    dialog.addEventListener('click', event => { if (event.target === dialog) close(); });
    dialog.querySelector('[data-prev]').addEventListener('click', () => { month.setMonth(month.getMonth() - 1); render(); });
    dialog.querySelector('[data-next]').addEventListener('click', () => { month.setMonth(month.getMonth() + 1); render(); });
    dialog.querySelector('[data-clear]').addEventListener('click', () => {
        active.display.value = ''; commit(active); close();
    });
    function apply() {
        const range = parse(`${draftFrom.value} — ${draftTo.value}`);
        if (!range) { error.textContent = 'Enter valid dates, with From no later than To.'; error.hidden = false; return; }
        active.display.value = format(range); commit(active); close();
    }
    dialog.querySelector('[data-apply]').addEventListener('click', apply);
    dialog.addEventListener('keydown', event => { if (event.key === 'Enter' && event.target.matches('input')) { event.preventDefault(); apply(); } });
    const form = document.getElementById('trademark-search-form');
    form?.addEventListener('submit', event => {
        const invalid = controls.find(control => !commit(control));
        if (invalid) {
            event.preventDefault(); event.stopImmediatePropagation();
            document.getElementById('advancedSearch').classList.add('show');
            document.getElementById('tm-advanced-toggle').setAttribute('aria-expanded', 'true');
            invalid.display.focus(); invalid.display.reportValidity();
        }
    }, true);
})(typeof window !== 'undefined' ? window : globalThis);
