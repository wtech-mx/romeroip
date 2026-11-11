(function () {
    'use strict';
    const form = document.getElementById('trademark-search-form');
    const results = document.getElementById('trademark-results');
    if (!form || !results) return;

    const errorMessage = document.getElementById('tm-search-error');
    const globalInput = document.querySelector('[data-global-search] input[name="q"]');
    const initialResults = results.querySelector('[data-results-total]');
    const selectedRows = new Map();
    let filterQuery = initialResults.dataset.resultsQuery || '';
    let appliedUrl = new URL(initialResults.dataset.resultsUrl, location.href);
    let pageSize = Number(initialResults.dataset.resultsPerPage);
    let sort = appliedUrl.searchParams.get('sort') || 'our_ref';
    let direction = appliedUrl.searchParams.get('direction') || 'asc';
    function showSort() {
        results.querySelectorAll('th[data-column]').forEach(th => {
            const active = th.dataset.column === sort;
            if (active) th.setAttribute('aria-sort', direction === 'asc' ? 'ascending' : 'descending'); else th.removeAttribute('aria-sort');
            const indicator = th.querySelector('[data-sort-indicator]');
            if (indicator) indicator.textContent = active ? (direction === 'asc' ? ' ↑' : ' ↓') : '';
        });
    }
    showSort();
    globalInput?.focus({ preventScroll: true });
    let activeRequest;
    let openSingleMatch = false;

    function updateSelection() {
        const checkboxes = [...results.querySelectorAll('.js-select-trademark')];
        checkboxes.forEach(checkbox => { checkbox.checked = selectedRows.has(checkbox.value); });
        const selectAll = results.querySelector('.js-select-all-trademarks');
        const checkedCount = checkboxes.filter(checkbox => checkbox.checked).length;
        selectAll.checked = checkboxes.length > 0 && checkedCount === checkboxes.length;
        selectAll.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
    }

    function exportCells(row) {
        return Object.fromEntries([...row.cells].filter(cell => !['select', 'edit'].includes(cell.dataset.column)).map(cell => [cell.dataset.column, cell.textContent.trim()]));
    }

    function selectRow(checkbox) {
        if (checkbox.checked) selectedRows.set(checkbox.value, exportCells(checkbox.closest('tr')));
        else selectedRows.delete(checkbox.value);
    }

    function cancelRequest() {
        activeRequest?.abort();
        results.style.opacity = '1';
    }

    async function loadResults(url, options = {}) {
        cancelRequest();
        const controller = new AbortController();
        activeRequest = controller;
        results.style.opacity = '0.55';
        errorMessage.hidden = true;
        window.RomeroGlobalStatus?.('Searching…');

        try {
            const response = await fetch(url, {
                signal: controller.signal,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            if (response.status === 422) {
                const data = await response.json();
                errorMessage.textContent = Object.values(data.errors).flat().join(' ');
                errorMessage.hidden = false;
                const filters = document.getElementById('tm-advanced-toggle');
                if (filters.getAttribute('aria-expanded') === 'false') filters.click();
                window.RomeroGlobalStatus?.('');
                return;
            }
            if (!response.ok) throw new Error('Search failed');
            const html = await response.text();
            if (activeRequest !== controller || controller.signal.aborted) return;

            if (options.resetSelection) selectedRows.clear();
            results.innerHTML = html;
            const panel = results.querySelector('[data-results-total]');
            appliedUrl = new URL(panel.dataset.resultsUrl, location.href);
            pageSize = Number(panel.dataset.resultsPerPage);
            window.RomeroColumns?.apply();
            showSort();
            updateSelection();
            if (globalInput) globalInput.value = '';
            window.RomeroGlobalStatus?.(panel.dataset.resultsTotal === '0' ? 'No matching records found.' : '');

            if (options.directMatch && panel.dataset.resultsTotal === '1') {
                const recordLink = results.querySelector('a[data-view-record]');
                if (recordLink) window.RomeroNavigation?.navigate(recordLink.href);
            }
        } catch (error) {
            if (error.name === 'AbortError') return;
            errorMessage.textContent = 'Unable to search. Please try again.';
            errorMessage.hidden = false;
            window.RomeroGlobalStatus?.('');
        } finally {
            if (activeRequest === controller) {
                results.style.opacity = '1';
                results.querySelectorAll('[data-results-page-size]').forEach(select => { select.value = String(pageSize); });
            }
        }
    }

    form.addEventListener('submit', event => {
        event.preventDefault();
        const typed = globalInput?.value.trim();
        if (typed) filterQuery = typed;
        const url = new URL(form.action);
        url.search = new URLSearchParams(new FormData(form)).toString();
        url.searchParams.set('q', filterQuery);
        url.searchParams.set('per_page', pageSize);
        url.searchParams.set('sort', sort);
        url.searchParams.set('direction', direction);
        const directMatch = openSingleMatch;
        openSingleMatch = false;
        loadResults(url, { resetSelection: true, directMatch });
    });

    form.addEventListener('keydown', event => {
        if (event.key === 'Enter' && !event.target.closest('button') && !event.isComposing) {
            event.preventDefault();
            form.requestSubmit();
        }
    });

    window.RomeroSearch = {
        search(query) {
            filterQuery = query;
            openSingleMatch = true;
            form.requestSubmit();
            openSingleMatch = false;
        },
        showLive() {
            filterQuery = '';
            if (globalInput) globalInput.value = '';
            form.querySelectorAll('input, select').forEach(control => {
                control.value = control.name === 'status' ? 'Live' : '';
                control.setCustomValidity('');
                control.removeAttribute('aria-invalid');
                if (control.hasAttribute('data-range-display')) control.title = 'From — To';
            });
            openSingleMatch = false;
            form.requestSubmit();
        },
        clearQuery() { filterQuery = ''; cancelRequest(); },
        cancel: cancelRequest
    };

    results.addEventListener('click', event => {
        const sortButton = event.target.closest('[data-sort]');
        if (sortButton) {
            direction = sort === sortButton.dataset.sort && direction === 'asc' ? 'desc' : 'asc';
            sort = sortButton.dataset.sort;
            const url = new URL(appliedUrl); url.searchParams.set('sort', sort); url.searchParams.set('direction', direction); url.searchParams.delete('page');
            loadResults(url); return;
        }
        const link = event.target.closest('[data-results-page]');
        if (link) {
            event.preventDefault();
            loadResults(new URL(link.href));
            return;
        }
        if (!event.target.closest('[data-results-export]')) return;
        const keys = window.RomeroColumns.keys();
        const headers = keys.map(window.RomeroColumns.label);
        const rows = selectedRows.size > 0
            ? [...selectedRows.values()]
            : [...results.querySelectorAll('tbody tr')].filter(row => row.querySelector('.js-select-trademark')).map(exportCells);
        if (rows.length === 0) return;
        const csvCell = value => {
            const safeValue = /^[=+\-@\t\r]/.test(value) ? "'" + value : value;
            return '"' + safeValue.replace(/"/g, '""') + '"';
        };
        const csv = [headers, ...rows.map(row => keys.map(key => row[key] || ''))].map(row => row.map(csvCell).join(',')).join('\r\n');
        const url = URL.createObjectURL(new Blob(['\uFEFF', csv], { type: 'text/csv;charset=utf-8;' }));
        const download = document.createElement('a');
        download.href = url;
        download.download = 'trademarks.csv';
        document.body.append(download);
        download.click();
        download.remove();
        setTimeout(() => URL.revokeObjectURL(url), 0);
    });

    results.addEventListener('change', event => {
        const sizeSelect = event.target.closest('[data-results-page-size]');
        if (sizeSelect) {
            results.querySelectorAll('[data-results-page-size]').forEach(select => { select.value = sizeSelect.value; });
            const url = new URL(appliedUrl);
            url.searchParams.set('per_page', sizeSelect.value);
            url.searchParams.delete('page');
            loadResults(url);
            return;
        }
        if (event.target.matches('.js-select-all-trademarks')) {
            results.querySelectorAll('.js-select-trademark').forEach(checkbox => {
                checkbox.checked = event.target.checked;
                selectRow(checkbox);
            });
        } else if (event.target.matches('.js-select-trademark')) selectRow(event.target);
        updateSelection();
    });
})();
