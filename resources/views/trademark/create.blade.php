@extends('layouts.app')

@section('template_title')
    {{ __('messages.new_trademark') }}
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <form method="POST" action="{{ route('store.trademarks') }}" enctype="multipart/form-data" role="form" id="trademarkForm" novalidate>
                        @csrf
                        <div style="padding-top: 1.5rem; padding-left: 1.5rem;">
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
                                                <div style="padding-top: 1.5rem; padding-left: 1.5rem;">
                                                    <h5>{{ __('messages.note_important') }}</h5>
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="form-label">{{ __('messages.note') }}</label>
                                                            <div class="input-group">
                                                                <textarea class="form-control" id="notes_text" name="notes" rows="1"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Card References number -->
                                            <div class="card mt-4" id="profile">
                                                <div style="padding-top: 1.5rem; padding-left: 1.5rem;">
                                                    <h5>{{ __('messages.reference_numbers') }}</h5>
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-6 p-2">
                                                            <label class="form-label">{{ __('messages.our_ref') }}</label>
                                                            <div class="input-group">
                                                                @php
                                                                    if($trademark == null){
                                                                        $suma= '1001';
                                                                    }else{
                                                                        $suma= $trademark->our_ref + 1;
                                                                    }
                                                                @endphp

                                                                <input id="our_ref" name="our_ref" class="form-control"
                                                                    type="number" min="1" step="1" value="{{ $suma }}" required>

                                                            </div>
                                                        </div>
                                                        <div class="col-6 p-2">
                                                            <label class="form-label">{{ __('messages.client_ref') }}</label>
                                                            <div class="input-group">
                                                                <input id="client_ref" name="client_ref" class="form-control"
                                                                    type="text" placeholder="{{ __('messages.client_ref') }}"
                                                                    >
                                                            </div>
                                                        </div>

                                                        <div class="col-6 p-2">
                                                            <label
                                                                class="form-label">{{ __('messages.opposition_no') }}</label>
                                                            <div class="input-group">
                                                                <input id="opposition_no" name="opposition_no" class="form-control"
                                                                    type="text"
                                                                    placeholder="{{ __('messages.opposition_no') }}"
                                                                    >
                                                            </div>
                                                        </div>
                                                        <div class="col-6 p-2">
                                                            <label class="form-label">{{ __('messages.filing_date') }}</label>
                                                            <div class="input-group">
                                                                <input id="filing_date_opposition" name="filing_date_opposition" class="form-control"
                                                                    type="date" placeholder="MM DD YYYY">
                                                            </div>
                                                        </div>

                                                        <div class="col-6 p-2">
                                                            <label
                                                                class="form-label">{{ __('messages.litigation_no') }}</label>
                                                            <div class="input-group">
                                                                <input id="litigation_no" name="litigation_no" class="form-control"
                                                                    type="text"
                                                                    placeholder="{{ __('messages.litigation_no') }}"
                                                                    >
                                                            </div>
                                                        </div>
                                                        <div class="col-6 p-2">
                                                            <label class="form-label">{{ __('messages.filing_date') }}</label>
                                                            <div class="input-group">
                                                                <input id="filing_date_litigation" name="filing_date_litigation" class="form-control"
                                                                    type="date" placeholder="MM DD YYYY">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Card General Information -->
                                            <div class="card mt-4" id="basic-info">
                                                <div style="padding-top: 1.5rem; padding-left: 1.5rem;">
                                                    <h5>{{ __('messages.general_information') }}</h5>
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-6 p-2">
                                                            <label
                                                                class="form-label">{{ __('messages.application_no') }}</label>
                                                            <div class="input-group">
                                                                <input id="application_no" name="application_no" class="form-control"
                                                                    type="text"
                                                                    placeholder="{{ __('messages.application_no') }}"
                                                                    >
                                                            </div>
                                                        </div>

                                                        <div class="col-6 p-2">
                                                            <label class="form-label">{{ __('messages.origin') }}</label>
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
                                                    <div class="row">
                                                        <div class="col-6 p-2">
                                                            <label
                                                                class="form-label">{{ __('messages.registration_no') }}</label>
                                                            <div class="input-group">
                                                                <input id="registration_no" name="registration_no" class="form-control"
                                                                    type="text"
                                                                    placeholder="{{ __('messages.registration_no') }}"
                                                                    >
                                                            </div>
                                                        </div>

                                                        <div class="col-6 p-2">
                                                            <label class="form-label">{{ __('messages.country') }}</label>
                                                            <div class="input-group">
                                                                <select class="form-control js-example-basic-single" name="country" id="country">
                                                                    <option value="" selected>{{ __('messages.select') }}</option>
                                                                    @include('client.paises')
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-6 p-2">
                                                            <label class="form-label">{{ __('messages.filing_date') }}</label>
                                                            <div class="input-group">
                                                                <input id="filing_date_general" name="filing_date_general" class="form-control"
                                                                    type="date" placeholder="MM DD YYYY">
                                                            </div>
                                                        </div>

                                                        <div class="col-6 p-2">
                                                            <label class="form-label">{{ __('messages.status') }}</label>
                                                            <select class="form-control" id="status" name="status">
                                                                <option selected value="{{ __('messages.registered') }}">
                                                                    {{ __('messages.registered') }}</option>
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

                                                        <div class="col-6 p-2">
                                                            <label class="form-label">{{ __('messages.first_date') }}</label>
                                                            <div class="input-group">
                                                                <input id="first_date" name="first_date" class="form-control"
                                                                    type="date" placeholder="MM DD YYYY">
                                                            </div>
                                                        </div>

                                                        <div class="col-6 p-2">
                                                            <label
                                                                class="form-label">{{ __('messages.int_registration_no') }}</label>
                                                            <div class="input-group">
                                                                <input id="int_registration_no" name="int_registration_no" class="form-control"
                                                                    type="text"
                                                                    placeholder="{{ __('messages.int_registration_no') }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-6 p-2">
                                                            <label
                                                                class="form-label">{{ __('messages.registration_date') }}</label>
                                                            <div class="input-group">
                                                                <input id="registrationDate" name="registration_date" class="form-control"
                                                                    type="date" placeholder="MM DD YYYY">
                                                            </div>
                                                        </div>

                                                        <div class="col-6 p-2">
                                                            <label
                                                                class="form-label">{{ __('messages.int_registration_date') }}</label>
                                                            <div class="input-group">
                                                                <input id="int_registration_date" name="int_registration_date" class="form-control"
                                                                    type="date" placeholder="MM DD YYYY">
                                                            </div>
                                                        </div>

                                                        <div class="col-6 p-2">
                                                            <label
                                                                class="form-label">{{ __('messages.expiration_date') }}</label>
                                                            <div class="input-group">
                                                                <input id="expirationDate" name="expiration_date" class="form-control" type="date" readonly>

                                                            </div>
                                                        </div>

                                                        <div class="col-6 p-2">
                                                            <label
                                                                class="form-label">{{ __('messages.contracting_organization') }}</label>
                                                            <div class="input-group">
                                                                <input id="contracting_organization" name="contracting_organization" class="form-control"
                                                                    type="text"
                                                                    placeholder="{{ __('messages.contracting_organization') }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-6 p-2">
                                                            <label
                                                                class="form-label">{{ __('messages.publication_date') }}</label>
                                                            <div class="input-group">
                                                                <input id="publication_date" name="publication_date" class="form-control"
                                                                    type="date" placeholder="MM DD YYYY">
                                                            </div>
                                                        </div>

                                                        <div class="col-6 p-2">
                                                            <label
                                                                class="form-label">{{ __('messages.designated_countries') }}</label>
                                                            <div class="input-group">
                                                                <input id="designated_countries" name="designated_countries" class="form-control"
                                                                    type="text"
                                                                    placeholder="{{ __('messages.designated_countries') }}">
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                            <!-- Card Dates -->
                                            <div class="card mt-4" id="password">
                                                <div style="padding-top: 1.5rem; padding-left: 1.5rem;">
                                                    <h5>{{ __('messages.important_dates') }}</h5>
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-6 ">
                                                            <label class="form-label">{{ __('messages.declarations_use') }}</label>
                                                        </div>

                                                        <div class="col-6 ">
                                                            <label class="form-label">{{ __('messages.renewals') }}</label>
                                                        </div>
                                                        <?php
                                                         $fcha = date("Y-m-d");
                                                         $fecha = date("Y-m-d",strtotime($fcha."+ 1 week"));
                                                        ?>
                                                        <div class="col-6 p-2">
                                                            <label class="form-label">{{ __('messages.last') }}</label>
                                                            <div class="input-group">
                                                                <input id="lastDeclarationDate" name="last_declaration" class="form-control"
                                                                    type="date" placeholder="MM DD YYYY">
                                                            </div>
                                                        </div>

                                                        <div class="col-6 p-2">
                                                            <label class="form-label">{{ __('messages.last') }}</label>
                                                            <div class="input-group">
                                                                <input id="lastRenewalsDate" name="last_renewal" class="form-control"
                                                                    type="date" placeholder="MM DD YYYY">
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <label class="form-label">{{ __('messages.next') }}</label>
                                                            <div class="input-group">
                                                                <input id="declarationOfUseDate" name="next_declaration" class="form-control" type="date" readonly>

                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <label class="form-label">{{ __('messages.next') }}</label>
                                                            <div class="input-group">
                                                                <input id="renewalDate" name="next_renewal" class="form-control" type="date" readonly>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Card Trademark -->
                                            <div class="card mt-4" id="2fa">
                                                <div style="padding-top: 1.5rem; padding-left: 1.5rem;">
                                                    <h5>{{ __('messages.trademark_information') }}</h5>
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="row">

                                                        <div class="col-6">
                                                            <div class="row">
                                                                <div class="col-12 ">
                                                                    <label class="form-label" style="opacity: 0">sin_espacio</label>
                                                                </div>
                                                                <div class="col-12 p-2">
                                                                    <label
                                                                        class="form-label">{{ __('messages.trademark') }}</label>
                                                                    <div class="input-group">
                                                                        <input id="trademark" name="trademark"
                                                                            class="form-control" type="text"
                                                                            placeholder="{{ __('messages.trademark') }}"
                                                                            >
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 p-2">
                                                                    <label
                                                                        class="form-label">{{ __('messages.description') }}</label>
                                                                    <div class="input-group">
                                                                        <textarea class="form-control" id="description_trademark" name="description_trademark" rows="1"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 p-2">
                                                                    <label
                                                                        class="form-label">{{ __('messages.type_application') }}</label>
                                                                    <div class="input-group">
                                                                        <select class="form-control" id="type_application" name="type_application">
                                                                            <option value="" selected>{{ __('messages.select') }}</option>
                                                                            <option value="Trademark">{{ __('messages.trademark') }}</option>
                                                                            <option value="Trade Name">{{ __('messages.trademark_name') }}</option>
                                                                            <option value="Slogan">{{ __('messages.slogan') }}</option>
                                                                            <option value="Collective Mark">{{ __('messages.collective_mark') }}</option>
                                                                            <option value="Certification Mark">{{ __('messages.certification_mark') }}</option>
                                                                            <option value="Nontraditional">{{ __('messages.nontraditional') }}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 p-2">
                                                                    <label
                                                                        class="form-label">{{ __('messages.type_mark') }}</label>
                                                                    <div class="input-group">
                                                                        <select class="form-control" id="type_mark" name="type_mark">
                                                                            <option value="" selected>{{ __('messages.select') }}</option>
                                                                            <option value="Word Marks">{{ __('messages.word_marks') }}</option>
                                                                            <option value="Design Marks">{{ __('messages.design_marks') }}</option>
                                                                            <option value="Combined Marks">{{ __('messages.combined_marks') }}</option>
                                                                            <option value="Tridimensional Marks">{{ __('messages.tridimensional_marks') }}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 p-2">
                                                                    <label
                                                                        class="form-label">{{ __('messages.translation') }}</label>
                                                                    <div class="input-group">
                                                                        <textarea class="form-control" id="translation" name="translation" rows="1"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 p-2">
                                                                    <label
                                                                        class="form-label">{{ __('messages.transliteration') }}</label>
                                                                    <div class="input-group">
                                                                        <textarea class="form-control" id="transliteration_trademark" name="transliteration_trademark" rows="1"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-6 ">
                                                            <div class="row">
                                                                <div class="col-12 ">
                                                                    <label class="form-label" style="opacity: 0">sin_espacio</label>
                                                                </div>
                                                                <div class="col-12 p-2">
                                                                    <label
                                                                        class="form-label">{{ __('messages.disclaimer') }}</label>
                                                                    <div class="input-group">
                                                                        <textarea class="form-control" id="disclaimer" name="disclaimer" rows="1"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 p-2">
                                                                    <label
                                                                        class="form-label">{{ __('messages.design') }}</label>
                                                                    <div class="input-group">

                                                                        <input id="design" name="design"
                                                                            class="form-control" type="file"
                                                                            accept=".jpg,.jpeg,.png,.webp,image/*">
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 mt-2" style="">
                                                                    <div class="input-group">
                                                                         <img id="blah" src="{{asset('design/no-image.jpg') }}" alt="Imagen" style="width: 300px; height: 300px;"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Card Good Service -->
                                            <div class="card mt-4" id="accounts">
                                                <div style="padding-top: 1.5rem; padding-left: 1.5rem;">
                                                    <h5>{{ __('messages.goods_services') }}</h5>
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-6 p-2">
                                                            <label class="form-label">{{ __('messages.class') }}</label>
                                                            <div class="input-group">
                                                                <select class="form-control" id="class" name="class">
                                                                    <option value="" selected>{{ __('messages.select') }}</option>
                                                                    @for ($i = 1; $i <= 45; $i++)
                                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                                    @endfor

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 p-2">
                                                            <label class="form-label">{{ __('messages.description') }}</label>
                                                            <div class="input-group">
                                                                <textarea class="form-control" id="description_good" name="description_good" rows="2"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 p-2">
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
                                                <div style="padding-top: 1.5rem; padding-left: 1.5rem;">
                                                    <h5>{{ __('messages.priority_information') }}</h5>
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-6 p-2">
                                                            <label class="form-label">{{ __('messages.priority_no') }}</label>
                                                            <div class="input-group">
                                                                <input id="priority_no" name="priority_no" class="form-control"
                                                                    type="text"
                                                                    placeholder="{{ __('messages.priority_no') }}"
                                                                    >
                                                            </div>
                                                        </div>

                                                        <div class="col-6 p-2">
                                                            <label class="form-label">{{ __('messages.country_office') }}</label>
                                                            <div class="input-group">
                                                                <select class="form-control" name="country_office" id="country_office">
                                                                    <option value="" selected>{{ __('messages.select') }}</option>
                                                                    @include('client.paises')
                                                                </select>
                                                            </div>

                                                        </div>

                                                        <div class="col-6 p-2">
                                                            <label
                                                                class="form-label">{{ __('messages.priority_date') }}</label>
                                                            <div class="input-group">
                                                                <input id="priority_date" name="priority_date" class="form-control"
                                                                    type="date">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Card Client -->
                                            <div class="card mt-4" id="sessions">
                                                <div style="padding-top: 1.5rem; padding-left: 1.5rem;">
                                                    <h5>{{ __('messages.client_info') }}</h5>
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-12 p-2">
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

                                                        <div class="col-12 p-2">
                                                            <label class="form-label">{{ __('messages.contact') }}</label>
                                                            <div class="input-group">
                                                                <select class="form-control" name="id_contact" id="id_contact">
                                                                    <option value="">{{ __('messages.select') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 p-2">
                                                            <label class="form-label">{{ __('messages.address') }}</label>
                                                            <div class="input-group">
                                                                <select class="form-control" name="id_address" id="id_address">
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 p-2">
                                                            <label class="form-label">{{ __('messages.billing_address') }}</label>
                                                            <div class="input-group">
                                                                <select class="form-control" id="billing_address_preview" disabled>

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Card Holder -->
                                            <div class="card mt-4" id="holder">
                                                <div style="padding-top: 1.5rem; padding-left: 1.5rem;">
                                                    <h5>{{ __('messages.holder_info') }}</h5>
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-12 p-2">
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

                                                        <div class="col-6 p-2">
                                                            <label class="form-label">{{ __('messages.address') }}</label>
                                                            <select class="form-control" name="address_holder" id="address_holder">
                                                                <option value="">{{ __('messages.select') }}</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-6 p-2">
                                                            <label class="form-label">{{ __('messages.industrial_address') }}</label>
                                                            <div class="input-group">
                                                                <select class="form-control" name="industrial_address" id="industrial_address">
                                                                    <option value="">Seleccione Industrial / Commercial Address</option>
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
                                                <ul class="nav flex-column bg-white border-radius-lg p-2">
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
                        url: '{{ url("/trademarks/crear") }}/' + id,
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

                    $('#id_address').empty().append(`<option value="" selected>Procesando..</option>`);
                    $('#billing_address_preview').empty().append(`<option value="" selected>Procesando..</option>`);

                    $.ajax({
                        type: 'GET',
                        url: '{{ url("/trademarks/address") }}/' + id,
                        success: function (response) {
                            response = JSON.parse(response);

                            $('#id_address').empty().append(`<option value="" selected>{{ __('messages.select') }}</option>`);
                            $('#billing_address_preview').empty().append(`<option value="" selected>{{ __('messages.select') }}</option>`);

                            response.forEach(element => {
                                $('#id_address').append(`<option value="${element['id']}">${element['address'] ?? ''}</option>`);
                                $('#billing_address_preview').append(`<option value="${element['id']}">${element['billing_address'] ?? ''}</option>`);
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
                url: '{{ url("/trademarks/holder") }}/' + id,
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
                url: '{{ url("/trademarks/holder/industrial") }}/' + id,
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

<script>
(function () {
    function readURL(input) {
        if (!input.files || !input.files[0]) return;

        const file = input.files[0];
        if (!file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    }

    $("#design").on('change', function () {
        readURL(this);
    });
})();
</script>

<script>
(function () {
    function formatDateLocal(date) {
        const y = date.getFullYear();
        const m = String(date.getMonth() + 1).padStart(2, '0');
        const d = String(date.getDate()).padStart(2, '0');
        return `${y}-${m}-${d}`;
    }

    function addYears(isoDate, years) {
        if (!isoDate) return '';
        const date = new Date(isoDate + 'T00:00:00');
        date.setFullYear(date.getFullYear() + years);
        return formatDateLocal(date);
    }

    const registrationDate = document.getElementById('registrationDate');
    const expirationDate = document.getElementById('expirationDate');
    const declarationOfUseDate = document.getElementById('declarationOfUseDate');
    const renewalDate = document.getElementById('renewalDate');
    const lastDeclarationDate = document.getElementById('lastDeclarationDate');
    const lastRenewalsDate = document.getElementById('lastRenewalsDate');

    registrationDate?.addEventListener('change', function () {
        if (!this.value) return;

        const expiration = addYears(this.value, 10);
        const declaration = addYears(this.value, 3);

        expirationDate.value = expiration;
        declarationOfUseDate.value = declaration;
        renewalDate.value = expiration;
    });

    lastDeclarationDate?.addEventListener('change', function () {
        if (!this.value) return;
        declarationOfUseDate.value = renewalDate.value || addYears(this.value, 3);
    });

    lastRenewalsDate?.addEventListener('change', function () {
        if (!this.value) return;

        expirationDate.value = addYears(this.value, 10);
        declarationOfUseDate.value = addYears(this.value, 10);
        renewalDate.value = addYears(this.value, 10);
    });
})();
</script>

<script>
    (function () {
        const form = document.getElementById('trademarkForm');
        if (!form) return;

        const requiredFields = [
            { id: 'our_ref', label: 'Our Ref.' },
            { id: 'trademark', label: 'Trademark' },
            { id: 'status', label: 'Status' },
            { id: 'id_client', label: 'Client' },
            { id: 'id_holder', label: 'Holder' },
        ];

        function clearInvalid(el) {
            if (!el) return;
            el.classList.remove('is-invalid');

            const wrapper = el.closest('.input-group') || el.parentElement;
            const feedback = wrapper?.querySelector('.invalid-feedback.dynamic-feedback');
            if (feedback) feedback.remove();
        }

        function markInvalid(el, message) {
            if (!el) return;
            el.classList.add('is-invalid');

            const wrapper = el.closest('.input-group') || el.parentElement;
            if (!wrapper) return;

            let feedback = wrapper.querySelector('.invalid-feedback.dynamic-feedback');
            if (!feedback) {
                feedback = document.createElement('div');
                feedback.className = 'invalid-feedback dynamic-feedback d-block';
                wrapper.appendChild(feedback);
            }

            feedback.innerHTML = `<i class="bi bi-exclamation-circle me-1"></i>${message}`;
        }

        function isEmpty(el) {
            if (!el) return true;
            return String(el.value || '').trim() === '';
        }

        form.addEventListener('submit', function (e) {
            let errors = [];

            requiredFields.forEach(field => {
                const el = document.getElementById(field.id);
                clearInvalid(el);

                if (isEmpty(el)) {
                    markInvalid(el, `${field.label} is required.`);
                    errors.push(field.label);
                }
            });

            const regDate = document.getElementById('registrationDate');
            const expDate = document.getElementById('expirationDate');

            clearInvalid(regDate);
            clearInvalid(expDate);

            if (regDate && expDate && regDate.value && expDate.value && expDate.value < regDate.value) {
                markInvalid(expDate, 'Expiration Date cannot be earlier than Registration Date.');
                errors.push('Expiration Date');
            }

            if (errors.length) {
                e.preventDefault();

                if (window.Swal) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Please review the form',
                        html: `
                            <div class="text-start">
                                ${errors.map(item => `<div><i class="bi bi-exclamation-triangle text-danger me-2"></i>${item}</div>`).join('')}
                            </div>
                        `
                    });
                }
            }
        });

        form.querySelectorAll('input, select, textarea').forEach(el => {
            el.addEventListener('input', () => clearInvalid(el));
            el.addEventListener('change', () => clearInvalid(el));
        });
    })();
</script>

@endsection
