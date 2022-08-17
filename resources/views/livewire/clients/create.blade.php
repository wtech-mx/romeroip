@section('page_actuality')
{{ __('messages.new_client') }}
@endsection

<div class="container-fluid mt-3">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <h3 class="mb-3">{{ __('messages.new_client') }}</h3>
                    <a class="btn" href="{{ route('index.clients') }}"
                        style="background: {{$configuracion->color_boton_close}}; color: #ffff"> Back</a>
                    @includeif('partials.errors')
                </div>

                <main class="main-content max-height-vh-100 h-100">
                    <form wire:submit.prevent="save">
                        <div class="container-fluid">
                            <div class="row mb-5">

                                <div class="col-lg-9 mt-lg-0 mt-4">
                                    <!-- Card notes Account -->
                                    <div class="card" id="notes">
                                        <div class="card-header">
                                            <h5>{{ __('messages.note_important') }}</h5>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-label">{{ __('messages.note') }}</label>
                                                    <div class="input-group">
                                                        <textarea class="form-control" wire:model="notes"
                                                            rows="1"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card Basic Info -->
                                    <div class="card mt-4" id="profile">
                                        <div class="card-header">
                                            <h5>{{ __('messages.client') }}</h5>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-label">{{ __('messages.company_name') }}</label>
                                                    <div class="input-group">
                                                        <input wire:model="company_name" class="form-control" type="text"
                                                            placeholder="{{ __('messages.company_name') }}"
                                                            required="required">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">R.F.C.</label>
                                                    <div class="input-group">
                                                        <input wire:model="vat_no" class="form-control"
                                                            type="text" placeholder="R.F.C."
                                                            required="required">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">{{ __('messages.country') }}</label>
                                                    <div class="input-group">
                                                        <input wire:model="country" class="form-control"
                                                            type="text" placeholder="{{ __('messages.country') }}"
                                                            required="required">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card Change Password -->
                                    <div class="card mt-4" id="basic-info">
                                        <div class="card-header">
                                            <h5>{{ __('messages.contact') }}</h5>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="form-label">{{ __('messages.contact_name')}}</label>
                                                    <div class="input-group">
                                                        <input wire:model="name" class="form-control"
                                                            type="text"
                                                            placeholder="{{ __('messages.contact_name') }}"
                                                            required="required">
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <label class="form-label">{{ __('messages.short_name') }}</label>
                                                    <div class="input-group">
                                                        <input wire:model="short_name" class="form-control" type="text"
                                                            placeholder="{{ __('messages.short_name') }}"
                                                            required="required">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="form-label">{{ __('messages.position')}}</label>
                                                    <div class="input-group">
                                                        <input wire:model="position" class="form-control"
                                                            type="text"
                                                            placeholder="{{ __('messages.position') }}"
                                                            required="required">
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <label class="form-label">{{ __('messages.email') }}</label>
                                                    <div class="input-group">
                                                        <input wire:model="email" class="form-control" type="text"
                                                            placeholder="{{ __('messages.email') }}"
                                                            required="required">
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <label class="form-label">{{ __('messages.website') }}</label>
                                                    <div class="input-group">
                                                        <input wire:model="web_page" class="form-control"
                                                            type="text" placeholder="{{ __('messages.website') }}"
                                                            required="required">
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <!-- Card Change Password -->
                                    <div class="card mt-4" id="password">
                                        <div class="card-header d-flex">
                                            <h5>{{ __('messages.address') }} {{ __('messages.contact') }}</h5>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="form-label">{{ __('messages.address') }}</label>
                                                    <div class="input-group">
                                                        <textarea class="form-control" wire:model="address"
                                                        rows="1"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <label class="form-label">{{ __('messages.billing_address') }}</label>
                                                    <div class="input-group">
                                                        <textarea class="form-control" wire:model="billing_address"
                                                        rows="1"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card Accounts -->
                                    <div class="card mt-4" id="password">
                                        <div class="card-header d-flex">
                                            <h5>{{ __('messages.phone') }} {{ __('messages.contact') }}</h5>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="form-label">{{ __('messages.phone') }}</label>
                                                    <div class="input-group">
                                                        <input wire:model="phone" class="form-control"
                                                        type="number" placeholder="{{ __('messages.phone') }}"
                                                        required="required">
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <label class="form-label">Fax</label>
                                                    <div class="input-group">
                                                        <input wire:model="phone" class="form-control"
                                                        type="number" placeholder="Fax"
                                                        required="required">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </main>

            </div>
        </div>
    </div>
</div>
