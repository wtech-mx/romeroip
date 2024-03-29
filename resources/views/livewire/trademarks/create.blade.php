@section('page_actuality')
{{ __('messages.new_trademark') }}
@endsection

<div class="container-fluid mt-3">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header">
                    <h3 class="mb-3">{{ __('messages.new_trademark') }}</h3>
                    <a class="btn" href="{{ route('index.trademarks') }}"
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
                                                            <textarea class="form-control" wire:model="notes" rows="1"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Card Basic Info -->
                                        <div class="card mt-4" id="profile">
                                            <div class="card-header">
                                                <h5>{{ __('messages.reference_numbers') }}</h5>
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.our_ref') }}</label>
                                                        <div class="input-group">
                                                            <input wire:model="our_ref" class="form-control"
                                                                type="text" placeholder="{{ __('messages.our_ref') }}"
                                                                required="required">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.client_ref') }}</label>
                                                        <div class="input-group">
                                                            <input wire:model="client_ref" class="form-control"
                                                                type="text" placeholder="{{ __('messages.client_ref') }}"
                                                                required="required">
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.opposition_no') }}</label>
                                                        <div class="input-group">
                                                            <input wire:model="opposition_no" class="form-control"
                                                                type="text" placeholder="{{ __('messages.opposition_no') }}"
                                                                required="required">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.filing_date') }}</label>
                                                        <div class="input-group">
                                                            <input wire:model="filing_date_opposition" class="form-control"
                                                                type="date" placeholder="{{ __('messages.filing_date') }}"
                                                                required="required">
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.litigation_no') }}</label>
                                                        <div class="input-group">
                                                            <input wire:model="litigation_no" class="form-control"
                                                                type="text" placeholder="{{ __('messages.litigation_no') }}"
                                                                required="required">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.filing_date') }}</label>
                                                        <div class="input-group">
                                                            <input wire:model="filing_date_litigation" class="form-control"
                                                                type="date" placeholder="{{ __('messages.filing_date') }}"
                                                                required="required">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Card Change Password -->
                                        <div class="card mt-4" id="basic-info">
                                            <div class="card-header">
                                                <h5>{{ __('messages.general_information') }}</h5>
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.application_no') }}</label>
                                                        <div class="input-group">
                                                            <input wire:model="application_no" class="form-control"
                                                                type="text" placeholder="{{ __('messages.application_no') }}"
                                                                required="required">
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.origin') }}</label>
                                                        <div class="input-group">
                                                            <input wire:model="origin" class="form-control"
                                                                type="text" placeholder="{{ __('messages.origin') }}"
                                                                required="required">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.registration_no') }}</label>
                                                        <div class="input-group">
                                                            <input wire:model="registration_no" class="form-control"
                                                                type="text" placeholder="{{ __('messages.registration_no') }}"
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

                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.filing_date') }}</label>
                                                        <div class="input-group">
                                                            <input wire:model="filing_date_general" class="form-control"
                                                                type="date" placeholder="{{ __('messages.filing_date') }}"
                                                                required="required">
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.status') }}</label>
                                                        <select class="form-control" wire:model="status">
                                                            <option selected>{{ __('messages.select') }}</option>
                                                            <option value="{{ __('messages.live') }}">{{ __('messages.live') }}
                                                            </option>
                                                            <option value="{{ __('messages.pending') }}">{{
                                                                __('messages.pending') }}</option>
                                                            <option value="{{ __('messages.abandoned') }}">{{
                                                                __('messages.abandoned') }}</option>
                                                            <option value="{{ __('messages.lapsed') }}">{{ __('messages.lapsed')
                                                                }}</option>
                                                            <option value="{{ __('messages.inactive') }}">{{
                                                                __('messages.inactive') }}</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.first_date') }}</label>
                                                        <div class="input-group">
                                                            <input wire:model="first_date" class="form-control"
                                                                type="date" placeholder="{{ __('messages.first_date') }}"
                                                                required="required">
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.int_registration_no')}}</label>
                                                        <div class="input-group">
                                                            <input wire:model="int_registration_no" class="form-control"
                                                                type="text"
                                                                placeholder="{{ __('messages.int_registration_no') }}"
                                                                required="required">
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.registration_date') }}</label>
                                                        <div class="input-group">
                                                            <input wire:model="registration_date" class="form-control"
                                                                type="date" placeholder="{{ __('messages.registration_date') }}"
                                                                required="required">
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.int_registration_date')}}</label>
                                                        <div class="input-group">
                                                            <input wire:model="int_registration_date" class="form-control"
                                                                type="date"
                                                                placeholder="{{ __('messages.int_registration_date') }}"
                                                                required="required">
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.expiration_date') }}</label>
                                                        <div class="input-group">
                                                            <input wire:model="expiration_date" class="form-control"
                                                                type="date" placeholder="{{ __('messages.expiration_date') }}"
                                                                required="required">
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.contracting_organization')}}</label>
                                                        <div class="input-group">
                                                            <input wire:model="contracting_organization" class="form-control"
                                                                type="text"
                                                                placeholder="{{ __('messages.contracting_organization') }}"
                                                                required="required">
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.publication_date') }}</label>
                                                        <div class="input-group">
                                                            <input wire:model="publication_date" class="form-control"
                                                                type="date" placeholder="{{ __('messages.publication_date') }}"
                                                                required="required">
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.designated_countries')}}</label>
                                                        <div class="input-group">
                                                            <input wire:model="designated_countries" class="form-control"
                                                                type="text"
                                                                placeholder="{{ __('messages.designated_countries') }}"
                                                                required="required">
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                        <!-- Card Change Password -->
                                        <div class="card mt-4" id="password">
                                            <div class="card-header d-flex">
                                                <h5>{{ __('messages.important_dates') }}</h5>
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.declaration_use') }}</label>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.renewal') }}</label>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.last') }}</label>
                                                        <div class="input-group">
                                                            <input wire:model="last_declaration" class="form-control"
                                                                type="date" placeholder="Thompson" required="required">
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.last') }}</label>
                                                        <div class="input-group">
                                                            <input wire:model="last_renewal" class="form-control"
                                                                type="date" placeholder="Thompson" required="required">
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.next') }}</label>
                                                        <div class="input-group">
                                                            <input wire:model="next_declaration" class="form-control"
                                                                type="date" placeholder="Thompson" required="required">
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.next') }}</label>
                                                        <div class="input-group">
                                                            <input wire:model="next_renewal" class="form-control"
                                                                type="date" placeholder="Thompson" required="required">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Card Accounts -->
                                        <div class="card mt-4" id="2fa">
                                            <div class="card-header">
                                                <h5>{{ __('messages.trademark_information') }}</h5>
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <label class="form-label">{{ __('messages.trademark') }}</label>
                                                                <div class="input-group">
                                                                    <input wire:model="trademark" class="form-control"
                                                                        type="text" placeholder="{{ __('messages.trademark') }}"
                                                                        required="required">
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="form-label">{{ __('messages.description')}}</label>
                                                                <div class="input-group">
                                                                    <textarea class="form-control" wire:model="description_trademark" rows="1"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="form-label">{{ __('messages.type_application')}}</label>
                                                                <div class="input-group">
                                                                    <input wire:model="type_application" class="form-control"
                                                                        type="text"
                                                                        placeholder="{{ __('messages.type_application') }}"
                                                                        required="required">
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="form-label">{{ __('messages.type_mark') }}</label>
                                                                <div class="input-group">
                                                                    <input wire:model="type_mark" class="form-control"
                                                                        type="text" placeholder="{{ __('messages.type_mark') }}"
                                                                        required="required">
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="form-label">{{ __('messages.translation')
                                                                    }}</label>
                                                                <div class="input-group">
                                                                    <textarea class="form-control" wire:model="translation" rows="1"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="form-label">{{ __('messages.transliteration')
                                                                    }}</label>
                                                                <div class="input-group">
                                                                    <textarea class="form-control" wire:model="transliteration_trademark" rows="1"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <label class="form-label">{{ __('messages.disclaimer')}}</label>
                                                                <div class="input-group">
                                                                    <textarea class="form-control" wire:model="disclaimer" rows="1"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="form-label">{{ __('messages.design') }}</label>
                                                                <div class="input-group">
                                                                    <input wire:model="design" class="form-control"
                                                                        type="file" placeholder="Thompson" required="required">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mt-5">
                                                                <div class="d-flex justify-content-center">
                                                                    <embed src="{{asset('logo/FEDERIKA.jpg') }}"
                                                                        style="width: 300px; height: 300px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Card Notifications -->
                                        <div class="card mt-4" id="accounts">
                                            <div class="card-header">
                                                <h5>{{ __('messages.goods_services') }}</h5>
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.class') }}</label>
                                                        <div class="input-group">
                                                            <select class="form-control" wire:model="class">
                                                                <option selected>{{ __('messages.select') }}</option>
                                                                @for($i=0; $i<=45; $i++) <option value="{{$i}}">{{$i}}</option> @endfor
                                                            </select>
                                                        </div>
                                                    </div>

                                                    {{-- <div class="col-6">
                                                        <label class="form-label">{{ __('messages.goods_services') }}</label>
                                                        <div class="input-group">
                                                            <input wire:model="lastName" class="form-control"
                                                                type="text" placeholder="{{ __('messages.goods_services') }}"
                                                                required="required">
                                                        </div>
                                                    </div> --}}

                                                    <div class="col-12">
                                                        <label class="form-label">{{ __('messages.description') }}</label>
                                                        <div class="input-group">
                                                            <textarea class="form-control" wire:model="description_good" rows="2"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="form-label">{{ __('messages.translation') }}</label>
                                                        <div class="input-group">
                                                            <textarea class="form-control" wire:model="translation_good" rows="2"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Card Sessions -->
                                        <div class="card mt-4" id="notifications">
                                            <div class="card-header pb-3">
                                                <h5>{{ __('messages.priority_information') }}</h5>
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.priority_no') }}</label>
                                                        <div class="input-group">
                                                            <input wire:model="priority_no" class="form-control"
                                                                type="text" placeholder="{{ __('messages.priority_no') }}"
                                                                required="required">
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.country_office') }}</label>
                                                        <div class="input-group">
                                                            <input wire:model="country_office" class="form-control"
                                                                type="text" placeholder="{{ __('messages.country_office') }}"
                                                                required="required">
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.priority_date') }}</label>
                                                        <div class="input-group">
                                                            <input wire:model="priority_date" class="form-control"
                                                                type="date" placeholder="Thompson" required="required">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Card Delete Account -->
                                        <div class="card mt-4" id="sessions">
                                            <div class="card-header">
                                                <h5>{{ __('messages.client_info') }}</h5>
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="form-label">{{ __('messages.client') }}</label>
                                                        <div class="input-group">
                                                            <input wire:model="client" class="form-control"
                                                                type="text" placeholder="{{ __('messages.client') }}"
                                                                required="required">
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="form-label">{{ __('messages.contact') }}</label>
                                                        <div class="input-group">
                                                            <input wire:model="contact" class="form-control"
                                                                type="number" placeholder="{{ __('messages.contact') }}"
                                                                required="required">
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="form-label">{{ __('messages.address') }}</label>
                                                        <div class="input-group">
                                                            <textarea class="form-control" wire:model="address" rows="1"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Card applicant Account -->
                                        <div class="card mt-4 mb-5" id="holder">
                                            <div class="card-header">
                                                <h5>{{ __('messages.holder_info') }}</h5>
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="form-label">{{ __('messages.holder') }}</label>
                                                        <div class="input-group">
                                                            <input wire:model="holder" class="form-control"
                                                                type="text" placeholder="{{ __('messages.holder') }}"
                                                                required="required">
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="form-label">{{ __('messages.address') }}</label>
                                                        <div class="input-group">
                                                            <textarea class="form-control" wire:model="address_holder"
                                                                rows="1"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="form-label">{{ __('messages.industrial_address')
                                                            }}</label>
                                                        <div class="input-group">
                                                            <textarea class="form-control" wire:model="industrial_address"
                                                                rows="1"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-3">
                                        <div class="card position-sticky top-1">
                                            <ul class="nav flex-column bg-white border-radius-lg p-3">
                                                <li class="nav-item pt-2">
                                                    <a class="nav-link text-body d-flex align-items-center" data-scroll=""
                                                        href="#notes">
                                                        <i class="ni ni-settings-gear-65 me-2 text-dark opacity-6"></i>
                                                        <span class="text-sm">{{ __('messages.note_important') }}</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link text-body d-flex align-items-center" data-scroll=""
                                                        href="#profile">
                                                        <i class="ni ni-spaceship me-2 text-dark opacity-6"></i>
                                                        <span class="text-sm">{{ __('messages.reference_numbers') }}</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item pt-2">
                                                    <a class="nav-link text-body d-flex align-items-center" data-scroll=""
                                                        href="#basic-info">
                                                        <i class="ni ni-books me-2 text-dark opacity-6"></i>
                                                        <span class="text-sm">{{ __('messages.general_information') }}</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item pt-2">
                                                    <a class="nav-link text-body d-flex align-items-center" data-scroll=""
                                                        href="#password">
                                                        <i class="ni ni-atom me-2 text-dark opacity-6"></i>
                                                        <span class="text-sm">{{ __('messages.important_dates') }}</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item pt-2">
                                                    <a class="nav-link text-body d-flex align-items-center" data-scroll=""
                                                        href="#2fa">
                                                        <i class="ni ni-ui-04 me-2 text-dark opacity-6"></i>
                                                        <span class="text-sm">{{ __('messages.trademark_information') }}</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item pt-2">
                                                    <a class="nav-link text-body d-flex align-items-center" data-scroll=""
                                                        href="#accounts">
                                                        <i class="ni ni-badge me-2 text-dark opacity-6"></i>
                                                        <span class="text-sm">{{ __('messages.goods_services') }}</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item pt-2">
                                                    <a class="nav-link text-body d-flex align-items-center" data-scroll=""
                                                        href="#notifications">
                                                        <i class="ni ni-bell-55 me-2 text-dark opacity-6"></i>
                                                        <span class="text-sm">{{ __('messages.priority_information') }}</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item pt-2">
                                                    <a class="nav-link text-body d-flex align-items-center" data-scroll=""
                                                        href="#sessions">
                                                        <i class="ni ni-watch-time me-2 text-dark opacity-6"></i>
                                                        <span class="text-sm">{{ __('messages.client_info') }}</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item pt-2">
                                                    <a class="nav-link text-body d-flex align-items-center" data-scroll=""
                                                        href="#holder">
                                                        <i class="ni ni-settings-gear-65 me-2 text-dark opacity-6"></i>
                                                        <span class="text-sm">{{ __('messages.holder_info') }}</span>
                                                    </a>
                                                </li>
                                            </ul>
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
