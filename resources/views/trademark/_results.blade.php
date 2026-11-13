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

            <div class="tm-results-tools">
                <button type="button" class="btn tm-columns-button" data-columns-toggle title="Columns" aria-label="Columns" aria-expanded="false"><i class="bi bi-layout-three-columns" aria-hidden="true"></i></button>
                <div class="dropdown">
                    <button class="btn tm-export-button" data-results-export type="button" data-bs-toggle="dropdown" aria-expanded="false" @disabled(!isset($trademarks) || $trademarks->isEmpty())>Export <span class="legal-chevron" aria-hidden="true"></span></button>
                    <ul class="dropdown-menu dropdown-menu-end tm-export-menu">
                        @foreach(['xlsx' => 'Excel (.xlsx)', 'docx' => 'Word (.docx)', 'pdf' => 'PDF (.pdf)', 'csv' => 'CSV (.csv)', 'template' => 'Export to Template…'] as $format => $label)
                        <li><button type="button" class="dropdown-item" data-export-format="{{ $format }}">{{ $label }}</button></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @include('trademark._column-preferences')
    <p data-export-status role="status" class="tm-export-status" hidden></p>
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
                                <a href="{{ route('edit.trademarks', $trademark->id) }}" class="tm-pencil-link" title="Edit trademark" aria-label="Edit trademark {{ $trademark->our_ref }}"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="M12 5H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="m16 3 5 5-10 10-5 1 1-5Z"/><path d="m13 6 5 5"/></svg></a>
                            @else
                                @php
                                    $value = \App\Support\ResultsColumns::value($trademark, $key);
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
                        <tr><td colspan="20" class="tm-empty-results py-4">No results to display.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($trademarks) && $trademarks->total() > 0)
            @include('trademark._results-pagination', ['position' => 'bottom'])
        @endif
    </div>
</div>
