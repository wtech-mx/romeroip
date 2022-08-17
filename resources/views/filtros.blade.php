<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span id="card_title">
                            Filtros
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-2">
                            <label class="form-label">{{ __('messages.our_ref') }}</label>
                            <div class="input-group">
                                <input wire:model="our_ref" class="form-control"
                                    type="text" placeholder="{{ __('messages.our_ref') }}"
                                    required="required">
                            </div>
                        </div>
                        <div class="col-2">
                            <label class="form-label">{{ __('messages.client_ref') }}</label>
                            <div class="input-group">
                                <input wire:model="client_ref" class="form-control"
                                    type="text" placeholder="{{ __('messages.client_ref') }}"
                                    required="required">
                            </div>
                        </div>
                        <div class="col-2">
                            <label class="form-label">{{ __('messages.application_no') }}</label>
                            <div class="input-group">
                                <input wire:model="application_no" class="form-control"
                                    type="text" placeholder="{{ __('messages.application_no') }}"
                                    required="required">
                            </div>
                        </div>
                        <div class="col-2">
                            <label class="form-label">{{ __('messages.registration_no') }}</label>
                            <div class="input-group">
                                <input wire:model="registration_no" class="form-control"
                                    type="text" placeholder="{{ __('messages.registration_no') }}"
                                    required="required">
                            </div>
                        </div>
                        <div class="col-2">
                            <label class="form-label">{{ __('messages.opposition_no') }}</label>
                            <div class="input-group">
                                <input wire:model="opposition_no" class="form-control"
                                    type="text" placeholder="{{ __('messages.opposition_no') }}"
                                    required="required">
                            </div>
                        </div>
                        <div class="col-2">
                            <label class="form-label">{{ __('messages.litigation_no') }}</label>
                            <div class="input-group">
                                <input wire:model="litigation_no" class="form-control"
                                    type="text" placeholder="{{ __('messages.litigation_no') }}"
                                    required="required">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-2">
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
                        <div class="col-2">
                            <label class="form-label">{{ __('messages.origin') }}</label>
                            <select class="form-control" wire:model="status">
                                <option value="ALL" selected>ALL</option>
                                <option value="NATIONAL">NATIONAL</option>
                                <option value="INTERNATIONAL">INTERNATIONAL</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <label class="form-label">National</label>
                            <select class="form-control" wire:model="status">
                                <option value="ALL" selected>ALL</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <label class="form-label">{{ __('messages.type_application')}}</label>
                            <select class="form-control" wire:model="status">
                                <option value="ALL" selected>ALL</option>
                                <option value="NATIONAL">TRADEMARK</option>
                                <option value="INTERNATIONAL">TRADE NAME</option>
                                <option value="INTERNATIONAL">SLOGAN</option>
                                <option value="INTERNATIONAL">COLLECTIVE MARK</option>
                                <option value="INTERNATIONAL">CERTIFICATION MARK</option>
                                <option value="INTERNATIONAL">NONTRADITIONAL</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <label class="form-label">{{ __('messages.trademark') }}</label>
                            <div class="input-group">
                                <input wire:model="trademark" class="form-control"
                                    type="text" placeholder="{{ __('messages.trademark') }}"
                                    required="required">
                            </div>
                        </div>
                        <div class="col-2">
                            <label class="form-label">{{ __('messages.country') }}</label>
                            <select class="form-control" wire:model="status">
                                <option value="ALL" selected>ALL</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-2">
                            <label class="form-label">{{ __('messages.class') }}</label>
                            <select class="form-control" wire:model="class">
                                <option selected>{{ __('messages.select') }}</option>
                                @for($i=0; $i<=45; $i++) <option value="{{$i}}">{{$i}}</option> @endfor
                            </select>
                        </div>
                        <div class="col-2">
                            <label class="form-label">{{ __('messages.goods_services') }}</label>
                            <div class="input-group">
                                <input wire:model="goods_services" class="form-control"
                                    type="text" placeholder="{{ __('messages.goods_services') }}"
                                    required="required">
                            </div>
                        </div>
                        <div class="col-2">
                            <label class="form-label">{{ __('messages.holder') }}</label>
                            <div class="input-group">
                                <input wire:model="holder" class="form-control"
                                    type="text" placeholder="{{ __('messages.holder') }}"
                                    required="required">
                            </div>
                        </div>
                        <div class="col-2">
                            <label class="form-label">{{ __('messages.client') }}</label>
                            <div class="input-group">
                                <input wire:model="client" class="form-control"
                                    type="text" placeholder="{{ __('messages.client') }}"
                                    required="required">
                            </div>
                        </div>
                        <div class="col-2">
                            <label class="form-label">{{ __('messages.filing_date') }}</label>
                            <div class="input-group">
                                <input wire:model="filing_date" class="form-control"
                                    type="date" placeholder="{{ __('messages.filing_date') }}"
                                    required="required">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-3">
                            <label class="form-label">{{ __('messages.last') }} {{ __('messages.declaration_use') }}</label>
                            <div class="input-group">
                                <input wire:model="litigation_no" class="form-control"
                                    type="date" required="required">
                            </div>
                        </div>

                        <div class="col-3">
                            <label class="form-label">{{ __('messages.last') }} {{ __('messages.renewal') }}</label>
                            <div class="input-group">
                                <input wire:model="litigation_no" class="form-control"
                                type="date" required="required">
                            </div>
                        </div>
                        <div class="col-3">
                            <label class="form-label">{{ __('messages.next') }} {{ __('messages.declaration_use') }}</label>
                            <div class="input-group">
                                <input wire:model="goods_services" class="form-control"
                                    type="date" required="required">
                            </div>
                        </div>
                        <div class="col-3">
                            <label class="form-label">{{ __('messages.next') }} {{ __('messages.renewal') }}</label>
                            <div class="input-group">
                                <input wire:model="holder" class="form-control"
                                    type="date" required="required">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
