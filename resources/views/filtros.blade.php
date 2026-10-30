@php
    $selectedOrigin = request()->has('origin') ? request('origin') : '';
    $selectedStatus = request()->has('status') ? request('status') : 'all_except_abandoned';
@endphp

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card tm-search-panel">
                <form id="trademark-search-form" action="{{ route('advance_search') }}" method="GET">
                    <div class="card-header pb-0">
                        <div class="d-lg-flex align-items-center">
                            <div>
                                <h5 class="mb-0">Search</h5>
                                <p class="text-sm mb-0">Quick global search across trademark files.</p>
                            </div>

                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row align-items-end tm-primary-filters">
                            <div class="col-12 tm-global-search">
                                <label class="form-label">Search</label>
                                <input name="q" class="form-control" type="text" value="{{ request('q') }}"
                                    placeholder="Trademark, Reference, Number, Owner or Client..."
                                    autocomplete="off">
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <label class="form-label">{{ __('messages.country') }}</label>
                                <select class="form-control js-example-basic-single" name="country" id="country">
                                    <option value="" {{ request('country') == '' ? 'selected' : '' }}>{{ __('messages.all') }}</option>
                                    @include('trademark._search-country-options')
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <label class="form-label">{{ __('messages.origin') }}</label>
                                <select class="form-control" name="origin" id="origin">
                                    <option value="" {{ $selectedOrigin == '' ? 'selected' : '' }}>{{ __('messages.all') }}</option>
                                    <option value="Foreign" {{ $selectedOrigin == 'Foreign' ? 'selected' : '' }}>Foreign</option>
                                    <option value="{{ __('messages.national') }}" {{ $selectedOrigin == __('messages.national') ? 'selected' : '' }}>
                                        {{ __('messages.national') }}
                                    </option>
                                    <option value="{{ __('messages.international') }}" {{ $selectedOrigin == __('messages.international') ? 'selected' : '' }}>
                                        {{ __('messages.international') }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <label class="form-label">{{ __('messages.status') }}</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="all_except_abandoned" {{ $selectedStatus == 'all_except_abandoned' ? 'selected' : '' }}>All except Abandoned</option>
                                    <option value="" {{ $selectedStatus == '' ? 'selected' : '' }}>{{ __('messages.all') }}</option>
                                    <option value="Registered" {{ $selectedStatus == 'Registered' ? 'selected' : '' }}>{{ __('messages.registered') }}</option>
                                    <option value="Pending" {{ $selectedStatus == 'Pending' ? 'selected' : '' }}>{{ __('messages.pending') }}</option>
                                    <option value="Abandoned" {{ $selectedStatus == 'Abandoned' ? 'selected' : '' }}>{{ __('messages.abandoned') }}</option>
                                    <option value="Lapsed" {{ $selectedStatus == 'Lapsed' ? 'selected' : '' }}>{{ __('messages.lapsed') }}</option>
                                    <option value="Inactive" {{ $selectedStatus == 'Inactive' ? 'selected' : '' }}>{{ __('messages.inactive') }}</option>
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <label class="form-label">{{ __('messages.class') }}</label>
                                <select class="form-control" name="class">
                                    <option value="" {{ request('class') == '' ? 'selected' : '' }}>{{ __('messages.all') }}</option>
                                    @for($i = 1; $i <= 45; $i++)
                                        @php($classValue = str_pad($i, 2, '0', STR_PAD_LEFT))
                                        <option value="{{ $classValue }}" {{ request('class') == $classValue || request('class') == $i ? 'selected' : '' }}>{{ $classValue }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="tm-search-actions">
                            <button class="btn btn-sm mb-0" type="button" id="tm-advanced-toggle" data-bs-toggle="collapse" data-bs-target="#advancedSearch" aria-expanded="false" aria-controls="advancedSearch">Advanced Search<span id="tm-advanced-count"></span></button>
                            <button class="btn btn-sm mb-0" type="submit">{{ __('messages.search') }}</button>
                        </div>
                        <div class="collapse" id="advancedSearch">
                            <div class="row mt-3">
                                <div class="col-6">
                                    <label class="form-label">Our Refs.</label>
                                    <div class="row">
                                        <div class="col-6"><input name="from_refs" class="form-control" type="text" value="{{ request('from_refs') }}" placeholder="From"></div>
                                        <div class="col-6"><input name="to_refs" class="form-control" type="text" value="{{ request('to_refs') }}" placeholder="To"></div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Filing Date</label>
                                    <div class="row">
                                        <div class="col-6"><input name="filing_from" class="form-control" type="date" value="{{ request('filing_from') }}"></div>
                                        <div class="col-6"><input name="filing_to" class="form-control" type="date" value="{{ request('filing_to') }}"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-6">
                                    <label class="form-label">Registration Date</label>
                                    <div class="row">
                                        <div class="col-6"><input name="registration_from" class="form-control" type="date" value="{{ request('registration_from') }}"></div>
                                        <div class="col-6"><input name="registration_to" class="form-control" type="date" value="{{ request('registration_to') }}"></div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">{{ __('messages.declarations_use') }}</label>
                                    <div class="row">
                                        <div class="col-6"><input name="last_declaration" class="form-control" type="date" value="{{ request('last_declaration') }}"></div>
                                        <div class="col-6"><input name="next_declaration" class="form-control" type="date" value="{{ request('next_declaration') }}"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-6">
                                    <label class="form-label">{{ __('messages.renewals') }}</label>
                                    <div class="row">
                                        <div class="col-6"><input name="last_renewal" class="form-control" type="date" value="{{ request('last_renewal') }}"></div>
                                        <div class="col-6"><input name="next_renewal" class="form-control" type="date" value="{{ request('next_renewal') }}"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
