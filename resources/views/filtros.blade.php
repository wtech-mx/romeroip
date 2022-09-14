<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            {{ __('messages.simple_search') }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <label class="form-label">{{ __('messages.our_ref') }}</label>
                            <div class="input-group">
                                <input wire:model="our_ref" class="form-control"
                                    type="text" placeholder="{{ __('messages.our_ref') }}"
                                    required="required">
                            </div>
                        </div>
                        <div class="col-3">
                            <label class="form-label">{{ __('messages.application_no') }}</label>
                            <div class="input-group">
                                <input wire:model="application_no" class="form-control"
                                    type="text" placeholder="{{ __('messages.application_no') }}"
                                    required="required">
                            </div>
                        </div>
                        <div class="col-3">
                            <label class="form-label">{{ __('messages.registration_no') }}</label>
                            <div class="input-group">
                                <input wire:model="registration_no" class="form-control"
                                    type="text" placeholder="{{ __('messages.registration_no') }}"
                                    required="required">
                            </div>
                        </div>
                        <div class="col-3">
                            <label class="form-label">{{ __('messages.int_registration_no') }}</label>
                            <div class="input-group">
                                <input wire:model="int_registration_no" class="form-control"
                                    type="text" placeholder="{{ __('messages.int_registration_no') }}"
                                    required="required">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-3">
                            <label class="form-label">{{ __('messages.client') }}</label>
                            <select class="form-control">
                                <option value="">{{ __('messages.select') }}</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <label class="form-label">{{ __('messages.trademark') }}</label>
                            <select class="form-control">
                                <option value="">{{ __('messages.select') }}</option>
                                @foreach ($trademarks as $trademark)
                                    <option value="{{ $trademark->id }}">{{ $trademark->trademark }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <label class="form-label">{{ __('messages.origin') }}</label>
                            <select class="form-control" name="origin" id="origin">
                                <option selected>{{ __('messages.select') }}</option>
                                <option value="{{ __('messages.national') }}">
                                    {{ __('messages.national') }}</option>
                                <option value="{{ __('messages.international') }}">
                                    {{ __('messages.international') }}</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <label class="form-label">{{ __('messages.status') }}</label>
                            <select class="form-control" wire:model="status">
                                <option value="{{ __('messages.live') }}" selected>{{ __('messages.live') }}
                                </option>
                                <option value="{{ __('messages.pending') }}">{{
                                    __('messages.pending') }}</option>
                                <option value="{{ __('messages.abandoned') }}">{{
                                    __('messages.abandoned') }}</option>
                                <option value="{{ __('messages.lapsed') }}">{{ __('messages.lapsed')
                                    }}</option>
                                <option value="{{ __('messages.inactive') }}">{{
                                    __('messages.inactive') }}</option>
                                <option value="ALL">ALL</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-lg-flex">
                        <div class="ms-auto my-auto mt-lg-0 mt-4">
                            <a class="btn btn-outline-warning mt-3" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                {{ __('messages.advanced_search') }}
                            </a>
                        </div>
                    </div>

                    <div class="collapse" id="collapseExample">
                        <div class="row mt-3">
                            <div class="col-3">
                                <label class="form-label">{{ __('messages.client_ref') }}</label>
                                <div class="input-group">
                                    <input wire:model="client_ref" class="form-control"
                                        type="text" placeholder="{{ __('messages.client_ref') }}"
                                        required="required">
                                </div>
                            </div>
                            <div class="col-3">
                                <label class="form-label">{{ __('messages.opposition_no') }}</label>
                                <div class="input-group">
                                    <input wire:model="opposition_no" class="form-control"
                                        type="text" placeholder="{{ __('messages.opposition_no') }}"
                                        required="required">
                                </div>
                            </div>
                            <div class="col-3">
                                <label class="form-label">{{ __('messages.litigation_no') }}</label>
                                <div class="input-group">
                                    <input wire:model="litigation_no" class="form-control"
                                        type="text" placeholder="{{ __('messages.litigation_no') }}"
                                        required="required">
                                </div>
                            </div>
                            <div class="col-3">
                                <label class="form-label">{{ __('messages.class') }}</label>
                                <select class="form-control" wire:model="class">
                                    <option selected>{{ __('messages.select') }}</option>
                                    @for($i=0; $i<=45; $i++) <option value="{{$i}}">{{$i}}</option> @endfor
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-6">
                                <label class="form-label">{{ __('messages.our_ref') }}</label>
                                <div class="input-group">
                                    <input wire:model="our_ref" class="form-control"
                                        type="text" placeholder="{{ __('messages.our_ref') }}"
                                        required="required">
                                </div>
                            </div>
                            <div class="col-3">
                                <label class="form-label">{{ __('messages.country') }}</label>
                                <div class="input-group">
                                    <input wire:model="country" class="form-control"
                                        type="text" placeholder="{{ __('messages.country') }}"
                                        required="required">
                                </div>
                            </div>
                            <div class="col-3">
                                <label class="form-label">{{ __('messages.national') }}</label>
                                <div class="input-group">
                                    <input wire:model="national" class="form-control"
                                        type="text" placeholder="{{ __('messages.national') }}"
                                        required="required">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-6">
                                <label class="form-label">{{ __('messages.declaration_use') }}</label>
                            </div>
                            <div class="col-6">
                                <label class="form-label">{{ __('messages.renewal') }}</label>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-3">
                                <label class="form-label">{{ __('messages.from') }}</label>
                                <div class="input-group">
                                    <input wire:model="from" class="form-control"
                                        type="date" placeholder="{{ __('messages.from') }}"
                                        required="required">
                                </div>
                            </div>
                            <div class="col-3">
                                <label class="form-label">{{ __('messages.to') }}</label>
                                <div class="input-group">
                                    <input wire:model="to" class="form-control"
                                        type="date" placeholder="{{ __('messages.to') }}"
                                        required="required">
                                </div>
                            </div>
                            <div class="col-3">
                                <label class="form-label">{{ __('messages.from') }}</label>
                                <div class="input-group">
                                    <input wire:model="from" class="form-control"
                                        type="date" placeholder="{{ __('messages.from') }}"
                                        required="required">
                                </div>
                            </div>
                            <div class="col-3">
                                <label class="form-label">{{ __('messages.to') }}</label>
                                <div class="input-group">
                                    <input wire:model="to" class="form-control"
                                        type="date" placeholder="{{ __('messages.to') }}"
                                        required="required">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
