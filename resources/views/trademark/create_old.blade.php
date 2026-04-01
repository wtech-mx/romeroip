@extends('layouts.app')

@section('template_title')
    {{ __('messages.new_trademark') }}
@endsection

@section('css')
    <style>
        :root{
            --tm-primary: #FF7F11;
            --tm-secondary: #ACBFA4;
            --tm-soft: #E2E8CE;
            --tm-dark: #262626;

            --tm-primary-rgb: 255, 127, 17;
            --tm-secondary-rgb: 172, 191, 164;
            --tm-soft-rgb: 226, 232, 206;
            --tm-dark-rgb: 38, 38, 38;

            --tm-bg: #f7f7f2;
            --tm-white: #ffffff;
            --tm-border: #e7e4d8;
            --tm-text-muted: #6f6f6f;
        }

        .tm-folder-page{
            min-height: 100vh;
            background:
                linear-gradient(180deg, rgba(var(--tm-primary-rgb), .22) 0, rgba(var(--tm-primary-rgb), .22) 180px, var(--tm-bg) 180px, var(--tm-bg) 100%);
        }

        .tm-folder-header{
            background: linear-gradient(135deg, rgba(var(--tm-soft-rgb), .95) 0%, rgba(var(--tm-secondary-rgb), .28) 100%);
            border: 1px solid rgba(var(--tm-dark-rgb), .06);
            border-radius: 28px;
            padding: 28px 30px;
            box-shadow: 0 16px 45px rgba(var(--tm-dark-rgb), 0.08);
        }

        .tm-kicker{
            font-size: .78rem;
            font-weight: 800;
            letter-spacing: .12em;
            color: var(--tm-primary);
        }

        .tm-title{
            font-size: 2.1rem;
            font-weight: 800;
            color: var(--tm-dark);
        }

        .tm-subtitle{
            color: var(--tm-text-muted);
        }

        .tm-folder-shell{
            position: relative;
        }

        .tm-folder-tabs{
            border-bottom: none;
            gap: 10px;
            margin-bottom: -1px;
            padding-left: 14px;
            flex-wrap: wrap;
        }

        .tm-folder-tabs .nav-link{
            border: none;
            border-radius: 18px 18px 0 0;
            padding: 14px 24px;
            background: rgba(var(--tm-secondary-rgb), .45);
            color: var(--tm-dark);
            font-weight: 800;
            min-width: 170px;
            box-shadow: inset 0 -1px 0 rgba(255,255,255,.35);
            transition: .2s ease;
        }

        .tm-folder-tabs .nav-link:hover{
            background: rgba(var(--tm-secondary-rgb), .65);
            color: var(--tm-dark);
        }

        .tm-folder-tabs .nav-link.active{
            background: linear-gradient(135deg, var(--tm-white) 0%, rgba(var(--tm-soft-rgb), .45) 100%);
            color: var(--tm-primary);
            transform: translateY(1px);
        }

        .tm-folder-content{
            background: linear-gradient(180deg, var(--tm-white) 0%, #fcfcf8 100%);
            border-radius: 0 26px 26px 26px;
            padding: 26px;
            box-shadow: 0 20px 50px rgba(var(--tm-dark-rgb), 0.08);
            border: 1px solid rgba(var(--tm-dark-rgb), .08);
        }

        .tm-card{
            background: var(--tm-white);
            border-radius: 22px;
            border: 1px solid rgba(var(--tm-dark-rgb), .08);
            box-shadow: 0 10px 30px rgba(var(--tm-dark-rgb), 0.05);
            overflow: hidden;
        }

        .tm-card-header{
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px;
            background: linear-gradient(135deg, rgba(var(--tm-soft-rgb), .55) 0%, rgba(var(--tm-secondary-rgb), .18) 100%);
            border-bottom: 1px solid rgba(var(--tm-dark-rgb), .06);
        }

        .tm-card-header h5{
            margin: 0;
            font-weight: 800;
            color: var(--tm-dark);
        }

        .tm-card-header span{
            width: 38px;
            height: 38px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: var(--tm-white);
            background: linear-gradient(135deg, var(--tm-primary), #e66f07);
            box-shadow: 0 8px 18px rgba(var(--tm-primary-rgb), .25);
        }

        .tm-card-body{
            padding: 22px;
        }

        .tm-subcard{
            background: linear-gradient(180deg, var(--tm-white) 0%, rgba(var(--tm-soft-rgb), .32) 100%);
            border: 1px solid rgba(var(--tm-secondary-rgb), .35);
            border-radius: 18px;
            padding: 18px;
            height: 100%;
        }

        .tm-subcard h6{
            font-weight: 800;
            color: var(--tm-primary);
            margin-bottom: 0;
        }

        .tm-label{
            font-size: .88rem;
            font-weight: 700;
            color: var(--tm-dark);
            margin-bottom: 8px;
            display: inline-block;
        }

        .tm-input{
            min-height: 50px;
            border-radius: 14px;
            border: 1px solid var(--tm-border);
            background: var(--tm-white);
            color: var(--tm-dark);
        }

        .tm-input:focus{
            border-color: var(--tm-primary);
            box-shadow: 0 0 0 .2rem rgba(var(--tm-primary-rgb), .12);
        }

        textarea.tm-input{
            min-height: auto;
            padding-top: 12px;
            padding-bottom: 12px;
        }

        .tm-readonly{
            background: rgba(var(--tm-soft-rgb), .35);
            font-weight: 600;
        }

        .tm-preview-box{
            background: linear-gradient(180deg, var(--tm-white) 0%, rgba(var(--tm-soft-rgb), .28) 100%);
            border: 1px dashed rgba(var(--tm-secondary-rgb), .9);
            border-radius: 22px;
            padding: 18px;
            height: 100%;
        }

        .tm-preview-image-wrap{
            min-height: 340px;
            border-radius: 18px;
            background: rgba(var(--tm-soft-rgb), .28);
            border: 1px solid rgba(var(--tm-secondary-rgb), .45);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .tm-preview-image{
            width: 100%;
            max-width: 320px;
            max-height: 320px;
            object-fit: contain;
        }

        .tm-btn{
            min-height: 48px;
            padding: 0 22px;
            border-radius: 14px;
            font-weight: 800;
            border: none;
            transition: .2s ease;
        }

        .tm-btn-back{
            background: var(--tm-secondary);
            color: var(--tm-dark);
            box-shadow: 0 10px 18px rgba(var(--tm-dark-rgb), .10);
        }

        .tm-btn-back:hover{
            background: #9fb394;
            color: var(--tm-dark);
            transform: translateY(-1px);
        }

        .tm-btn-save{
            background: linear-gradient(135deg, var(--tm-primary) 0%, #e96f08 100%);
            color: var(--tm-white);
            box-shadow: 0 10px 18px rgba(var(--tm-primary-rgb), .22);
        }

        .tm-btn-save:hover{
            color: var(--tm-white);
            transform: translateY(-1px);
        }

        .select2-container .select2-selection--single{
            min-height: 50px !important;
            border-radius: 14px !important;
            border: 1px solid var(--tm-border) !important;
            padding-top: 10px !important;
            background: var(--tm-white) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 28px !important;
            padding-left: 14px !important;
            color: var(--tm-dark) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow{
            height: 48px !important;
        }

        .select2-container--default.select2-container--focus .select2-selection--single{
            border-color: var(--tm-primary) !important;
            box-shadow: 0 0 0 .2rem rgba(var(--tm-primary-rgb), .12) !important;
        }

        .select2-dropdown{
            border: 1px solid var(--tm-border) !important;
            border-radius: 14px !important;
            overflow: hidden;
        }

        .select2-results__option--highlighted{
            background: var(--tm-primary) !important;
        }

        @media (max-width: 768px){
            .tm-title{
                font-size: 1.7rem;
            }

            .tm-folder-content{
                padding: 18px;
                border-radius: 0 20px 20px 20px;
            }

            .tm-folder-tabs .nav-link{
                min-width: auto;
                width: 100%;
                border-radius: 14px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid py-4">
        <form method="POST" action="{{ route('store.trademarks') }}" enctype="multipart/form-data" role="form">
            @csrf

            {{-- Header --}}
            <div class="tm-folder-header mb-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <span class="tm-kicker">TRADEMARK FILE</span>
                        <h1 class="tm-title mb-1">{{ __('messages.new_trademark') }}</h1>
                    </div>

                    <div class="d-flex gap-2">
                        <a class="btn tm-btn tm-btn-back" href="javascript:history.back()">
                            {{ __('messages.back') }}
                        </a>
                        <button type="submit" class="btn tm-btn tm-btn-save">
                            {{ __('messages.save') }}
                        </button>
                    </div>
                </div>
            </div>

            @includeIf('partials.errors')

            {{-- Tabs tipo folder --}}
            <div class="tm-folder-shell">
                <ul class="nav tm-folder-tabs" id="trademarkTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-referencias-tab" data-bs-toggle="tab"
                            data-bs-target="#tab-referencias" type="button" role="tab">
                            References
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-general-tab" data-bs-toggle="tab"
                            data-bs-target="#tab-general" type="button" role="tab">
                            General Information
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-marca-tab" data-bs-toggle="tab"
                            data-bs-target="#tab-marca" type="button" role="tab">
                            Trademark
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-cliente-tab" data-bs-toggle="tab"
                            data-bs-target="#tab-cliente" type="button" role="tab">
                            Holder
                        </button>
                    </li>
                </ul>

                <div class="tab-content tm-folder-content" id="trademarkTabsContent">

                    {{-- TAB 1 --}}
                    <div class="tab-pane fade show active" id="tab-referencias" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="tm-card">
                                    <div class="tm-card-header">
                                        <h5>{{ __('messages.note_important') }}</h5>
                                        <span>01</span>
                                    </div>
                                    <div class="tm-card-body">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="tm-label">{{ __('messages.note') }}</label>
                                                <textarea class="form-control tm-input" id="notes_text" name="notes" rows="3">{{ old('notes') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="tm-card">
                                    <div class="tm-card-header">
                                        <h5>{{ __('messages.reference_numbers') }}</h5>
                                        <span>02</span>
                                    </div>
                                    <div class="tm-card-body">
                                        <div class="row g-3">
                                            @php
                                                if($trademark == null){
                                                    $suma = '1001';
                                                }else{
                                                    $suma = $trademark->our_ref + 1;
                                                }
                                            @endphp

                                            <div class="col-md-6">
                                                <label class="tm-label">{{ __('messages.our_ref') }}</label>
                                                <input id="our_ref" name="our_ref" class="form-control tm-input" type="text" value="{{ old('our_ref', $suma) }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="tm-label">{{ __('messages.client_ref') }}</label>
                                                <input id="client_ref" name="client_ref" class="form-control tm-input" type="text" value="{{ old('client_ref') }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="tm-label">{{ __('messages.opposition_no') }}</label>
                                                <input id="opposition_no" name="opposition_no" class="form-control tm-input" type="text" value="{{ old('opposition_no') }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="tm-label">{{ __('messages.filing_date') }}</label>
                                                <input id="filing_date_general" name="filing_date_general" class="form-control tm-input date-mask" type="text" placeholder="MM DD YYYY" maxlength="10" value="{{ old('filing_date_general') }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="tm-label">{{ __('messages.litigation_no') }}</label>
                                                <input id="litigation_no" name="litigation_no" class="form-control tm-input" type="text" value="{{ old('litigation_no') }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="tm-label">{{ __('messages.filing_date') }}</label>
                                                <input id="filing_date_litigation" name="filing_date_litigation" class="form-control tm-input date-mask" type="text" placeholder="MM DD YYYY" maxlength="10" value="{{ old('filing_date_litigation') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB 2 --}}
                    <div class="tab-pane fade" id="tab-general" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="tm-card">
                                    <div class="tm-card-header">
                                        <h5>{{ __('messages.general_information') }}</h5>
                                        <span>03</span>
                                    </div>
                                    <div class="tm-card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="tm-label">{{ __('messages.application_no') }}</label>
                                                <input id="application_no" name="application_no" class="form-control tm-input" type="text" value="{{ old('application_no') }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="tm-label">{{ __('messages.origin') }}</label>
                                                <select class="form-select tm-input select2" name="origin" id="origin">
                                                    <option value="">{{ __('messages.select') }}</option>
                                                    <option value="{{ __('messages.national') }}">{{ __('messages.national') }}</option>
                                                    <option value="{{ __('messages.international') }}">{{ __('messages.international') }}</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="tm-label">{{ __('messages.registration_no') }}</label>
                                                <input id="registration_no" name="registration_no" class="form-control tm-input" type="text" value="{{ old('registration_no') }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="tm-label">{{ __('messages.country') }}</label>
                                                <select class="form-select tm-input select2_country" name="country" id="country">
                                                    <option value="">{{ __('messages.select') }}</option>
                                                    @include('client.paises')
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="tm-label">{{ __('messages.filing_date') }}</label>
                                                <input id="filing_date_general" name="filing_date_general" class="form-control tm-input date-mask" type="text" placeholder="MM DD YYYY" maxlength="10" value="{{ old('filing_date_general') }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="tm-label">{{ __('messages.status') }}</label>
                                                <select class="form-select tm-input" id="status" name="status">
                                                    <option value="{{ __('messages.registered') }}">{{ __('messages.registered') }}</option>
                                                    <option value="{{ __('messages.pending') }}">{{ __('messages.pending') }}</option>
                                                    <option value="{{ __('messages.abandoned') }}">{{ __('messages.abandoned') }}</option>
                                                    <option value="{{ __('messages.lapsed') }}">{{ __('messages.lapsed') }}</option>
                                                    <option value="{{ __('messages.inactive') }}">{{ __('messages.inactive') }}</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="tm-label">{{ __('messages.first_date') }}</label>
                                                <input id="first_date" name="first_date" class="form-control tm-input date-mask" type="text" placeholder="MM DD YYYY" maxlength="10" value="{{ old('first_date') }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="tm-label">{{ __('messages.int_registration_no') }}</label>
                                                <input id="int_registration_no" name="int_registration_no" class="form-control tm-input" type="text" value="{{ old('int_registration_no') }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="tm-label">{{ __('messages.registration_date') }}</label>
                                                <input id="registrationDate" name="registration_date" class="form-control tm-input date-mask" type="text" placeholder="MM DD YYYY" maxlength="10" value="{{ old('registration_date') }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="tm-label">{{ __('messages.int_registration_date') }}</label>
                                                <input id="int_registration_date" name="int_registration_date" class="form-control tm-input date-mask" type="text" placeholder="MM DD YYYY" maxlength="10" value="{{ old('int_registration_date') }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="tm-label">{{ __('messages.expiration_date') }}</label>
                                                <input id="expirationDate" name="expiration_date" class="form-control tm-input tm-readonly" type="text" placeholder="MM DD YYYY" maxlength="10" readonly value="{{ old('expiration_date') }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="tm-label">{{ __('messages.contracting_organization') }}</label>
                                                <input id="contracting_organization" name="contracting_organization" class="form-control tm-input" type="text" value="{{ old('contracting_organization') }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="tm-label">{{ __('messages.publication_date') }}</label>
                                                <input id="publication_date" name="publication_date" class="form-control tm-input date-mask" type="text" placeholder="MM DD YYYY" maxlength="10" value="{{ old('publication_date') }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="tm-label">{{ __('messages.designated_countries') }}</label>
                                                <input id="designated_countries" name="designated_countries" class="form-control tm-input" type="text" value="{{ old('designated_countries') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="tm-card">
                                    <div class="tm-card-header">
                                        <h5>{{ __('messages.important_dates') }}</h5>
                                        <span>04</span>
                                    </div>
                                    <div class="tm-card-body">
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <div class="tm-subcard">
                                                    <h6>{{ __('messages.declarations_use') }}</h6>
                                                    <div class="row g-3 mt-1">
                                                        <div class="col-12">
                                                            <label class="tm-label">{{ __('messages.last') }}</label>
                                                            <input id="lastDeclarationDate" name="last_declaration" class="form-control tm-input" type="text" placeholder="MM DD YYYY" maxlength="10" value="{{ old('last_declaration') }}">
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="tm-label">{{ __('messages.next') }}</label>
                                                            <input id="declarationOfUseDate" name="next_declaration" class="form-control tm-input tm-readonly" type="text" placeholder="MM DD YYYY" maxlength="10" readonly value="{{ old('next_declaration') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="tm-subcard">
                                                    <h6>{{ __('messages.renewals') }}</h6>
                                                    <div class="row g-3 mt-1">
                                                        <div class="col-12">
                                                            <label class="tm-label">{{ __('messages.last') }}</label>
                                                            <input id="lastRenewalsDate" name="last_renewal" class="form-control tm-input" type="text" placeholder="MM DD YYYY" maxlength="10" value="{{ old('last_renewal') }}">
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="tm-label">{{ __('messages.next') }}</label>
                                                            <input id="renewalDate" name="next_renewal" class="form-control tm-input tm-readonly" type="text" placeholder="MM DD YYYY" maxlength="10" readonly value="{{ old('next_renewal') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB 3 --}}
                    <div class="tab-pane fade" id="tab-marca" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="tm-card">
                                    <div class="tm-card-header">
                                        <h5>{{ __('messages.trademark_information') }}</h5>
                                        <span>05</span>
                                    </div>
                                    <div class="tm-card-body">
                                        <div class="row g-4">
                                            <div class="col-lg-7">
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <label class="tm-label">{{ __('messages.trademark') }}</label>
                                                        <input id="trademark" name="trademark" class="form-control tm-input" type="text" value="{{ old('trademark') }}">
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="tm-label">{{ __('messages.description') }}</label>
                                                        <textarea class="form-control tm-input" id="description_trademark" name="description_trademark" rows="3">{{ old('description_trademark') }}</textarea>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="tm-label">{{ __('messages.type_application') }}</label>
                                                        <select class="form-select tm-input select2_type_application" id="type_application" name="type_application">
                                                            <option value="">{{ __('messages.select') }}</option>
                                                            <option value="Trademark">Trademark</option>
                                                            <option value="Trade Name">Trade Name</option>
                                                            <option value="Slogan">Slogan</option>
                                                            <option value="Collective Mark">Collective Mark</option>
                                                            <option value="Certification Mark">Certification Mark</option>
                                                            <option value="Nontraditional">Nontraditional</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="tm-label">{{ __('messages.type_mark') }}</label>
                                                        <select class="form-select tm-input select2_type_mark" id="type_mark" name="type_mark">
                                                            <option value="">{{ __('messages.select') }}</option>
                                                            <option value="Word Marks">Word Marks</option>
                                                            <option value="Design Marks">Design Marks</option>
                                                            <option value="Combined Marks">Combined Marks</option>
                                                            <option value="Tridimensional Marks">Tridimensional Marks</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="tm-label">{{ __('messages.translation') }}</label>
                                                        <textarea class="form-control tm-input" id="translation" name="translation" rows="2">{{ old('translation') }}</textarea>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="tm-label">{{ __('messages.transliteration') }}</label>
                                                        <textarea class="form-control tm-input" id="transliteration_trademark" name="transliteration_trademark" rows="2">{{ old('transliteration_trademark') }}</textarea>
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="tm-label">{{ __('messages.disclaimer') }}</label>
                                                        <textarea class="form-control tm-input" id="disclaimer" name="disclaimer" rows="2">{{ old('disclaimer') }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-5">
                                                <div class="tm-preview-box">
                                                    <label class="tm-label">{{ __('messages.design') }}</label>
                                                    <input id="design" name="design" class="form-control tm-input mb-3" type="file" accept="image/*">
                                                    <div class="tm-preview-image-wrap">
                                                        <img id="blah" src="{{ asset('design/no-image.jpg') }}" alt="Imagen" class="tm-preview-image">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="tm-card">
                                    <div class="tm-card-header">
                                        <h5>{{ __('messages.goods_services') }}</h5>
                                        <span>06</span>
                                    </div>
                                    <div class="tm-card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="tm-label">{{ __('messages.class') }}</label>
                                                <select class="form-select tm-input select2_class" id="class" name="class">
                                                    <option value="">{{ __('messages.select') }}</option>
                                                    @for ($i = 1; $i <= 45; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <div class="col-12">
                                                <label class="tm-label">{{ __('messages.description') }}</label>
                                                <textarea class="form-control tm-input" id="description_good" name="description_good" rows="3">{{ old('description_good') }}</textarea>
                                            </div>

                                            <div class="col-12">
                                                <label class="tm-label">{{ __('messages.translation') }}</label>
                                                <textarea class="form-control tm-input" id="translation_good" name="translation_good" rows="3">{{ old('translation_good') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="tm-card">
                                    <div class="tm-card-header">
                                        <h5>{{ __('messages.priority_information') }}</h5>
                                        <span>07</span>
                                    </div>
                                    <div class="tm-card-body">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="tm-label">{{ __('messages.priority_no') }}</label>
                                                <input id="priority_no" name="priority_no" class="form-control tm-input" type="text" value="{{ old('priority_no') }}">
                                            </div>

                                            <div class="col-md-4">
                                                <label class="tm-label">{{ __('messages.country_office') }}</label>
                                                <select class="form-select tm-input select2_country_office" name="country_office" id="country_office">
                                                    <option value="">{{ __('messages.select') }}</option>
                                                    @include('client.paises')
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="tm-label">{{ __('messages.priority_date') }}</label>
                                                <input id="priority_date" name="priority_date" class="form-control tm-input" type="text" placeholder="MM DD YYYY" maxlength="10" value="{{ old('priority_date') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB 4 --}}
                    <div class="tab-pane fade" id="tab-cliente" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="tm-card">
                                    <div class="tm-card-header">
                                        <h5>{{ __('messages.client_info') }}</h5>
                                        <span>08</span>
                                    </div>
                                    <div class="tm-card-body">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="tm-label">{{ __('messages.client') }}</label>
                                                <select class="form-select tm-input select2_id_client" id="id_client" name="id_client">
                                                    <option value="">{{ __('messages.client') }}</option>
                                                    @foreach ($clients as $client)
                                                        <option value="{{ $client->id }}">{{ $client->company_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="tm-label">{{ __('messages.contact') }}</label>
                                                <select class="form-select tm-input select2_id_contact" name="id_contact" id="id_contact">
                                                    <option value="">{{ __('messages.select') }}</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="tm-label">{{ __('messages.address') }}</label>
                                                <select class="form-select tm-input select2_id_address" name="id_address" id="id_address">
                                                    <option value="">{{ __('messages.select') }}</option>
                                                </select>
                                            </div>

                                            <div class="col-12">
                                                <label class="tm-label">{{ __('messages.billing_address') }}</label>
                                                <select class="form-select tm-input select2_billing_address_id" name="billing_address_id" id="billing_address_id">
                                                    <option value="">{{ __('messages.select') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="tm-card">
                                    <div class="tm-card-header">
                                        <h5>{{ __('messages.holder_info') }}</h5>
                                        <span>09</span>
                                    </div>
                                    <div class="tm-card-body">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="tm-label">{{ __('messages.holder') }}</label>
                                                <select class="form-select tm-input select2_id_holder" id="id_holder" name="id_holder">
                                                    <option value="">{{ __('messages.holder') }}</option>
                                                    @foreach ($holders as $holder)
                                                        <option value="{{ $holder->id }}">{{ $holder->company_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="tm-label">{{ __('messages.address') }}</label>
                                                <select class="form-select tm-input select2_address_holder" name="address_holder" id="address_holder">
                                                    <option value="">{{ __('messages.select') }}</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="tm-label">{{ __('messages.industrial_address') }}</label>
                                                <select class="form-select tm-input select2_industrial_address" name="industrial_address" id="industrial_address">
                                                    <option value="">{{ __('messages.select') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection

@section('js_custom')

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%',
                placeholder: "Select an option",
                allowClear: true
            });

            $('.select2_country').select2({
                width: '100%'
            });
            $('.select2_id_client').select2({
                width: '100%'
            });
            $('.select2_id_holder').select2({
                width: '100%'
            });
            $('.select2_address_holder').select2({
                width: '100%'
            });
            $('.select2_industrial_address').select2({
                width: '100%'
            });

            $('.select2_type_application').select2({
                width: '100%'
            });
            $('.select2_type_mark').select2({
                width: '100%'
            });
            $('.select2_class').select2({
                width: '100%'
            });
            $('.select2_country_office').select2({
                width: '100%'
            });
            $('.select2_id_contact').select2({
                width: '100%'
            });
            $('.select2_id_address').select2({
                width: '100%'
            });
            $('.select2_billing_address_id').select2({
                width: '100%'
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#id_client').on('change', function () {
                let id = $(this).val();

                $('#id_contact').empty().append(`<option value="">Procesando...</option>`);
                $('#id_address').empty().append(`<option value="">Procesando...</option>`);
                $('#billing_address_id').empty().append(`<option value="">Procesando...</option>`);

                $.ajax({
                    type: 'GET',
                    url: 'crear/' + id,
                    success: function (response) {
                        var data = JSON.parse(response);
                        $('#id_contact').empty().append(`<option value="">Seleccione Cliente</option>`);
                        data.forEach(element => {
                            $('#id_contact').append(`<option value="${element['id']}">${element['name']}</option>`);
                        });
                    }
                });

                $.ajax({
                    type: 'GET',
                    url: 'address/' + id,
                    success: function (response) {
                        var data = JSON.parse(response);
                        $('#id_address').empty().append(`<option value="">Seleccione Address</option>`);
                        $('#billing_address_id').empty().append(`<option value="">Seleccione Billing Address</option>`);

                        data.forEach(element => {
                            $('#id_address').append(`<option value="${element['id']}">${element['address']}</option>`);
                            $('#billing_address_id').append(`<option value="${element['id']}">${element['address']}</option>`);
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

                $('#address_holder').empty().append(`<option value="">Procesando...</option>`);
                $('#industrial_address').empty().append(`<option value="">Procesando...</option>`);

                $.ajax({
                    type: 'GET',
                    url: 'holder/' + id,
                    success: function (response) {
                        var data = JSON.parse(response);
                        $('#address_holder').empty().append(`<option value="">Seleccione Address</option>`);
                        data.forEach(element => {
                            $('#address_holder').append(`<option value="${element['id']}">${element['address']}</option>`);
                        });
                    }
                });

                $.ajax({
                    type: 'GET',
                    url: 'holder/industrial/' + id,
                    success: function (response) {
                        var data = JSON.parse(response);
                        $('#industrial_address').empty().append(`<option value="">Seleccione Industrial/Commercial Address</option>`);
                        data.forEach(element => {
                            $('#industrial_address').append(`<option value="${element['commercial_address']}">${element['commercial_address']}</option>`);
                        });
                    }
                });
            });
        });
    </script>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#design").change(function() {
            readURL(this);
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#registrationDate').on('change', function() {
                let value = $(this).val();
                if (!value) return;

                let registrationDate = new Date(value);
                if (isNaN(registrationDate.getTime())) return;

                let expirationDate = new Date(registrationDate);
                expirationDate.setFullYear(expirationDate.getFullYear() + 10);

                let declarationOfUseDate = new Date(registrationDate);
                declarationOfUseDate.setFullYear(declarationOfUseDate.getFullYear() + 3);

                $('#expirationDate').val(formatDate(expirationDate));
                $('#declarationOfUseDate').val(formatDate(declarationOfUseDate));
                $('#renewalDate').val(formatDate(expirationDate));
            });

            $('#lastDeclarationDate').on('change', function() {
                let renewalDate = $('#renewalDate').val();
                $('#declarationOfUseDate').val(renewalDate);
            });

            $('#lastRenewalsDate').on('change', function() {
                let expirationDate = $('#expirationDate').val();
                if (!expirationDate) return;

                let d = new Date(expirationDate);
                d.setFullYear(d.getFullYear() + 10);

                $('#expirationDate').val(formatDate(d));
                $('#declarationOfUseDate').val(formatDate(d));
                $('#renewalDate').val(formatDate(d));
            });

            function formatDate(date) {
                let year = date.getFullYear();
                let month = String(date.getMonth() + 1).padStart(2, '0');
                let day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }
        });
    </script>
@endsection
