<div class="card tm-results-panel">
    <div class="card-header pb-0">
        <div class="d-lg-flex">
            <div>
                <h5 class="mb-0">{{ __('messages.all_trademark') }}: {{ isset($trademarks) ? $trademarks->total() : 0 }}</h5>
                <p class="text-sm mb-0"></p>
            </div>

            <div class="ms-auto my-auto mt-lg-0 mt-4">
                <div class="ms-auto my-auto">
                    <button class="btn btn-sm mb-0 mt-sm-0 mt-1" data-type="csv" type="button" name="button">{{ __('messages.export') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body px-0 pb-0">
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
                                <td colspan="15" class="text-center py-4">
                                    No records were found with the selected filters.
                                </td>
                            </tr>
                        @endforelse
                    @else
                        <tr>
                            <td colspan="15" class="text-center py-4">
                                Use the filters to search trademarks.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if(isset($trademarks) && $trademarks->hasPages())
            <div class="px-4 py-3">
                {{ $trademarks->links() }}
            </div>
        @endif
    </div>
</div>
