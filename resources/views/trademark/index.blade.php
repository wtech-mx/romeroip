{{-- @php($trademarks = App\Models\Trademarks::all())
@livewire('trademarks.index') --}}
@extends('layouts.app')

@section('css')
<style>
    :root{
        --tm-primary: #8A6F3E;
        --tm-dark: #1F2328;
        --tm-border: #D8D2C6;
        --tm-border-soft: #EEE9DF;
        --tm-bg: #F8F6F1;
        --tm-muted: #76716A;
    }

    body{
        background: var(--tm-bg);
    }

    .tm-index-page{
        max-width: 1440px;
        margin-left: 0;
        margin-right: auto;
        padding-bottom: 4rem;
    }

    .tm-search-panel,
    .tm-results-panel{
        background: #FBFAF6 !important;
        border: 1px solid var(--tm-border) !important;
        border-radius: 12px !important;
        box-shadow: none !important;
    }

    .tm-search-panel{
        margin-bottom: 1rem;
    }

    .tm-search-panel .card-header,
    .tm-results-panel .card-header{
        padding: 1.55rem 2rem 1rem !important;
        border-bottom: 1px solid var(--tm-border-soft);
        background: transparent;
    }

    .tm-search-panel h5,
    .tm-results-panel h5{
        margin: 0;
        color: var(--tm-dark);
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .tm-search-panel .card-body,
    .tm-results-panel .card-body{
        padding: 1.35rem 2rem 1.75rem !important;
    }

    .tm-search-panel .row{
        row-gap: 1.15rem;
    }

    .tm-search-panel [class*="col-"]{
        position: relative;
    }

    .tm-search-panel .form-label{
        margin-bottom: .28rem;
        color: var(--tm-muted);
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .tm-search-panel .input-group{
        display: flex;
        width: 100%;
    }

    .tm-search-panel .form-control{
        width: 100%;
        min-height: 48px;
        border: 0 !important;
        border-bottom: 1px solid var(--tm-border-soft) !important;
        border-radius: 0 !important;
        background: transparent !important;
        color: var(--tm-dark);
        font-weight: 600;
        padding: .68rem .2rem .65rem 0;
        box-shadow: none !important;
    }

    .tm-search-panel .form-control:focus{
        border-color: var(--tm-primary) !important;
        background: rgba(255,255,255,.55) !important;
    }

    .tm-search-panel .btn,
    .tm-results-panel .btn,
    .tm-index-actions .btn{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 40px;
        padding: 0 .95rem;
        border-radius: 6px !important;
        font-weight: 700;
        border: 1px solid var(--tm-dark) !important;
        background: transparent !important;
        color: var(--tm-dark) !important;
        box-shadow: none !important;
        text-align: center;
    }

    .tm-search-panel button[type="submit"],
    .tm-results-panel button,
    .tm-index-actions .tm-primary-action{
        background: var(--tm-dark) !important;
        color: #fff !important;
    }

    .tm-index-actions{
        display: flex;
        justify-content: flex-end;
        margin-bottom: 1rem;
    }

    .autocomplete-box{
        border-color: var(--tm-border);
        border-radius: 8px;
        box-shadow: 0 10px 22px rgba(31,35,40,.08);
    }

    .autocomplete-item{
        border-radius: 6px;
    }

    .autocomplete-item:hover{
        background: rgba(138,111,62,.10);
    }

    .tm-table-wrap{
        border-top: 0;
    }

    .tm-results-table{
        margin: 0;
        color: var(--tm-dark);
    }

    .tm-results-table thead th{
        padding: .85rem 1rem;
        border-bottom: 1px solid var(--tm-border);
        background: #F7F4ED;
        color: var(--tm-muted);
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-align: left;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .tm-results-table tbody td{
        padding: 1rem;
        border-bottom: 1px solid var(--tm-border-soft);
        color: var(--tm-dark);
        font-size: .88rem;
        font-weight: 600;
        text-align: left !important;
        vertical-align: top;
        white-space: nowrap;
    }

    .tm-results-table tbody tr:hover{
        background: rgba(138,111,62,.05);
    }

    .tm-select-col{
        width: 48px;
        min-width: 48px;
    }

    .tm-actions-cell{
        white-space: nowrap;
        min-width: 86px;
    }

    .tm-edit-link{
        color: var(--tm-dark);
        font-weight: 700;
        text-decoration: none;
        border-bottom: 1px solid var(--tm-primary);
        margin-right: .75rem;
    }

    .tm-empty-count{
        color: var(--tm-muted);
        font-size: .9rem;
        font-weight: 600;
    }

    @media (max-width: 991.98px){
        .tm-search-panel .card-header,
        .tm-results-panel .card-header,
        .tm-search-panel .card-body,
        .tm-results-panel .card-body{
            padding-left: 1.25rem !important;
            padding-right: 1.25rem !important;
        }

        .tm-search-panel .col-3,
        .tm-search-panel .col-6{
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>
@endsection

@section('content')

<div class="tm-index-page tm-search-page">
  @include('filtros')

<div class="container-fluid py-0">
      <div class="row">
        <div class="col-12">
          <div id="trademark-results">
            @include('trademark._results')
          </div>
        </div>
      </div>
</div>
</div>

@endsection

@section('js_custom')
<script src="{{ asset('assets/js/trademark-dates.js') }}?v={{ filemtime(public_path('assets/js/trademark-dates.js')) }}"></script>
<script src="{{ asset('assets/js/trademark-date-ranges.js') }}?v={{ filemtime(public_path('assets/js/trademark-date-ranges.js')) }}"></script>
    <script>
    (function () {
        const trademarkForm = document.getElementById('trademark-search-form');
        const trademarkResults = document.getElementById('trademark-results');
        const advancedPanel = document.getElementById('advancedSearch');
        const advancedCount = document.getElementById('tm-advanced-count');
        const searchError = document.getElementById('tm-search-error');
        function updateAdvancedCount() {
            if (!advancedPanel || !advancedCount) return;
            const count = Array.from(advancedPanel.querySelectorAll('input[name], select[name]'))
                .filter(field => field.value.trim() !== '' && !(field.name === 'status' && field.value === 'Live')).length;
            advancedCount.textContent = count ? ` (${count})` : '';
            document.getElementById('tm-advanced-toggle').classList.toggle('has-active-filters', count > 0);
        }
        if (advancedPanel) {
            advancedPanel.addEventListener('input', updateAdvancedCount);
            advancedPanel.addEventListener('change', updateAdvancedCount);
        }
        updateAdvancedCount();

        let lastQuery = @json((string) request('q', ''));
        let activeSearchRequest;
        let pendingGlobalSearch = false;
        async function loadTrademarkResults(url, data = null, directMatch = false) {
            if (!trademarkResults) return;
            activeSearchRequest?.abort();
            const controller = new AbortController();
            activeSearchRequest = controller;

            const submitButton = trademarkForm ? trademarkForm.querySelector('[type="submit"]') : null;
            if (submitButton) {
                submitButton.disabled = true;
            }

            trademarkResults.style.opacity = '0.55';
            searchError.hidden = true;
            window.RomeroGlobalStatus?.('Searching…');

            try {
                const requestUrl = data ? `${url}?${data.toString()}` : url;
                const response = await fetch(requestUrl, {
                    signal: controller.signal,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.status === 422) {
                    const data = await response.json();
                    searchError.textContent = Object.values(data.errors).flat().join(' ');
                    searchError.hidden = false;
                    window.RomeroGlobalStatus?.('');
                    return;
                }
                if (!response.ok) {
                    throw new Error('Search request failed.');
                }

                const html = await response.text();
                if (activeSearchRequest !== controller || controller.signal.aborted) return;
                trademarkResults.innerHTML = html;
                const summary = trademarkResults.querySelector('[data-results-query]');
                if (summary) summary.textContent = lastQuery ? `Results for “${lastQuery}”` : '';
                const globalInput = document.querySelector('[data-global-search] input[name="q"]');
                if (globalInput) globalInput.value = '';
                window.RomeroGlobalStatus?.(trademarkResults.querySelector('[data-results-total]')?.dataset.resultsTotal === '0' ? 'No matching records found.' : '');
                if (directMatch && trademarkResults.querySelector('[data-results-total]')?.dataset.resultsTotal === '1') {
                    const recordLink = trademarkResults.querySelector('a[data-bs-original-title="View trademark"]');
                    if (recordLink) window.RomeroNavigation?.navigate(recordLink.href);
                }
                return true;
            } catch (error) {
                if (error.name === 'AbortError') return;
                window.RomeroGlobalStatus?.('');
                searchError.textContent = 'Unable to search. Please try again.';
                searchError.hidden = false;
            } finally {
                if (activeSearchRequest !== controller) return;
                trademarkResults.style.opacity = '1';

                if (submitButton) {
                    submitButton.disabled = false;
                }
            }
        }

        if (trademarkForm) {
            trademarkForm.addEventListener('submit', function (event) {
                event.preventDefault();
                const data = new URLSearchParams(new FormData(trademarkForm));
                const typed = document.querySelector('[data-global-search] input[name="q"]')?.value.trim();
                if (typed) lastQuery = typed;
                data.set('q', lastQuery);
                const directMatch = pendingGlobalSearch;
                pendingGlobalSearch = false;
                loadTrademarkResults(trademarkForm.action, data, directMatch);
            });
        }

        window.RomeroSearch = {
            search(query) { lastQuery = query; pendingGlobalSearch = true; trademarkForm.requestSubmit(); pendingGlobalSearch = false; },
            clearQuery() { lastQuery = ''; activeSearchRequest?.abort(); },
            cancel() { activeSearchRequest?.abort(); trademarkResults.style.opacity = '1'; }
        };
        trademarkForm.addEventListener('keydown', event => {
            if (event.key === 'Enter' && !event.target.closest('button') && !event.isComposing) {
                event.preventDefault(); trademarkForm.requestSubmit();
            }
        });

        if (trademarkResults) {
            trademarkResults.addEventListener('click', function (event) {
                const selectAll = event.target.closest('.js-select-all-trademarks');

                if (selectAll) {
                    trademarkResults.querySelectorAll('.js-select-trademark').forEach(checkbox => {
                        checkbox.checked = selectAll.checked;
                    });

                    return;
                }

                const link = event.target.closest('.pagination a');

                if (!link) return;

                event.preventDefault();
                loadTrademarkResults(link.href);
            });

            trademarkResults.addEventListener('change', function (event) {
                if (!event.target.matches('.js-select-trademark')) return;

                const rowChecks = Array.from(trademarkResults.querySelectorAll('.js-select-trademark'));
                const selectAll = trademarkResults.querySelector('.js-select-all-trademarks');

                if (!selectAll || !rowChecks.length) return;

                const checkedCount = rowChecks.filter(checkbox => checkbox.checked).length;
                selectAll.checked = checkedCount === rowChecks.length;
                selectAll.indeterminate = checkedCount > 0 && checkedCount < rowChecks.length;
            });
        }

    })();
    </script>
@endsection
