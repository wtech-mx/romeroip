<div class="card tm-results-panel" data-results-total="{{ isset($trademarks) ? $trademarks->total() : 0 }}"
    data-results-per-page="{{ isset($trademarks) ? $trademarks->perPage() : ($perPage ?? 50) }}"
    data-results-url="{{ isset($trademarks) ? $trademarks->url($trademarks->currentPage()) : route('advance_search') }}"
    data-results-query="{{ request('q', '') }}">
    <div class="card-header pb-0">
        <div class="d-lg-flex">
            <div>
                <h5 class="mb-0">Results</h5>
                <p class="text-sm mb-0">Use global search or advanced filters to find specific trademark records.</p>
            </div>

            <div class="ms-auto my-auto mt-lg-0 mt-4">
                <div class="ms-auto my-auto">
                    <button type="button" class="btn btn-sm" data-columns-toggle>Columns</button>
                    <button class="btn btn-sm mb-0 mt-sm-0 mt-1" data-type="csv" data-results-export type="button" name="button" @disabled(!isset($trademarks) || $trademarks->isEmpty())>{{ __('messages.export') }}</button>
                </div>
            </div>
        </div>
    </div>

    @include('trademark._column-preferences')
    <div class="card-body px-0 pb-0">
        @if(isset($trademarks) && $trademarks->total() > 0)
            @include('trademark._results-pagination', ['position' => 'top'])
        @endif
        <div class="table-responsive tm-table-wrap">
            <table class="table table-flush tm-results-table" id="products-list">
                @php
                    $columns = \App\Support\ResultsColumns::definitions();
                @endphp
                <colgroup>@foreach($columns as $key => $column)<col data-column="{{ $key }}">@endforeach</colgroup>
                <thead class="thead-light"><tr>
                    @foreach($columns as $key => $column)
                    <th title="{{ $column['label'] }}" data-column="{{ $key }}" @if(!empty($column['fixed'])) data-fixed="true" @else draggable="true" @endif>
                        @if($key === 'select')
                            <input class="form-check-input js-select-all-trademarks" type="checkbox" aria-label="Select all search results">
                        @elseif($key === 'edit')
                            <span>{{ $column['label'] }}</span>
                        @else
                            <button type="button" class="tm-column-sort" data-sort="{{ $key }}">{{ $column['label'] }}<span data-sort-indicator aria-hidden="true"></span></button>
                        @endif
                        <span class="tm-column-resize" role="separator" tabindex="0" aria-label="Resize {{ $column['label'] ?: 'selection' }} column" aria-orientation="vertical"></span>
                    </th>
                    @endforeach
                </tr></thead>
                <tbody>
                    @forelse(($trademarks ?? collect()) as $trademark)
                    <tr>
                        @foreach($columns as $key => $column)
                        <td data-column="{{ $key }}">
                            @if($key === 'select')
                                <input class="form-check-input js-select-trademark" type="checkbox" value="{{ $trademark->id }}" aria-label="Select trademark {{ $trademark->our_ref }}">
                            @elseif($key === 'edit')
                                <a href="{{ route('edit.trademarks', $trademark->id) }}" class="tm-pencil-link" title="Edit trademark" aria-label="Edit trademark {{ $trademark->our_ref }}"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="m16 3 5 5-12 12-6 1 1-6Z"/><path d="m13 6 5 5"/></svg></a>
                            @else
                                @php
                                    $value = match($key) {
                                        'owner' => optional($trademark->Holder)->company_name,
                                        'client' => optional($trademark->Client)->company_name,
                                        default => $trademark->getAttribute($key),
                                    };
                                    if (($column['type'] ?? '') === 'date' && $value) {
                                        try { $value = \Carbon\Carbon::parse($value)->format('m/d/Y'); } catch (\Throwable $error) { /* Preserve unrecognized legacy text. */ }
                                    }
                                @endphp
                                @if($key === 'our_ref')
                                <a class="tm-result-reference tm-cell-content" data-view-record href="{{ route('show.trademarks', $trademark->id) }}" title="{{ $value }}">{{ $value }}</a>
                                @else
                                <span class="tm-cell-content" title="{{ $value }}">{{ $value }}</span>
                                @endif
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    @empty
                        <tr><td colspan="15" class="tm-empty-results py-4">No results to display.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($trademarks) && $trademarks->total() > 0)
            @include('trademark._results-pagination', ['position' => 'bottom'])
        @endif
    </div>
</div>
