<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h5 class="mb-0">
                            {{ __('messages.simple_search') }}
                        </h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <label class="form-label">{{ __('messages.our_ref') }} / {{ __('messages.client_ref') }} </label>
                            <div class="input-group">
                                <input wire:model="our_ref" class="form-control"
                                    type="text" placeholder="{{ __('messages.our_ref') }} / {{ __('messages.client_ref') }} "
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
                            <label class="form-label">{{ __('messages.origin') }}</label>
                            <select class="form-control" name="origin" id="origin">
                                <option selected>{{ __('messages.all') }}</option>
                                <option value="{{ __('messages.national') }}">
                                    {{ __('messages.national') }}</option>
                                <option value="{{ __('messages.international') }}">
                                    {{ __('messages.international') }}</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <label class="form-label">{{ __('messages.client') }}</label>
                            <input wire:model="client" class="form-control"
                            type="text" placeholder="{{ __('messages.client') }}"
                            required="required">
                        </div>
                        <div class="col-3">
                            <label class="form-label">{{ __('messages.holder') }}</label>
                            <input wire:model="holder" class="form-control"
                            type="text" placeholder="{{ __('messages.holder') }}"
                            required="required">
                        </div>
                        <div class="col-3">
                            <label class="form-label">{{ __('messages.trademark') }}</label>
                            <input wire:model="trademark" class="form-control"
                            type="text" placeholder="{{ __('messages.trademark') }}"
                            required="required">
                        </div>

                    </div>

                    <div class="d-lg-flex">
                        <div class="ms-auto my-auto mt-lg-0 mt-4">
                            <a class="btn mt-3" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" style="border: 2px solid #F82018; color: #F82018;">
                                {{ __('messages.advanced_search') }}
                            </a>
                        </div>
                    </div>

                    <div class="collapse" id="collapseExample">
                        <div class="row mt-3">
                            <div class="col-3">
                                <label class="form-label">{{ __('messages.status') }}</label>
                                <input wire:model="status" class="form-control"
                                type="text" placeholder="{{ __('messages.status') }}"
                                required="required">
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
                                    <option selected>{{ __('messages.all') }}</option>
                                    @for($i=0; $i<=45; $i++) <option value="{{$i}}">{{$i}}</option> @endfor
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-6">
                                <label class="form-label">{{ __('messages.our_refs') }}</label>
                                <div class="input-group">
                                    <input wire:model="our_refs" class="form-control"
                                        type="text" placeholder="{{ __('messages.our_refs') }}"
                                        required="required">
                                </div>
                            </div>
                            <div class="col-3">
                                <label class="form-label">{{ __('messages.country') }}</label>
                                <div class="input-group">
                                    <select class="form-control js-example-basic-single" name="country" id="country">
                                        <option selected>{{ __('messages.select') }}</option>
                                        @include('client.paises')
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <label class="form-label">{{ __('messages.national') }}</label>
                                <div class="input-group">
                                    <select class="form-control" name="origin" id="origin">
                                        <option selected>{{ __('messages.select') }}</option>
                                        <option value="{{ __('messages.national') }}">
                                            {{ __('messages.national') }}</option>
                                        <option value="{{ __('messages.international') }}">
                                            {{ __('messages.international') }}</option>
                                    </select>
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
