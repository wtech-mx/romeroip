@extends('layouts.app')

@section('template_title')
    {{ __('messages.new_trademark') }}
@endsection

@section('css')
<style>
    /* ANCLA: TM_STICKY_FIX */
    :root{
        --tm-nav-offset: 90px;     /* navbar superior */
        --tm-gap: 12px;
        --tm-side-width-gap: 18px;
    }

    .tm-form-wrap,
    .tm-form-wrap > .container-fluid,
    .tm-form-wrap .row,
    .card,
    .card-body{
        overflow: visible !important;
    }

    .tm-layout-row{
        align-items: flex-start;
    }

    .tm-sticky-topbar{
        position: sticky;
        top: 0%;
        z-index: 1040;
        background: #fff;
        border: 1px solid rgba(0,0,0,.08);
        border-radius: 14px;
        padding: 1rem 1.25rem;
        margin-bottom: 1rem;
        box-shadow: 0 8px 20px rgba(0,0,0,.06);
    }

    .tm-sticky-topbar .tm-toolbar{
        display:flex;
        gap:.75rem;
        flex-wrap:wrap;
        align-items:center;
    }

    .tm-sticky-topbar .btn{
        margin-bottom:0;
        display:inline-flex;
        align-items:center;
        gap:.45rem;
        justify-content:center;
    }

    .tm-sticky-side{
        position: fixed;
        top: 30%;
        z-index: 1030;
    }

    .tm-menu{
        max-height: calc(100vh - (var(--tm-nav-offset) + 145px));
        overflow: auto;
        border-radius: 14px;
        box-shadow: 0 8px 20px rgba(0,0,0,.06);
    }

    .tm-menu .nav-link{
        border-radius: 10px;
        transition: all .2s ease;
    }

    .tm-menu .nav-link:hover{
        background: rgba(248,32,24,.08);
        color: #F82018 !important;
    }

    .tm-menu .nav-link i{
        width: 18px;
        text-align: center;
    }

    @media (max-width: 991.98px){
        .tm-sticky-topbar{
            top: 70px;
            padding: .85rem 1rem;
        }

        .tm-sticky-topbar .tm-top-actions{
            width: 100%;
        }

        .tm-sticky-topbar .tm-top-actions .btn{
            flex: 1 1 auto;
        }

        .tm-sticky-side{
            position: static;
            top: auto;
        }

        .tm-menu{
            max-height: none;
            overflow: visible;
        }
    }
</style>

<style>
    .main-content,
    .container-fluid,
    .row,
    .col,
    .card,
    .card-body{
        overflow: visible !important;
    }

    .autocomplete-box{
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        right: 0;
        z-index: 1055;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        box-shadow: 0 12px 30px rgba(0,0,0,.08);
        max-height: 260px;
        overflow-y: auto;
        padding: 6px;
    }

    .autocomplete-item{
        padding: 10px 12px;
        border-radius: 10px;
        cursor: pointer;
        transition: .15s ease;
    }

    .autocomplete-item:hover{
        background: rgba(255,127,17,.10);
    }

    .autocomplete-title{
        font-weight: 700;
        color: #262626;
        display: block;
    }

    .autocomplete-subtitle{
        font-size: .85rem;
        color: #6b7280;
        display: block;
    }

    .d-none{
        display: none !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid mt-3">
    <div class="row">
        <div class="col">
            <div class="card">

                <form method="POST"
                      action="{{ route('store.trademarks') }}"
                      enctype="multipart/form-data"
                      role="form"
                      id="trademarkForm">
                    @csrf

                    <div class="tm-sticky-topbar">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                            <div>
                                <h3 class="mb-1 d-flex align-items-center gap-2">
                                    <i class="bi bi-patch-check-fill text-danger"></i>
                                    {{ __('messages.new_trademark') }}
                                </h3>
                            </div>

                            <div class="tm-toolbar tm-top-actions">
                                <a class="btn"
                                href="javascript: history.go(-1)"
                                style="background: {{ $configuracion->color_boton_close }}; color: #ffff">
                                    <i class="bi bi-arrow-left-circle"></i>{{ __('messages.back') }}
                                </a>

                                <button type="submit" class="btn"
                                        style="border: 2px solid #F82018; color: #F82018; background:#fff;">
                                    <i class="bi bi-floppy"></i>{{ __('messages.save') }}
                                </button>
                            </div>
                        </div>

                        @includeif('partials.errors')
                    </div>

                    <div class="card-body">
                        <div class="tm-form-wrap">
                            <div class="container-fluid px-0">
                                <div class="row mb-5 tm-layout-row">

                                    <div class="col-lg-9 mt-lg-0 mt-4">

                                        {{-- ===================== NOTES ===================== --}}
                                        <div class="card" id="notes">
                                            <div class="tm-card-head">
                                                <h5 class="tm-section-title">
                                                    <span class="tm-section-icon">
                                                        <i class="bi bi-journal-text"></i>
                                                    </span>
                                                    {{ __('messages.note_important') }}
                                                </h5>
                                                <div class="tm-anchor-sub">Notas internas o contexto relevante del expediente.</div>
                                            </div>

                                            <div class="card-body pt-0">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="form-label">
                                                            <i class="bi bi-pencil-square me-1 text-secondary"></i>
                                                            {{ __('messages.note') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <textarea class="form-control" id="notes_text" name="notes" rows="1"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ===================== REFERENCES ===================== --}}
                                        <div class="card mt-4" id="profile">
                                            <div class="tm-card-head">
                                                <h5 class="tm-section-title">
                                                    <span class="tm-section-icon">
                                                        <i class="bi bi-hash"></i>
                                                    </span>
                                                    {{ __('messages.reference_numbers') }}
                                                </h5>
                                                <div class="tm-anchor-sub">Control interno, referencias del cliente y números de litigio/oposición.</div>
                                            </div>

                                            <div class="card-body pt-0">
                                                <div class="row">
                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-123 me-1 text-secondary"></i>
                                                            {{ __('messages.our_ref') }}
                                                        </label>
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
                                                        <label class="form-label">
                                                            <i class="bi bi-person-vcard me-1 text-secondary"></i>
                                                            {{ __('messages.client_ref') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <input id="client_ref" name="client_ref" class="form-control"
                                                                   type="text" placeholder="{{ __('messages.client_ref') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-shield-exclamation me-1 text-secondary"></i>
                                                            {{ __('messages.opposition_no') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <input id="opposition_no" name="opposition_no" class="form-control"
                                                                   type="text" placeholder="{{ __('messages.opposition_no') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-calendar-event me-1 text-secondary"></i>
                                                            {{ __('messages.filing_date') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <input id="filing_date_opposition" name="filing_date_opposition" class="form-control"
                                                                   type="date">
                                                        </div>
                                                    </div>

                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-bank me-1 text-secondary"></i>
                                                            {{ __('messages.litigation_no') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <input id="litigation_no" name="litigation_no" class="form-control"
                                                                   type="text" placeholder="{{ __('messages.litigation_no') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-calendar-event me-1 text-secondary"></i>
                                                            {{ __('messages.filing_date') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <input id="filing_date_litigation" name="filing_date_litigation" class="form-control"
                                                                   type="date">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ===================== GENERAL INFO ===================== --}}
                                        <div class="card mt-4" id="basic-info">
                                            <div class="tm-card-head">
                                                <h5 class="tm-section-title">
                                                    <span class="tm-section-icon">
                                                        <i class="bi bi-info-circle"></i>
                                                    </span>
                                                    {{ __('messages.general_information') }}
                                                </h5>
                                                <div class="tm-anchor-sub">Datos base del trámite, país, estatus y fechas principales.</div>
                                            </div>

                                            <div class="card-body pt-0">
                                                <div class="row">
                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-file-earmark-text me-1 text-secondary"></i>
                                                            {{ __('messages.application_no') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <input id="application_no" name="application_no" class="form-control"
                                                                   type="text" placeholder="{{ __('messages.application_no') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-globe-americas me-1 text-secondary"></i>
                                                            {{ __('messages.origin') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <select class="form-control" name="origin" id="origin">
                                                                <option value="" selected>{{ __('messages.select') }}</option>
                                                                <option value="{{ __('messages.national') }}">{{ __('messages.national') }}</option>
                                                                <option value="{{ __('messages.international') }}">{{ __('messages.international') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-award me-1 text-secondary"></i>
                                                            {{ __('messages.registration_no') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <input id="registration_no" name="registration_no" class="form-control"
                                                                   type="text" placeholder="{{ __('messages.registration_no') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-geo-alt me-1 text-secondary"></i>
                                                            {{ __('messages.country') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <select class="form-control js-example-basic-single" name="country" id="country">
                                                                <option value="" selected>{{ __('messages.select') }}</option>
                                                                @include('client.paises')
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-calendar-plus me-1 text-secondary"></i>
                                                            {{ __('messages.filing_date') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <input id="filing_date_general" name="filing_date_general" class="form-control"
                                                                   type="date">
                                                        </div>
                                                    </div>

                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-activity me-1 text-secondary"></i>
                                                            {{ __('messages.status') }}
                                                        </label>
                                                        <select class="form-control" id="status" name="status">
                                                            <option selected value="{{ __('messages.registered') }}">{{ __('messages.registered') }}</option>
                                                            <option value="{{ __('messages.pending') }}">{{ __('messages.pending') }}</option>
                                                            <option value="{{ __('messages.abandoned') }}">{{ __('messages.abandoned') }}</option>
                                                            <option value="{{ __('messages.lapsed') }}">{{ __('messages.lapsed') }}</option>
                                                            <option value="{{ __('messages.inactive') }}">{{ __('messages.inactive') }}</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-calendar-heart me-1 text-secondary"></i>
                                                            {{ __('messages.first_date') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <input id="first_date" name="first_date" class="form-control"
                                                                   type="date">
                                                        </div>
                                                    </div>

                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-diagram-3 me-1 text-secondary"></i>
                                                            {{ __('messages.int_registration_no') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <input id="int_registration_no" name="int_registration_no" class="form-control"
                                                                   type="text" placeholder="{{ __('messages.int_registration_no') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-calendar-check me-1 text-secondary"></i>
                                                            {{ __('messages.registration_date') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <input id="registrationDate" name="registration_date" class="form-control"
                                                                   type="date">
                                                        </div>
                                                    </div>

                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-calendar2-check me-1 text-secondary"></i>
                                                            {{ __('messages.int_registration_date') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <input id="int_registration_date" name="int_registration_date" class="form-control"
                                                                   type="date">
                                                        </div>
                                                    </div>

                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-calendar-x me-1 text-secondary"></i>
                                                            {{ __('messages.expiration_date') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <input id="expirationDate" name="expiration_date" class="form-control"
                                                                   type="date" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-buildings me-1 text-secondary"></i>
                                                            {{ __('messages.contracting_organization') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <input id="contracting_organization" name="contracting_organization" class="form-control"
                                                                   type="text" placeholder="{{ __('messages.contracting_organization') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-megaphone me-1 text-secondary"></i>
                                                            {{ __('messages.publication_date') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <input id="publication_date" name="publication_date" class="form-control"
                                                                   type="date">
                                                        </div>
                                                    </div>

                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-globe2 me-1 text-secondary"></i>
                                                            {{ __('messages.designated_countries') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <input id="designated_countries" name="designated_countries" class="form-control"
                                                                   type="text" placeholder="{{ __('messages.designated_countries') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ===================== IMPORTANT DATES ===================== --}}
                                        <div class="card mt-4" id="password">
                                            <div class="tm-card-head">
                                                <h5 class="tm-section-title">
                                                    <span class="tm-section-icon">
                                                        <i class="bi bi-calendar3"></i>
                                                    </span>
                                                    {{ __('messages.important_dates') }}
                                                </h5>
                                                <div class="tm-anchor-sub">Fechas de declaración de uso y renovaciones automáticas.</div>
                                            </div>

                                            <div class="card-body pt-0">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="form-label">
                                                            <i class="bi bi-calendar-range me-1 text-secondary"></i>
                                                            {{ __('messages.declarations_use') }}
                                                        </label>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">
                                                            <i class="bi bi-arrow-repeat me-1 text-secondary"></i>
                                                            {{ __('messages.renewals') }}
                                                        </label>
                                                    </div>

                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-calendar-minus me-1 text-secondary"></i>
                                                            {{ __('messages.last') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <input id="lastDeclarationDate" name="last_declaration" class="form-control"
                                                                   type="date">
                                                        </div>
                                                    </div>

                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-calendar-minus me-1 text-secondary"></i>
                                                            {{ __('messages.last') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <input id="lastRenewalsDate" name="last_renewal" class="form-control"
                                                                   type="date">
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">
                                                            <i class="bi bi-calendar-plus me-1 text-secondary"></i>
                                                            {{ __('messages.next') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <input id="declarationOfUseDate" name="next_declaration" class="form-control"
                                                                   type="date" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">
                                                            <i class="bi bi-calendar-plus me-1 text-secondary"></i>
                                                            {{ __('messages.next') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <input id="renewalDate" name="next_renewal" class="form-control"
                                                                   type="date" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ===================== TRADEMARK INFO ===================== --}}
                                        <div class="card mt-4" id="2fa">
                                            <div class="tm-card-head">
                                                <h5 class="tm-section-title">
                                                    <span class="tm-section-icon">
                                                        <i class="bi bi-patch-check"></i>
                                                    </span>
                                                    {{ __('messages.trademark_information') }}
                                                </h5>
                                                <div class="tm-anchor-sub">Nombre de la marca, descripción, tipo y diseño gráfico.</div>
                                            </div>

                                            <div class="card-body pt-0">
                                                <div class="row">

                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <label class="form-label" style="opacity: 0">sin_espacio</label>
                                                            </div>

                                                            <div class="col-12 p-2">
                                                                <label class="form-label">
                                                                    <i class="bi bi-bookmark-check me-1 text-secondary"></i>
                                                                    {{ __('messages.trademark') }}
                                                                </label>
                                                                <div class="input-group">
                                                                    <input id="trademark" name="trademark"
                                                                           class="form-control" type="text"
                                                                           placeholder="{{ __('messages.trademark') }}">
                                                                </div>
                                                            </div>

                                                            <div class="col-12 p-2">
                                                                <label class="form-label">
                                                                    <i class="bi bi-card-text me-1 text-secondary"></i>
                                                                    {{ __('messages.description') }}
                                                                </label>
                                                                <div class="input-group">
                                                                    <textarea class="form-control" id="description_trademark" name="description_trademark" rows="1"></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 p-2">
                                                                <label class="form-label">
                                                                    <i class="bi bi-diagram-2 me-1 text-secondary"></i>
                                                                    {{ __('messages.type_application') }}
                                                                </label>
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
                                                                <label class="form-label">
                                                                    <i class="bi bi-tags me-1 text-secondary"></i>
                                                                    {{ __('messages.type_mark') }}
                                                                </label>
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
                                                                <label class="form-label">
                                                                    <i class="bi bi-translate me-1 text-secondary"></i>
                                                                    {{ __('messages.translation') }}
                                                                </label>
                                                                <div class="input-group">
                                                                    <textarea class="form-control" id="translation" name="translation" rows="1"></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 p-2">
                                                                <label class="form-label">
                                                                    <i class="bi bi-fonts me-1 text-secondary"></i>
                                                                    {{ __('messages.transliteration') }}
                                                                </label>
                                                                <div class="input-group">
                                                                    <textarea class="form-control" id="transliteration_trademark" name="transliteration_trademark" rows="1"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <label class="form-label" style="opacity: 0">sin_espacio</label>
                                                            </div>

                                                            <div class="col-12 p-2">
                                                                <label class="form-label">
                                                                    <i class="bi bi-exclamation-diamond me-1 text-secondary"></i>
                                                                    {{ __('messages.disclaimer') }}
                                                                </label>
                                                                <div class="input-group">
                                                                    <textarea class="form-control" id="disclaimer" name="disclaimer" rows="1"></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 p-2">
                                                                <label class="form-label">
                                                                    <i class="bi bi-image me-1 text-secondary"></i>
                                                                    {{ __('messages.design') }}
                                                                </label>
                                                                <div class="input-group">
                                                                    <input id="design" name="design"
                                                                           class="form-control" type="file"
                                                                           accept=".jpg,.jpeg,.png,.webp,image/*">
                                                                </div>
                                                            </div>

                                                            <div class="col-12 mt-2">
                                                                <div class="input-group">
                                                                    <img id="blah"
                                                                         src="{{ asset('design/no-image.jpg') }}"
                                                                         alt="Imagen"
                                                                         style="width: 100%"
                                                                         class="tm-preview-img"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        {{-- ===================== GOODS / SERVICES ===================== --}}
                                        <div class="card mt-4" id="accounts">
                                            <div class="tm-card-head">
                                                <h5 class="tm-section-title">
                                                    <span class="tm-section-icon">
                                                        <i class="bi bi-box-seam"></i>
                                                    </span>
                                                    {{ __('messages.goods_services') }}
                                                </h5>
                                                <div class="tm-anchor-sub">Clase Niza y descripción de productos o servicios.</div>
                                            </div>

                                            <div class="card-body pt-0">
                                                <div class="row">
                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-collection me-1 text-secondary"></i>
                                                            {{ __('messages.class') }}
                                                        </label>
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
                                                        <label class="form-label">
                                                            <i class="bi bi-card-list me-1 text-secondary"></i>
                                                            {{ __('messages.description') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <textarea class="form-control" id="description_good" name="description_good" rows="2"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-translate me-1 text-secondary"></i>
                                                            {{ __('messages.translation') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <textarea class="form-control" id="translation_good" name="translation_good" rows="2"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ===================== PRIORITY ===================== --}}
                                        <div class="card mt-4" id="notifications">
                                            <div class="tm-card-head">
                                                <h5 class="tm-section-title">
                                                    <span class="tm-section-icon">
                                                        <i class="bi bi-flag"></i>
                                                    </span>
                                                    {{ __('messages.priority_information') }}
                                                </h5>
                                                <div class="tm-anchor-sub">Información de prioridad, oficina y país de origen.</div>
                                            </div>

                                            <div class="card-body pt-0">
                                                <div class="row">
                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-flag-fill me-1 text-secondary"></i>
                                                            {{ __('messages.priority_no') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <input id="priority_no" name="priority_no" class="form-control"
                                                                   type="text" placeholder="{{ __('messages.priority_no') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-globe-europe-africa me-1 text-secondary"></i>
                                                            {{ __('messages.country_office') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <select class="form-control" name="country_office" id="country_office">
                                                                <option value="" selected>{{ __('messages.select') }}</option>
                                                                @include('client.paises')
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-calendar-date me-1 text-secondary"></i>
                                                            {{ __('messages.priority_date') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <input id="priority_date" name="priority_date" class="form-control"
                                                                   type="date">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ===================== CLIENT ===================== --}}
                                        <div class="card mt-4" id="sessions">
                                            <div class="tm-card-head">
                                                <h5 class="tm-section-title">
                                                    <span class="tm-section-icon">
                                                        <i class="bi bi-building"></i>
                                                    </span>
                                                    {{ __('messages.client_info') }}
                                                </h5>
                                                <div class="tm-anchor-sub">Cliente, contacto, dirección principal y facturación.</div>
                                            </div>

                                            <div class="card-body pt-0">
                                                <div class="row">
                                                    <div class="col-12 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-buildings me-1 text-secondary"></i>
                                                            {{ __('messages.client') }}
                                                        </label>
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
                                                        <label class="form-label">
                                                            <i class="bi bi-person-lines-fill me-1 text-secondary"></i>
                                                            {{ __('messages.contact') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <select class="form-control" name="id_contact" id="id_contact">
                                                                <option value="">{{ __('messages.select') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-geo-alt-fill me-1 text-secondary"></i>
                                                            {{ __('messages.address') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <select class="form-control" name="id_address" id="id_address"></select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-receipt me-1 text-secondary"></i>
                                                            {{ __('messages.billing_address') }}
                                                        </label>
                                                        <div class="input-group">
                                                            <select class="form-control" id="billing_address_preview" disabled></select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ===================== HOLDER ===================== --}}
                                        <div class="card mt-4 mb-5" id="holder">
                                            <div class="tm-card-head">
                                                <h5 class="tm-section-title">
                                                    <span class="tm-section-icon">
                                                        <i class="bi bi-person-badge"></i>
                                                    </span>
                                                    {{ __('messages.holder_info') }}
                                                </h5>
                                                <div class="tm-anchor-sub">Titular de la marca y domicilios relacionados.</div>
                                            </div>

                                            <div class="card-body pt-0">
                                                <div class="row">
                                                    <div class="col-12 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-person-vcard-fill me-1 text-secondary"></i>
                                                            {{ __('messages.holder') }}
                                                        </label>
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
                                                        <label class="form-label">
                                                            <i class="bi bi-geo-alt me-1 text-secondary"></i>
                                                            {{ __('messages.address') }}
                                                        </label>
                                                        <select class="form-control" name="address_holder" id="address_holder">
                                                            <option value="">{{ __('messages.select') }}</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-6 p-2">
                                                        <label class="form-label">
                                                            <i class="bi bi-shop me-1 text-secondary"></i>
                                                            {{ __('messages.industrial_address') }}
                                                        </label>
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

                                    {{-- ===================== MENU ===================== --}}
                                    <div class="col-lg-3">
                                        <div class="tm-sticky-side">
                                            <div class="card tm-menu">
                                                <ul class="nav flex-column bg-white border-radius-lg p-2">

                                                <li class="nav-item pt-2">
                                                    <a class="nav-link text-body d-flex align-items-center" href="#notes">
                                                        <i class="bi bi-journal-text me-2 text-dark opacity-6"></i>
                                                        <span class="text-sm">{{ __('messages.note_important') }}</span>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link text-body d-flex align-items-center" href="#profile">
                                                        <i class="bi bi-hash me-2 text-dark opacity-6"></i>
                                                        <span class="text-sm">{{ __('messages.reference_numbers') }}</span>
                                                    </a>
                                                </li>

                                                <li class="nav-item pt-2">
                                                    <a class="nav-link text-body d-flex align-items-center" href="#basic-info">
                                                        <i class="bi bi-info-circle me-2 text-dark opacity-6"></i>
                                                        <span class="text-sm">{{ __('messages.general_information') }}</span>
                                                    </a>
                                                </li>

                                                <li class="nav-item pt-2">
                                                    <a class="nav-link text-body d-flex align-items-center" href="#password">
                                                        <i class="bi bi-calendar3 me-2 text-dark opacity-6"></i>
                                                        <span class="text-sm">{{ __('messages.important_dates') }}</span>
                                                    </a>
                                                </li>

                                                <li class="nav-item pt-2">
                                                    <a class="nav-link text-body d-flex align-items-center" href="#2fa">
                                                        <i class="bi bi-patch-check me-2 text-dark opacity-6"></i>
                                                        <span class="text-sm">{{ __('messages.trademark_information') }}</span>
                                                    </a>
                                                </li>

                                                <li class="nav-item pt-2">
                                                    <a class="nav-link text-body d-flex align-items-center" href="#accounts">
                                                        <i class="bi bi-box-seam me-2 text-dark opacity-6"></i>
                                                        <span class="text-sm">{{ __('messages.goods_services') }}</span>
                                                    </a>
                                                </li>

                                                <li class="nav-item pt-2">
                                                    <a class="nav-link text-body d-flex align-items-center" href="#notifications">
                                                        <i class="bi bi-flag me-2 text-dark opacity-6"></i>
                                                        <span class="text-sm">{{ __('messages.priority_information') }}</span>
                                                    </a>
                                                </li>

                                                <li class="nav-item pt-2">
                                                    <a class="nav-link text-body d-flex align-items-center" href="#sessions">
                                                        <i class="bi bi-building me-2 text-dark opacity-6"></i>
                                                        <span class="text-sm">{{ __('messages.client_info') }}</span>
                                                    </a>
                                                </li>

                                                <li class="nav-item pt-2">
                                                    <a class="nav-link text-body d-flex align-items-center" href="#holder">
                                                        <i class="bi bi-person-badge me-2 text-dark opacity-6"></i>
                                                        <span class="text-sm">{{ __('messages.holder_info') }}</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            </div>
                                        </div>
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
        $('#id_contact').empty().append(`<option value="" disabled selected>Procesando..</option>`);

        $.ajax({
            type: 'GET',
            url: 'crear/' + id,
            success: function (response) {
                response = JSON.parse(response);
                $('#id_contact').empty().append(`<option value="" disabled selected>Seleccione Cliente</option>`);
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
        $('#address_holder').empty().append(`<option value="" disabled selected>Procesando..</option>`);

        $.ajax({
            type: 'GET',
            url: 'holder/' + id,
            success: function (response) {
                response = JSON.parse(response);
                $('#address_holder').empty().append(`<option value="" disabled selected>Seleccione Address</option>`);
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
        $('#industrial_address').empty().append(`<option value="" disabled selected>Procesando..</option>`);

        $.ajax({
            type: 'GET',
            url: 'holder/industrial/' + id,
            success: function (response) {
                response = JSON.parse(response);
                $('#industrial_address').empty().append(`<option value="" disabled selected>Seleccione Industrial/Commercial Address</option>`);
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
            feedback.innerHTML = `<i class="bi bi-exclamation-circle me-1"></i>${message}`;
            wrapper.appendChild(feedback);
        } else {
            feedback.innerHTML = `<i class="bi bi-exclamation-circle me-1"></i>${message}`;
        }
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
            } else {
                alert('Please review the required fields: ' + errors.join(', '));
            }

            return;
        }
    });

    form.querySelectorAll('input, select, textarea').forEach(el => {
        el.addEventListener('input', () => clearInvalid(el));
        el.addEventListener('change', () => clearInvalid(el));
    });
})();
</script>
@endsection
