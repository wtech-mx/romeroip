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

<style>
    :root{
        --tm-primary: #8A6F3E;
        --tm-dark: #1F2328;
        --tm-border: #D8D2C6;
        --tm-border-soft: #EEE9DF;
        --tm-bg: #F8F6F1;
        --tm-muted: #76716A;
    }

    body{
        background: var(--tm-bg);
    }

    .tm-page{
        max-width: 1260px;
        margin-left: 0;
        margin-right: auto;
        padding-bottom: 4rem;
    }

    .tm-file-shell{
        background: transparent !important;
        border: 0 !important;
        border-radius: 0 !important;
        box-shadow: none !important;
    }

    .tm-sticky-topbar{
        position: static;
        top: auto;
        z-index: auto;
        margin-bottom: 1rem;
        padding: 2rem 2.15rem 1.5rem;
        background: #FBFAF6;
        border: 1px solid var(--tm-border);
        border-radius: 0;
        box-shadow: none;
    }

    .tm-sticky-topbar h3{
        margin: 0;
        color: var(--tm-dark);
        font-size: clamp(1.85rem, 3vw, 3rem);
        line-height: 1.05;
        font-weight: 700;
        letter-spacing: 0;
    }

    .tm-sticky-topbar h3:before{
        content: "Legal trademark file";
        display: block;
        margin-bottom: .45rem;
        color: var(--tm-muted);
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .tm-sticky-topbar h3:after{
        content: "{{ __('messages.new_trademark') }}";
        display: block;
        margin-top: .55rem;
        color: var(--tm-muted);
        font-size: .98rem;
        font-weight: 400;
    }

    .tm-sticky-topbar i,
    .tm-section-title i,
    .form-label i,
    .tm-menu i{
        display: none !important;
    }

    .tm-toolbar{
        justify-content: flex-end;
    }

    .tm-toolbar .btn{
        min-height: 40px;
        padding: 0 .95rem;
        border-radius: 3px !important;
        font-weight: 700;
        border: 1px solid var(--tm-dark) !important;
        background: transparent !important;
        color: var(--tm-dark) !important;
        box-shadow: none !important;
    }

    .tm-toolbar button[type="submit"]{
        background: var(--tm-dark) !important;
        color: #fff !important;
    }

    .tm-file-body{
        background: #FBFAF6;
        border: 1px solid var(--tm-border);
        padding: 0 2.15rem 1rem;
    }

    .tm-file-content{
        display: grid;
        grid-template-columns: minmax(0, 1fr) 260px;
        gap: 2.5rem;
        align-items: start;
    }

    .tm-layout-row{
        display: grid !important;
        grid-template-columns: minmax(0, 1fr) 260px;
        gap: 2.5rem;
        margin: 0 !important;
        align-items: start;
    }

    .tm-layout-row > .col-lg-9,
    .tm-layout-row > .col-lg-3{
        width: auto;
        max-width: none;
        padding: 0 !important;
    }

    .tm-card-head{
        padding: 0 0 1.15rem;
    }

    .tm-section-title{
        margin: 0;
        color: var(--tm-dark);
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .tm-section-icon{
        display: none !important;
    }

    .tm-anchor-sub{
        margin-top: .35rem;
        color: var(--tm-muted);
        font-size: .89rem;
    }

    .tm-section-card{
        display: none;
        margin: 0 0 3.15rem !important;
        padding-top: 1.45rem;
        background: transparent !important;
        border: 0 !important;
        border-top: 1px solid var(--tm-border) !important;
        border-radius: 0 !important;
        box-shadow: none !important;
    }

    .tm-section-card.is-active{
        display: block;
    }

    .tm-section-card .card-body{
        padding: 0 !important;
    }

    .tm-section-card .row{
        margin-left: -.75rem;
        margin-right: -.75rem;
    }

    .tm-section-card [class*="col-"]{
        padding: .75rem !important;
    }

    .form-label{
        margin-bottom: .28rem;
        color: var(--tm-muted);
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .input-group{
        display: flex;
        width: 100%;
    }

    .input-group > .form-control,
    .input-group > select.form-control,
    .input-group > textarea.form-control{
        flex: 1 1 100%;
        width: 100%;
        min-width: 0;
    }

    .form-control,
    .select2-container--default .select2-selection--single{
        width: 100%;
        min-height: 52px;
        border: 0 !important;
        border-bottom: 1px solid var(--tm-border-soft) !important;
        border-radius: 0 !important;
        background: transparent !important;
        color: var(--tm-dark);
        font-weight: 600;
        padding: .72rem .2rem .7rem 0;
        box-shadow: none !important;
        cursor: text;
    }

    select.form-control,
    .select2-container--default .select2-selection--single{
        cursor: pointer;
    }

    .select2-container{
        width: 100% !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered{
        padding-left: 0;
        padding-right: 1.5rem;
        color: var(--tm-dark);
        line-height: 34px;
        font-weight: 600;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow{
        height: 50px;
    }

    textarea.form-control{
        min-height: 78px;
        padding-top: .72rem;
        padding-bottom: .7rem;
        line-height: 1.6;
    }

    .form-control[type="file"]{
        padding-top: .45rem;
    }

    .form-control[type="file"]::file-selector-button{
        border: 1px solid var(--tm-dark);
        background: transparent;
        color: var(--tm-dark);
        border-radius: 0;
        padding: .45rem .75rem;
        margin-right: .75rem;
        font-weight: 700;
    }

    .tm-preview-img{
        max-height: 340px;
        object-fit: contain;
        border: 1px solid var(--tm-border);
        background: rgba(255,255,255,.42);
        padding: 1rem;
    }

    .tm-sticky-side{
        position: sticky;
        top: 1.25rem;
    }

    .tm-menu{
        max-height: none;
        overflow: visible;
        border-radius: 0;
        box-shadow: none;
        background: transparent !important;
        border: 0 !important;
    }

    .tm-tabs-label{
        margin: 0 0 .85rem;
        color: var(--tm-muted);
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .tm-menu .nav{
        padding: 0 0 0 1.25rem !important;
        background: transparent !important;
        border-left: 1px solid var(--tm-border);
        border-radius: 0 !important;
    }

    .tm-menu .nav-link,
    .tm-menu button{
        display: block;
        width: 100%;
        padding: .78rem 0 .78rem .95rem !important;
        border: 0;
        border-left: 2px solid transparent;
        background: transparent;
        color: var(--tm-muted) !important;
        font-size: .9rem;
        font-weight: 700;
        line-height: 1.25;
        text-align: left;
        text-decoration: none;
        transform: translateX(-1px);
        transition: border-color .15s ease, color .15s ease, background-color .15s ease;
    }

    .tm-menu button:hover,
    .tm-menu button.is-active{
        border-left-color: var(--tm-primary);
        background: rgba(138,111,62,.06);
        color: var(--tm-dark) !important;
    }

    @media (max-width: 991.98px){
        .tm-sticky-topbar,
        .tm-file-body{
            padding-left: 1.25rem;
            padding-right: 1.25rem;
        }

        .tm-file-content{
            display: flex;
            flex-direction: column-reverse;
            gap: 0;
        }

        .tm-layout-row{
            display: flex !important;
            flex-direction: column-reverse;
            gap: 0;
        }

        .tm-sticky-side{
            position: static;
        }

        .tm-menu{
            margin: 0 -1.25rem 2.25rem;
            border-top: 1px solid var(--tm-border) !important;
            border-bottom: 1px solid var(--tm-border) !important;
            background: #F7F4ED !important;
            overflow-x: auto;
        }

        .tm-tabs-label{
            display: none;
        }

        .tm-menu .nav{
            display: flex;
            flex-direction: row !important;
            flex-wrap: nowrap;
            min-width: max-content;
            padding: 0 1.25rem !important;
            border-left: 0;
        }

        .tm-menu .nav-item{
            padding-top: 0 !important;
        }

        .tm-menu button{
            display: inline-flex;
            align-items: center;
            width: auto;
            min-height: 48px;
            padding: 0 .95rem !important;
            border-left: 0;
            border-right: 1px solid var(--tm-border-soft);
            white-space: nowrap;
            transform: none;
            font-size: .78rem;
            letter-spacing: .05em;
            text-transform: uppercase;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid mt-3 tm-page">
    <div class="row">
        <div class="col">
            <div class="card tm-file-shell">

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

                    <div class="card-body tm-file-body">
                        <div class="tm-form-wrap">
                            <div class="container-fluid px-0">
                                <div class="row mb-5 tm-layout-row">

                                    <div class="col-lg-9 mt-lg-0 mt-4">

                                        {{-- ===================== NOTES ===================== --}}
                                        <div class="tm-section-card is-active" id="notes">
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
                                        <div class="tm-section-card" id="profile">
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
                                        <div class="tm-section-card" id="basic-info">
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
                                        <div class="tm-section-card" id="password">
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
                                        <div class="tm-section-card" id="2fa">
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
                                        <div class="tm-section-card" id="accounts">
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
                                        <div class="tm-section-card" id="notifications">
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
                                        <div class="tm-section-card" id="sessions">
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
                                        <div class="tm-section-card" id="holder">
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
                                                <li class="nav-item">
                                                    <p class="tm-tabs-label">Sections</p>
                                                </li>

                                                <li class="nav-item pt-2">
                                                    <button class="is-active" type="button" data-tab-target="notes">
                                                        <span class="text-sm">{{ __('messages.note_important') }}</span>
                                                    </button>
                                                </li>

                                                <li class="nav-item">
                                                    <button type="button" data-tab-target="profile">
                                                        <span class="text-sm">{{ __('messages.reference_numbers') }}</span>
                                                    </button>
                                                </li>

                                                <li class="nav-item pt-2">
                                                    <button type="button" data-tab-target="basic-info">
                                                        <span class="text-sm">{{ __('messages.general_information') }}</span>
                                                    </button>
                                                </li>

                                                <li class="nav-item pt-2">
                                                    <button type="button" data-tab-target="password">
                                                        <span class="text-sm">{{ __('messages.important_dates') }}</span>
                                                    </button>
                                                </li>

                                                <li class="nav-item pt-2">
                                                    <button type="button" data-tab-target="2fa">
                                                        <span class="text-sm">{{ __('messages.trademark_information') }}</span>
                                                    </button>
                                                </li>

                                                <li class="nav-item pt-2">
                                                    <button type="button" data-tab-target="accounts">
                                                        <span class="text-sm">{{ __('messages.goods_services') }}</span>
                                                    </button>
                                                </li>

                                                <li class="nav-item pt-2">
                                                    <button type="button" data-tab-target="notifications">
                                                        <span class="text-sm">{{ __('messages.priority_information') }}</span>
                                                    </button>
                                                </li>

                                                <li class="nav-item pt-2">
                                                    <button type="button" data-tab-target="sessions">
                                                        <span class="text-sm">{{ __('messages.client_info') }}</span>
                                                    </button>
                                                </li>

                                                <li class="nav-item pt-2">
                                                    <button type="button" data-tab-target="holder">
                                                        <span class="text-sm">{{ __('messages.holder_info') }}</span>
                                                    </button>
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
(function () {
    const tabButtons = Array.from(document.querySelectorAll('.tm-menu button[data-tab-target]'));
    const sections = Array.from(document.querySelectorAll('.tm-section-card'));

    function setActiveTab(id, updateHash = true) {
        tabButtons.forEach(button => {
            button.classList.toggle('is-active', button.dataset.tabTarget === id);
        });

        sections.forEach(section => {
            section.classList.toggle('is-active', section.id === id);
        });

        if (updateHash && window.history) {
            window.history.replaceState(null, '', '#' + id);
        }
    }

    tabButtons.forEach(button => {
        button.addEventListener('click', function () {
            setActiveTab(this.dataset.tabTarget);
        });
    });

    const initialTab = window.location.hash ? window.location.hash.replace('#', '') : 'notes';
    if (document.getElementById(initialTab)) {
        setActiveTab(initialTab, false);
    }
})();
</script>

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
