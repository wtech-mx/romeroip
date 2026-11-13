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

    function selectRow(checkbox) {
        if (checkbox.checked) selectedRows.set(checkbox.value, true);
        else selectedRows.delete(checkbox.value);
    }

    const exportConfig = JSON.parse(document.getElementById('tm-column-config').textContent);
    const templateDialog = document.querySelector('[data-export-template-dialog]');
    async function exportRecords(format, template) {
        const ids = selectedRows.size ? [...selectedRows.keys()] : [...results.querySelectorAll('.js-select-trademark')].map(input => input.value);
        if (!ids.length) return;
        const message = results.querySelector('[data-export-status]');
        message.hidden = false; message.textContent = 'Preparing export…';
        try {
            const body = Object.fromEntries(appliedUrl.searchParams);
            Object.assign(body, { format, ids, template });
            const response = await fetch(exportConfig.exportUrl, { method: 'POST', headers: { 'Content-Type': 'application/json', Accept: 'application/json', 'X-CSRF-TOKEN': exportConfig.token }, body: JSON.stringify(body) });
            if (!response.ok) throw new Error('Export failed');
            const blob = await response.blob(); const url = URL.createObjectURL(blob);
            const link = document.createElement('a'); link.href = url; link.download = 'trademarks.' + (format === 'template' ? 'xlsx' : format);
            document.body.append(link); link.click(); link.remove();
            setTimeout(() => URL.revokeObjectURL(url), 1000);
            message.textContent = ''; message.hidden = true;
        } catch (error) { message.textContent = 'Unable to export. Please try again.'; }
    }
    templateDialog?.querySelector('[data-template-export]').addEventListener('click', () => {
        const template = templateDialog.querySelector('select').value;
        templateDialog.close(); exportRecords('template', template);
    });

    function cancelRequest() {
        activeRequest?.abort();
        results.style.opacity = '1';
    }

    async function loadResults(url, options = {}) {
        const scrollLeft = results.querySelector('.tm-table-wrap')?.scrollLeft || 0;
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
            results.querySelector('.tm-table-wrap').scrollLeft = scrollLeft;
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
        const exportOption = event.target.closest('[data-export-format]');
        if (!exportOption) return;
        if (exportOption.dataset.exportFormat === 'template') templateDialog.showModal();
        else exportRecords(exportOption.dataset.exportFormat);

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
