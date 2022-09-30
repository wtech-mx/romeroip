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
                    <form class="form-inline">
                        <div class="row">
                            <div class="col-3">
                                <label class="form-label">{{ __('messages.our_ref') }} / {{ __('messages.client_ref') }} </label>
                                <div class="input-group">
                                    <input name="client_ref" class="form-control"
                                        type="search" placeholder="{{ __('messages.our_ref') }} / {{ __('messages.client_ref') }} ">
                                </div>
                            </div>
                            <div class="col-3">
                                <label class="form-label">{{ __('messages.application_no') }}</label>
                                <div class="input-group">
                                    <input name="application_no" class="form-control"
                                        type="text" placeholder="{{ __('messages.application_no') }}">
                                </div>
                            </div>
                            <div class="col-3">
                                <label class="form-label">{{ __('messages.registration_no') }}</label>
                                <div class="input-group">
                                    <input name="registration_no" class="form-control"
                                        type="text" placeholder="{{ __('messages.registration_no') }}">
                                </div>
                            </div>
                            <div class="col-3">
                                <label class="form-label">{{ __('messages.int_registration_no') }}</label>
                                <div class="input-group">
                                    <input name="int_registration_no" class="form-control"
                                        type="text" placeholder="{{ __('messages.int_registration_no') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-3">
                                <label class="form-label">{{ __('messages.origin') }}</label>
                                <select class="form-control" name="origin" id="origin">
                                    <option value="" selected>{{ __('messages.all') }}</option>
                                    <option value="{{ __('messages.national') }}">
                                        {{ __('messages.national') }}</option>
                                    <option value="{{ __('messages.international') }}">
                                        {{ __('messages.international') }}</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <label class="form-label">{{ __('messages.client') }}</label>
                                <input name="id_client" id="id_client" class="form-control"
                                type="text" placeholder="{{ __('messages.client') }}">
                            </div>
                            <div class="col-3">
                                <label class="form-label">{{ __('messages.holder') }}</label>
                                <input name="id_holder" class="form-control"
                                type="text" placeholder="{{ __('messages.holder') }}">
                            </div>
                            <div class="col-3">
                                <label class="form-label">{{ __('messages.trademark') }}</label>
                                <input name="trademark" class="form-control"
                                type="text" placeholder="{{ __('messages.trademark') }}">
                            </div>

                        </div>

                        <div class="d-lg-flex">
                            <div class="ms-auto mt-4 p-2">
                                <a class="btn mt-3" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" style="border: 2px solid #F82018; color: #F82018;">
                                    {{ __('messages.advanced_search') }}
                                </a>
                            </div>

                            <div class="ms-auto mt-4 p-2">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                            </div>
                        </div>

                        <div class="collapse" id="collapseExample">
                            <div class="row mt-3">
                                <div class="col-3">
                                    <label class="form-label">{{ __('messages.status') }}</label>
                                    <input name="status" class="form-control"
                                    type="text" placeholder="{{ __('messages.status') }}">
                                </div>
                                <div class="col-3">
                                    <label class="form-label">{{ __('messages.opposition_no') }}</label>
                                    <div class="input-group">
                                        <input name="opposition_no" class="form-control"
                                            type="text" placeholder="{{ __('messages.opposition_no') }}">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label class="form-label">{{ __('messages.litigation_no') }}</label>
                                    <div class="input-group">
                                        <input name="litigation_no" class="form-control"
                                            type="text" placeholder="{{ __('messages.litigation_no') }}">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label class="form-label">{{ __('messages.class') }}</label>
                                    <select class="form-control" name="class">
                                        <option value="" selected>{{ __('messages.all') }}</option>
                                        @for($i=0; $i<=45; $i++) <option value="{{$i}}">{{$i}}</option> @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-6">
                                    <label class="form-label">{{ __('messages.our_refs') }}</label>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-3">
                                    <label class="form-label">{{ __('messages.from') }}</label>
                                    <div class="input-group">
                                        <input name="from_refs" class="form-control"
                                            type="text" placeholder="{{ __('messages.from') }}">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label class="form-label">{{ __('messages.to') }}</label>
                                    <div class="input-group">
                                        <input name="to_refs" class="form-control"
                                            type="text" placeholder="{{ __('messages.to') }}">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label class="form-label">{{ __('messages.country') }}</label>
                                    <div class="input-group">
                                        <select class="form-control js-example-basic-single" name="country" id="country">
                                            <option value="" selected>{{ __('messages.select') }}</option>
                                            @include('client.paises')
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label class="form-label">{{ __('messages.national') }}</label>
                                    <div class="input-group">
                                        <select class="form-control" name="origin" id="origin">
                                            <option value="" selected>{{ __('messages.select') }}</option>
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
                                        <input name="last_declaration" class="form-control"
                                            type="date" placeholder="{{ __('messages.from') }}"
                                            >
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label class="form-label">{{ __('messages.to') }}</label>
                                    <div class="input-group">
                                        <input name="next_declaration" class="form-control"
                                            type="date" placeholder="{{ __('messages.to') }}"
                                            >
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label class="form-label">{{ __('messages.from') }}</label>
                                    <div class="input-group">
                                        <input name="last_renewal" class="form-control"
                                            type="date" placeholder="{{ __('messages.from') }}"
                                            >
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label class="form-label">{{ __('messages.to') }}</label>
                                    <div class="input-group">
                                        <input name="next_renewal" class="form-control"
                                            type="date" placeholder="{{ __('messages.to') }}"
                                            >
                                    </div>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
