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
                    <button class="btn btn-sm mb-0 mt-sm-0 mt-1" data-type="csv" data-results-export type="button" name="button" @disabled(!isset($trademarks) || $trademarks->isEmpty())>{{ __('messages.export') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body px-0 pb-0">
        @if(isset($trademarks) && $trademarks->total() > 0)
            @include('trademark._results-pagination', ['position' => 'top'])
        @endif
        <div class="table-responsive tm-table-wrap">
            <table class="table table-flush tm-results-table" id="products-list">
                <thead class="thead-light">
                    <tr>
                        <th class="tm-select-col">
                            <input class="form-check-input js-select-all-trademarks" type="checkbox" aria-label="Select all search results">
                        </th>
                        <th>{{ __('messages.action') }}</th>
                        <th>{{ __('messages.our_ref') }}</th>
                        <th>{{ __('messages.trademark') }}</th>
                        <th>{{ __('messages.class') }}</th>
                        <th>{{ __('messages.application_no') }}</th>
                        <th>{{ __('messages.registration_no') }}</th>
                        <th>{{ __('messages.registration_date') }}</th>
                        <th>{{ __('messages.declaration_use') }}</th>
                        <th>{{ __('messages.renewal') }}</th>
                        <th>{{ __('messages.holder') }}</th>
                        <th>{{ __('messages.client') }}</th>
                        <th>{{ __('messages.client_ref') }}</th>
                        <th>{{ __('messages.origin') }}</th>
                        <th>{{ __('messages.status') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @if(isset($trademarks))
                        @forelse ($trademarks as $trademark)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input js-select-trademark" type="checkbox" value="{{ $trademark->id }}" aria-label="Select trademark {{ $trademark->our_ref }}">
                                    </div>
                                </td>
                                <td class="text-sm tm-actions-cell">
                                    <a href="{{ route('show.trademarks', $trademark->id) }}" class="tm-edit-link" data-bs-toggle="tooltip" data-bs-original-title="View trademark">
                                        view
                                    </a>
                                    <a href="{{ route('edit.trademarks', $trademark->id) }}" class="tm-edit-link" data-bs-toggle="tooltip" data-bs-original-title="Edit trademark">
                                        edit
                                    </a>
                                </td>
                                <td>{{ $trademark->our_ref }}</td>
                                <td>{{ $trademark->trademark }}</td>
                                <td>{{ $trademark->class }}</td>
                                <td>{{ $trademark->application_no }}</td>
                                <td>{{ $trademark->registration_no }}</td>
                                <td>{{ $trademark->registration_date }}</td>
                                <td>{{ $trademark->last_declaration }}</td>
                                <td>{{ $trademark->last_renewal }}</td>
                                <td>{{ optional($trademark->Holder)->company_name }}</td>
                                <td>{{ optional($trademark->Client)->company_name }}</td>
                                <td>{{ $trademark->client_ref }}</td>
                                <td>{{ $trademark->origin }}</td>
                                <td>{{ $trademark->status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="15" class="tm-empty-results py-4">
                                    No results to display.
                                </td>
                            </tr>
                        @endforelse
                    @else
                        <tr>
                            <td colspan="15" class="tm-empty-results py-4">
                                No results to display.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if(isset($trademarks) && $trademarks->total() > 0)
            @include('trademark._results-pagination', ['position' => 'bottom'])
        @endif
    </div>
</div>
