<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card tm-search-panel">
                <form action="{{ route('advance_search') }}" method="GET" >

                    <div class="card-header pb-0">
                        <div class="d-lg-flex">
                            <h5 class="mb-0">{{ __('messages.simple_search') }}</h5>
                            <p class="text-sm mb-0"></p>

                            <div class="ms-auto my-auto mt-lg-0 mt-4">
                                <div class="ms-auto my-auto">
                                    <a class="btn btn-sm mb-0 mt-sm-0 mt-1" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        {{ __('messages.advanced_search') }}
                                    </a>

                                    <button class="btn btn-sm mb-0 mt-sm-0 mt-1" type="submit">{{ __('messages.search') }}</button>
                                    {{-- @if(Route::currentRouteName() != 'index.trademarks')
                                    <a class="btn btn-sm mb-0 mt-sm-0 mt-1" href="{{ route('index.trademarks') }}" style="border: 2px solid #F82018; color: #F82018;"><i class="fa fa-refresh"></i></a>
                                    @endif --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <label class="form-label">{{ __('messages.client_ref') }}</label>
                                    <div class="input-group">
                                        <input id="client_ref"
                                            name="client_ref"
                                            class="form-control autocomplete-input"
                                            type="text"
                                            placeholder="{{ __('messages.client_ref') }}"
                                            autocomplete="off">
                                    </div>
                                    <div id="client_ref_suggestions" class="autocomplete-box d-none"></div>
                                </div>
                                <div class="col-3">
                                    <label class="form-label">{{ __('messages.application_no') }}</label>
                                    <div class="input-group">
                                        <input name="application_no" class="form-control"
                                            type="text" value="{{ request('application_no') }}" placeholder="{{ __('messages.application_no') }}">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label class="form-label">{{ __('messages.registration_no') }}</label>
                                    <div class="input-group">
                                        <input name="registration_no" class="form-control" value="{{ request('registration_no') }}"
                                            type="text" placeholder="{{ __('messages.registration_no') }}">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label class="form-label">{{ __('messages.int_registration_no') }}</label>
                                    <div class="input-group">
                                        <input name="int_registration_no" class="form-control"
                                            type="text" value="{{ request('int_registration_no') }}" placeholder="{{ __('messages.int_registration_no') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-3">
                                    <label class="form-label">{{ __('messages.origin') }}</label>
                                    <select class="form-control" name="origin" id="origin">
                                        <option value="" {{ request('origin') == '' ? 'selected' : '' }}>{{ __('messages.all') }}</option>
                                        <option value="{{ __('messages.national') }}" {{ request('origin') == __('messages.national') ? 'selected' : '' }}>
                                            {{ __('messages.national') }}
                                        </option>
                                        <option value="{{ __('messages.international') }}" {{ request('origin') == __('messages.international') ? 'selected' : '' }}>
                                            {{ __('messages.international') }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label class="form-label">{{ __('messages.client') }}</label>
                                    <div class="input-group">
                                        <input id="client_search"
                                            class="form-control autocomplete-input"
                                            type="text"
                                            placeholder="{{ __('messages.client') }}"
                                            autocomplete="off">

                                        <input type="hidden" id="id_client" name="id_client">
                                    </div>
                                    <div id="client_search_suggestions" class="autocomplete-box d-none"></div>
                                </div>
                                <div class="col-3">
                                    <label class="form-label">{{ __('messages.holder') }}</label>
                                    <div class="input-group">
                                        <input id="holder_search"
                                            class="form-control autocomplete-input"
                                            type="text"
                                            placeholder="{{ __('messages.holder') }}"
                                            autocomplete="off">

                                        <input type="hidden" id="id_holder" name="id_holder">
                                    </div>
                                    <div id="holder_search_suggestions" class="autocomplete-box d-none"></div>
                                </div>
                                <div class="col-3">
                                    <label class="form-label">{{ __('messages.trademark') }}</label>
                                    <div class="input-group">
                                        <input id="trademark"
                                            name="trademark"
                                            class="form-control autocomplete-input"
                                            type="text"
                                            placeholder="{{ __('messages.trademark') }}"
                                            autocomplete="off">
                                    </div>
                                    <div id="trademark_suggestions" class="autocomplete-box d-none"></div>
                                </div>

                            </div>

                            <div class="collapse" id="collapseExample">
                                <div class="row mt-3">
                                    <div class="col-3">
                                        <label class="form-label">{{ __('messages.status') }}</label>

                                        <select class="form-control" name="status" id="status">
                                            <option value="" {{ request('status') == '' ? 'selected' : '' }}>{{ __('messages.all') }}</option>
                                            <option value="Registered" {{ request('status') == 'Registered' ? 'selected' : '' }}>
                                                {{ __('messages.registered') }}
                                            </option>
                                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>
                                                {{ __('messages.pending') }}
                                            </option>
                                            <option value="Abandoned" {{ request('status') == 'Abandoned' ? 'selected' : '' }}>
                                                {{ __('messages.abandoned') }}
                                            </option>
                                            <option value="Lapsed" {{ request('status') == 'Lapsed' ? 'selected' : '' }}>
                                                {{ __('messages.lapsed') }}
                                            </option>
                                            <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>
                                                {{ __('messages.inactive') }}
                                            </option>
                                        </select>

                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">{{ __('messages.opposition_no') }}</label>
                                        <div class="input-group">
                                            <input name="opposition_no" class="form-control" value="{{ request('opposition_no') }}"
                                                type="text" placeholder="{{ __('messages.opposition_no') }}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">{{ __('messages.litigation_no') }}</label>
                                        <div class="input-group">
                                            <input name="litigation_no" class="form-control" value="{{ request('litigation_no') }}"
                                                type="text" placeholder="{{ __('messages.litigation_no') }}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">{{ __('messages.class') }}</label>
                                        <select class="form-control" name="class">
                                            <option value="" {{ request('class') == '' ? 'selected' : '' }}>{{ __('messages.all') }}</option>
                                            @for($i=0; $i<=45; $i++) <option value="{{$i}}" {{ request('class') == $i ? 'selected' : '' }}>{{$i}}</option> @endfor
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-6">
                                        <label class="form-label">{{ __('messages.our_refs') }}</label>
                                    </div>
                                </div>

                                <div class="row mt-1">
                                    <div class="col-3">
                                        <label class="form-label">{{ __('messages.from') }}</label>
                                        <div class="input-group">
                                            <input name="from_refs" class="form-control" value="{{ request('from_refs') }}"
                                                type="text" placeholder="{{ __('messages.from') }}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">{{ __('messages.to') }}</label>
                                        <div class="input-group">
                                            <input name="to_refs" class="form-control" value="{{ request('to_refs') }}"
                                                type="text" placeholder="{{ __('messages.to') }}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">{{ __('messages.country') }}</label>
                                        <div class="input-group">
                                            <select class="form-control js-example-basic-single" name="country" id="country">
                                                <option value="" {{ request('country') == '' ? 'selected' : '' }}>{{ __('messages.all') }}</option>
                                                @include('client.paises')
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">{{ __('messages.nationality') }}</label>
                                        <div class="input-group">
                                            <select class="form-control" name="national" id="national">
                                                <option value="" {{ request('national') == '' ? 'selected' : '' }}>{{ __('messages.all') }}</option>
                                                @include('client.paises')
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-6">
                                        <label class="form-label">{{ __('messages.declarations_use') }}</label>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">{{ __('messages.renewals') }}</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-3">
                                        <label class="form-label">{{ __('messages.from') }}</label>
                                        <div class="input-group">
                                            <input name="last_declaration" class="form-control" value="{{ request('last_declaration') }}"
                                                type="date" placeholder="{{ __('messages.from') }}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">{{ __('messages.to') }}</label>
                                        <div class="input-group">
                                            <input name="next_declaration" class="form-control" value="{{ request('next_declaration') }}"
                                                type="date" placeholder="{{ __('messages.to') }}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">{{ __('messages.from') }}</label>
                                        <div class="input-group">
                                            <input name="last_renewal" class="form-control" value="{{ request('last_renewal') }}"
                                                type="date" placeholder="{{ __('messages.from') }}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <label class="form-label">{{ __('messages.to') }}</label>
                                        <div class="input-group">
                                            <input name="next_renewal" class="form-control" value="{{ request('next_renewal') }}"
                                                type="date" placeholder="{{ __('messages.to') }}">
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
