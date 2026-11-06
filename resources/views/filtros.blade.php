@php
    $selectedOrigin = request('origin', '');
    $selectedStatus = request('status') ?: 'Live';
    if ($selectedStatus === 'all_except_abandoned') $selectedStatus = 'Live';
@endphp
<div class="container-fluid">
    <div class="card tm-search-panel">
        <form id="trademark-search-form" action="{{ route('advance_search') }}" method="GET" novalidate>
            <div class="card-header tm-search-heading">
                <div><h5>Search</h5><p class="text-sm mb-0">Use advanced search to apply multiple filters and find specific trademark records.</p></div>
                <div class="tm-search-actions">
                    <button class="btn btn-sm mb-0" type="button" id="tm-advanced-toggle" data-bs-toggle="collapse" data-bs-target="#advancedSearch" aria-expanded="false" aria-controls="advancedSearch">Advanced<span id="tm-advanced-count"></span><i class="bi bi-chevron-up tm-advanced-chevron" aria-hidden="true"></i></button>
                </div>
            </div>
            <div class="collapse" id="advancedSearch">
            <div class="card-body">
                <div class="tm-primary-filters tm-search-grid mt-3">
                    <div><label class="form-label" for="origin">Department</label>
                        <select class="form-control" name="origin" id="origin">
                            <option value="" @selected($selectedOrigin === '')>All</option>
                            <option value="National" @selected($selectedOrigin === 'National')>National</option>
                            <option value="International" @selected(in_array($selectedOrigin, ['International', 'Foreign'], true))>International</option>
                        </select>
                    </div>
                    <div><label class="form-label" for="status">Status</label>
                        <select class="form-control" name="status" id="status">
                            @foreach(['All', 'Live', 'Pending', 'Registered', 'Abandoned'] as $status)
                                <option value="{{ $status }}" @selected($selectedStatus === $status)>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div><label class="form-label" for="search-class">Class</label>
                        <select class="form-control" name="class" id="search-class">
                            <option value="">All</option>
                            @for($i = 1; $i <= 45; $i++)
                                @php($classValue = str_pad($i, 2, '0', STR_PAD_LEFT))
                                <option value="{{ $classValue }}" @selected(request('class') == $classValue || request('class') == $i)>{{ $classValue }}</option>
                            @endfor
                        </select>
                    </div>
                    <div><label class="form-label" for="country">Country / Office</label>
                        <select class="form-control" name="country" id="country">
                            <option value="">All</option>
                            @include('trademark._search-country-options')
                        </select>
                    </div>
                    <div><label class="form-label" for="search-specific-files">Specific Files</label>
                        <input id="search-specific-files" name="specific_files" class="form-control" value="{{ request('specific_files') }}" placeholder="e.g. 1002, 1005-1008" aria-describedby="tm-search-error">
                    </div>
                </div>
                <p id="tm-search-error" role="alert" hidden></p>
                @if($errors->any())<div role="alert">{{ $errors->first() }}</div>@endif
                <div class="tm-date-ranges-grid">
                    @foreach([
                        ['Declaration of Use Due Date', 'last_declaration', 'next_declaration'],
                        ['Renewal Due Date', 'last_renewal', 'next_renewal'],
                        ['Filing Date', 'filing_from', 'filing_to'],
                        ['Registration Date', 'registration_from', 'registration_to'],
                    ] as [$rangeLabel, $from, $to])
                    <div><label class="form-label" for="range-{{ $from }}">{{ $rangeLabel }}</label>
                        <div class="tm-range-control" data-date-range data-range-label="{{ $rangeLabel }}">
                            <input id="range-{{ $from }}" class="form-control" data-range-display aria-label="{{ $rangeLabel }}" placeholder="From — To" autocomplete="off">
                            <input type="hidden" data-range-from name="{{ $from }}" value="{{ request($from) }}">
                            <input type="hidden" data-range-to name="{{ $to }}" value="{{ request($to) }}">
                            <button type="button" data-range-open tabindex="-1" aria-label="Choose {{ $rangeLabel }}"><i class="bi bi-calendar3" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            </div>
        </form>
    </div>
</div>
