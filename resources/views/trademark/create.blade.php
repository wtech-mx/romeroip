@extends('layouts.app')

@section('template_title')
    {{ __('messages.new_trademark') }}
@endsection
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <form method="POST" action="{{ route('store.trademarks') }}" enctype="multipart/form-data" role="form">
                        @csrf
                        <div class="card-header">
                            <h3 class="mb-3">{{ __('messages.new_trademark') }}</h3>
                            <a class="btn" href="javascript: history.go(-1)"
                                style="background: {{ $configuracion->color_boton_close }}; color: #ffff"> {{ __('messages.back') }}</a>
                            @includeif('partials.errors')
                            <button type="submit" class="btn"
                            style="border: 2px solid #F82018; color: #F82018;">{{ __('messages.save') }}</button>
                        </div>

                        <div class="card-body">
                            <main class="main-content max-height-vh-100 h-100">
                                <div class="container-fluid">
                                    <div class="row mb-5">

                                        <div class="col-lg-9 mt-lg-0 mt-4">
                                            <!-- Card notes -->
                                            <div class="card" id="notes">
                                                <div class="card-header">
                                                    <h5>{{ __('messages.note_important') }}</h5>
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="form-label">{{ __('messages.note') }}</label>
                                                            <div class="input-group">
                                                                <textarea class="form-control" id="notes" name="notes" rows="1"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Card References number -->
                                            <div class="card mt-4" id="profile">
                                                <div class="card-header">
                                                    <h5>{{ __('messages.reference_numbers') }}</h5>
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label class="form-label">{{ __('messages.our_ref') }}</label>
                                                            <div class="input-group">
                                                                <input id="our_ref" name="our_ref" class="form-control"
                                                                    type="text" placeholder="{{ __('messages.our_ref') }}"
                                                                    required="required">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label">{{ __('messages.client_ref') }}</label>
                                                            <div class="input-group">
                                                                <input id="client_ref" name="client_ref" class="form-control"
                                                                    type="text" placeholder="{{ __('messages.client_ref') }}"
                                                                    required="required">
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <label
                                                                class="form-label">{{ __('messages.opposition_no') }}</label>
                                                            <div class="input-group">
                                                                <input id="opposition_no" name="opposition_no" class="form-control"
                                                                    type="text"
                                                                    placeholder="{{ __('messages.opposition_no') }}"
                                                                    required="required">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label">{{ __('messages.filing_date') }}</label>
                                                            <div class="input-group">
                                                                <input id="filing_date_opposition" name="filing_date_opposition" class="form-control"
                                                                    type="date"
                                                                    placeholder="{{ __('messages.filing_date') }}"
                                                                    required="required">
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <label
                                                                class="form-label">{{ __('messages.litigation_no') }}</label>
                                                            <div class="input-group">
                                                                <input id="litigation_no" name="litigation_no" class="form-control"
                                                                    type="text"
                                                                    placeholder="{{ __('messages.litigation_no') }}"
                                                                    required="required">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label">{{ __('messages.filing_date') }}</label>
                                                            <div class="input-group">
                                                                <input id="filing_date_litigation" name="filing_date_litigation" class="form-control"
                                                                    type="date"
                                                                    placeholder="{{ __('messages.filing_date') }}"
                                                                    required="required">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Card General Information -->
                                            <div class="card mt-4" id="basic-info">
                                                <div class="card-header">
                                                    <h5>{{ __('messages.general_information') }}</h5>
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label
                                                                class="form-label">{{ __('messages.application_no') }}</label>
                                                            <div class="input-group">
                                                                <input id="application_no" name="application_no" class="form-control"
                                                                    type="text"
                                                                    placeholder="{{ __('messages.application_no') }}"
                                                                    required="required">
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <label class="form-label">{{ __('messages.origin') }}</label>
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
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label
                                                                class="form-label">{{ __('messages.registration_no') }}</label>
                                                            <div class="input-group">
                                                                <input id="registration_no" name="registration_no" class="form-control"
                                                                    type="text"
                                                                    placeholder="{{ __('messages.registration_no') }}"
                                                                    required="required">
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <label class="form-label">{{ __('messages.country') }}</label>
                                                            <div class="input-group">
                                                                <select class="form-control js-example-basic-single" name="country" id="country">
                                                                    @include('client.paises')
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <label class="form-label">{{ __('messages.filing_date') }}</label>
                                                            <div class="input-group">
                                                                <input id="filing_date_general" name="filing_date_general" class="form-control"
                                                                    type="date"
                                                                    placeholder="{{ __('messages.filing_date') }}"
                                                                    required="required">
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <label class="form-label">{{ __('messages.status') }}</label>
                                                            <select class="form-control" id="status" name="status">
                                                                <option selected>{{ __('messages.select') }}</option>
                                                                <option value="{{ __('messages.live') }}">
                                                                    {{ __('messages.live') }}</option>
                                                                <option value="{{ __('messages.pending') }}">
                                                                    {{ __('messages.pending') }}</option>
                                                                <option value="{{ __('messages.abandoned') }}">
                                                                    {{ __('messages.abandoned') }}</option>
                                                                <option value="{{ __('messages.lapsed') }}">
                                                                    {{ __('messages.lapsed') }}</option>
                                                                <option value="{{ __('messages.inactive') }}">
                                                                    {{ __('messages.inactive') }}</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-6">
                                                            <label class="form-label">{{ __('messages.first_date') }}</label>
                                                            <div class="input-group">
                                                                <input id="first_date" name="first_date" class="form-control"
                                                                    type="date"
                                                                    placeholder="{{ __('messages.first_date') }}"
                                                                    required="required">
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <label
                                                                class="form-label">{{ __('messages.int_registration_no') }}</label>
                                                            <div class="input-group">
                                                                <input id="int_registration_no" name="int_registration_no" class="form-control"
                                                                    type="text"
                                                                    placeholder="{{ __('messages.int_registration_no') }}"
                                                                    required="required">
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <label
                                                                class="form-label">{{ __('messages.registration_date') }}</label>
                                                            <div class="input-group">
                                                                <input id="registration_date" name="registration_date" class="form-control"
                                                                    type="date"
                                                                    placeholder="{{ __('messages.registration_date') }}"
                                                                    required="required">
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <label
                                                                class="form-label">{{ __('messages.int_registration_date') }}</label>
                                                            <div class="input-group">
                                                                <input id="int_registration_date" name="int_registration_date" class="form-control"
                                                                    type="date"
                                                                    placeholder="{{ __('messages.int_registration_date') }}"
                                                                    required="required">
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <label
                                                                class="form-label">{{ __('messages.expiration_date') }}</label>
                                                            <div class="input-group">
                                                                <input id="expiration_date" name="expiration_date" class="form-control"
                                                                    type="date"
                                                                    placeholder="{{ __('messages.expiration_date') }}"
                                                                    required="required">
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <label
                                                                class="form-label">{{ __('messages.contracting_organization') }}</label>
                                                            <div class="input-group">
                                                                <input id="contracting_organization" name="contracting_organization" class="form-control"
                                                                    type="text"
                                                                    placeholder="{{ __('messages.contracting_organization') }}"
                                                                    required="required">
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <label
                                                                class="form-label">{{ __('messages.publication_date') }}</label>
                                                            <div class="input-group">
                                                                <input id="publication_date" name="publication_date" class="form-control"
                                                                    type="date"
                                                                    placeholder="{{ __('messages.publication_date') }}"
                                                                    required="required">
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <label
                                                                class="form-label">{{ __('messages.designated_countries') }}</label>
                                                            <div class="input-group">
                                                                <input id="designated_countries" name="designated_countries" class="form-control"
                                                                    type="text"
                                                                    placeholder="{{ __('messages.designated_countries') }}"
                                                                    required="required">
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                            <!-- Card Dates -->
                                            <div class="card mt-4" id="password">
                                                <div class="card-header d-flex">
                                                    <h5>{{ __('messages.important_dates') }}</h5>
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label
                                                                class="form-label">{{ __('messages.declaration_use') }}</label>
                                                        </div>

                                                        <div class="col-6">
                                                            <label class="form-label">{{ __('messages.renewal') }}</label>
                                                        </div>

                                                        <div class="col-6">
                                                            <label class="form-label">{{ __('messages.last') }}</label>
                                                            <div class="input-group">
                                                                <input id="last_declaration" name="last_declaration" class="form-control"
                                                                    type="date" placeholder="Thompson"
                                                                    required="required">
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <label class="form-label">{{ __('messages.last') }}</label>
                                                            <div class="input-group">
                                                                <input id="last_renewal" name="last_renewal" class="form-control"
                                                                    type="date" placeholder="Thompson"
                                                                    required="required">
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <label class="form-label">{{ __('messages.next') }}</label>
                                                            <div class="input-group">
                                                                <input id="next_declaration" name="next_declaration" class="form-control"
                                                                    type="date" placeholder="Thompson"
                                                                    required="required">
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <label class="form-label">{{ __('messages.next') }}</label>
                                                            <div class="input-group">
                                                                <input id="next_renewal" name="next_renewal" class="form-control"
                                                                    type="date" placeholder="Thompson"
                                                                    required="required">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Card Trademark -->
                                            <div class="card mt-4" id="2fa">
                                                <div class="card-header">
                                                    <h5>{{ __('messages.trademark_information') }}</h5>
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label
                                                                        class="form-label">{{ __('messages.trademark') }}</label>
                                                                    <div class="input-group">
                                                                        <input id="trademark" name="trademark"
                                                                            class="form-control" type="text"
                                                                            placeholder="{{ __('messages.trademark') }}"
                                                                            required="required">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label
                                                                        class="form-label">{{ __('messages.description') }}</label>
                                                                    <div class="input-group">
                                                                        <textarea class="form-control" id="description_trademark" name="description_trademark" rows="1"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label
                                                                        class="form-label">{{ __('messages.type_application') }}</label>
                                                                    <div class="input-group">
                                                                        <input id="type_application" name="type_application"
                                                                            class="form-control" type="text"
                                                                            placeholder="{{ __('messages.type_application') }}"
                                                                            required="required">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label
                                                                        class="form-label">{{ __('messages.type_mark') }}</label>
                                                                    <div class="input-group">
                                                                        <input id="type_mark" name="type_mark"
                                                                            class="form-control" type="text"
                                                                            placeholder="{{ __('messages.type_mark') }}"
                                                                            required="required">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label
                                                                        class="form-label">{{ __('messages.translation') }}</label>
                                                                    <div class="input-group">
                                                                        <textarea class="form-control" id="translation" name="translation" rows="1"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label
                                                                        class="form-label">{{ __('messages.transliteration') }}</label>
                                                                    <div class="input-group">
                                                                        <textarea class="form-control" id="transliteration_trademark" name="transliteration_trademark" rows="1"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label
                                                                        class="form-label">{{ __('messages.disclaimer') }}</label>
                                                                    <div class="input-group">
                                                                        <textarea class="form-control" id="disclaimer" name="disclaimer" rows="1"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <label
                                                                        class="form-label">{{ __('messages.design') }}</label>
                                                                    <div class="input-group">
                                                                        <input id="design" name="design"
                                                                            class="form-control" type="file"
                                                                            placeholder="Thompson" required="required">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 mt-5">
                                                                    <div class="input-group">
                                                                        <embed src="{{ asset('logo/FEDERIKA.jpg') }}"
                                                                            style="width: 300px; height: 300px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Card Good Service -->
                                            <div class="card mt-4" id="accounts">
                                                <div class="card-header">
                                                    <h5>{{ __('messages.goods_services') }}</h5>
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label class="form-label">{{ __('messages.class') }}</label>
                                                            <div class="input-group">
                                                                <select class="form-control" id="class" name="class">
                                                                    <option selected>{{ __('messages.select') }}</option>
                                                                    @for ($i = 0; $i <= 45; $i++)
                                                                        <option value="{{ $i }}">
                                                                            {{ $i }}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <label class="form-label">{{ __('messages.description') }}</label>
                                                            <div class="input-group">
                                                                <textarea class="form-control" id="description_good" name="description_good" rows="2"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <label class="form-label">{{ __('messages.translation') }}</label>
                                                            <div class="input-group">
                                                                <textarea class="form-control" id="translation_good" name="translation_good" rows="2"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Card Information -->
                                            <div class="card mt-4" id="notifications">
                                                <div class="card-header pb-3">
                                                    <h5>{{ __('messages.priority_information') }}</h5>
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label class="form-label">{{ __('messages.priority_no') }}</label>
                                                            <div class="input-group">
                                                                <input id="priority_no" name="priority_no" class="form-control"
                                                                    type="text"
                                                                    placeholder="{{ __('messages.priority_no') }}"
                                                                    required="required">
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <label
                                                                class="form-label">{{ __('messages.country_office') }}</label>
                                                            <div class="input-group">
                                                                <input id="country_office" name="country_office" class="form-control"
                                                                    type="text"
                                                                    placeholder="{{ __('messages.country_office') }}"
                                                                    required="required">
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <label
                                                                class="form-label">{{ __('messages.priority_date') }}</label>
                                                            <div class="input-group">
                                                                <input id="priority_date" name="priority_date" class="form-control"
                                                                    type="date" placeholder="Thompson"
                                                                    required="required">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Card Client -->
                                            <div class="card mt-4" id="sessions">
                                                <div class="card-header">
                                                    <h5>{{ __('messages.client_info') }}</h5>
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="form-label">{{ __('messages.client') }}</label>
                                                            <div class="input-group">
                                                            <select class="form-control js-example-basic-single" id="id_client" name="id_client">
                                                                <option value="">{{ __('messages.client') }}</option>
                                                                @foreach ($clients as $client)
                                                                    <option value="{{ $client->id }}">{{ $client->company_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <label class="form-label">{{ __('messages.contact') }}</label>
                                                            <div class="input-group">
                                                                <select class="form-control" name="id_contact" id="id_contact">
                                                                    <option value="">seleccione contacto</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <label class="form-label">{{ __('messages.address') }}</label>
                                                            <div class="input-group">
                                                                <select class="form-control" name="id_address" id="id_address">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Card Holder -->
                                            <div class="card mt-4 mb-5" id="holder">
                                                <div class="card-header">
                                                    <h5>{{ __('messages.holder_info') }}</h5>
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="form-label">{{ __('messages.holder') }}</label>
                                                            <div class="input-group">
                                                                <select class="form-control js-example-basic-single" id="id_holder" name="id_holder">
                                                                    <option value="">{{ __('messages.holder') }}</option>
                                                                    @foreach ($holders as $holder)
                                                                        <option value="{{ $holder->id }}">{{ $holder->company_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <label class="form-label">{{ __('messages.address') }}</label>
                                                            <select class="form-control" name="address_holder" id="address_holder">
                                                                <option value="">Seleccione Addres</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-6">
                                                            <label class="form-label">{{ __('messages.industrial_address') }}</label>
                                                            <div class="input-group">
                                                                <select class="form-control" name="industrial_address" id="industrial_address">
                                                                    <option value="">Seleccione Industrial/Commercial Address</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Menu --}}
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
                                                            <span
                                                                class="text-sm">{{ __('messages.reference_numbers') }}</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item pt-2">
                                                        <a class="nav-link text-body d-flex align-items-center" data-scroll=""
                                                            href="#basic-info">
                                                            <i class="ni ni-books me-2 text-dark opacity-6"></i>
                                                            <span
                                                                class="text-sm">{{ __('messages.general_information') }}</span>
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
                                                            <span
                                                                class="text-sm">{{ __('messages.trademark_information') }}</span>
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
                                                            <span
                                                                class="text-sm">{{ __('messages.priority_information') }}</span>
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
                            </main>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_custom')
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>
<script>
            $(document).ready(function () {
                $('#id_client').on('change', function () {
                    let id = $(this).val();
                    //id_client no esta en la tabla de automovil
                    $('#id_contact').empty();
                    $('#id_contact').append(`<option value="" disabled selected>Procesando..</option>`);
                    $.ajax({
                        type: 'GET',
                        url: 'crear/' + id,
                        success: function (response) {
                            var response = JSON.parse(response);
                            console.log(response);
                            //trae los automoviles relacionados con el id_client
                            $('#id_contact').empty();
                            $('#id_contact').append(`<option value="" disabled selected>Seleccione Cliente</option>`);
                            response.forEach(element => {
                                $('#id_contact').append(`<option value="${element['id']}">${element['name']}</option>`);
                            });
                        }
                    });
                });
            });

            $(document).ready(function () {
                $('#id_client').on('change', function () {
                    let id = $(this).val();
                    //id_client no esta en la tabla de automovil
                    $('#id_address').empty();
                    $('#id_address').append(`<option value="" disabled selected>Procesando..</option>`);
                    $.ajax({
                        type: 'GET',
                        url: 'address/' + id,
                        success: function (response) {
                            var response = JSON.parse(response);
                            console.log(response);
                            //trae los automoviles relacionados con el id_client
                            $('#id_address').empty();
                            // $('#id_address').append(`<option value="" disabled selected>Seleccione Address</option>`);
                            response.forEach(element => {
                                $('#id_address').append(`<option value="${element['id']}">${element['address']}</option>`);
                            });
                        }
                    });
                });
            });
</script>
<script>
    $(document).ready(function () {
        $('#id_holder').on('change', function () {
            let id = $(this).val();
            //id_holder no esta en la tabla de automovil
            $('#address_holder').empty();
            $('#address_holder').append(`<option value="" disabled selected>Procesando..</option>`);
            $.ajax({
                type: 'GET',
                url: 'holder/' + id,
                success: function (response) {
                    var response = JSON.parse(response);
                    console.log(response);
                    //trae los automoviles relacionados con el id_holder
                    $('#address_holder').empty();
                    $('#address_holder').append(`<option value="" disabled selected>Seleccione Adress</option>`);
                    response.forEach(element => {
                        $('#address_holder').append(`<option value="${element['id']}">${element['address']}</option>`);
                    });
                }
            });
        });
    });

    $(document).ready(function () {
        $('#id_holder').on('change', function () {
            let id = $(this).val();
            //id_holder no esta en la tabla de automovil
            $('#industrial_address').empty();
            $('#industrial_address').append(`<option value="" disabled selected>Procesando..</option>`);
            $.ajax({
                type: 'GET',
                url: 'holder/industrial/' + id,
                success: function (response) {
                    var response = JSON.parse(response);
                    console.log(response);
                    //trae los automoviles relacionados con el id_holder
                    $('#industrial_address').empty();
                    $('#industrial_address').append(`<option value="" disabled selected>Seleccione Industrial/Commercial Address</option>`);
                    response.forEach(element => {
                        $('#industrial_address').append(`<option value="${element['commercial_address']}">${element['commercial_address']}</option>`);
                    });
                }
            });
        });
    });
</script>
@endsection
