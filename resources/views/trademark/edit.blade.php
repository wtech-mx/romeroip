@extends('layouts.app')

@section('template_title')
    {{ __('messages.edit_trademark') }}
@endsection

@section('css')
<style>
    :root{
        --tm-primary: #FF7F11;
        --tm-secondary: #ACBFA4;
        --tm-soft: #E2E8CE;
        --tm-dark: #262626;
        --tm-border: #E5E7EB;
        --tm-bg: #F7F7F2;
        --tm-white: #FFFFFF;
        --tm-muted: #6B7280;
        --tm-top-offset: 90px;
    }

    html{
        scroll-behavior: smooth;
    }

    body{
        background: var(--tm-bg);
    }

    .tm-page{
        padding-bottom: 3rem;
    }

    /* IMPORTANTE para sticky */
    body,
    .main-content,
    .container-fluid,
    .row,
    .col,
    .card,
    .card-body{
        overflow: visible !important;
    }

    /* ===== TOP CARD ===== */
    .tm-top-card{
        position: sticky;
        top: var(--tm-top-offset);
        z-index: 1030;
        margin-bottom: 1.25rem;
        background-color: #fff;
        border: 1px solid rgba(38,38,38,.08);
        border-radius: 22px;
        box-shadow: 0 12px 30px rgba(38,38,38,.08);
        padding: 1.2rem 1.4rem;
    }

    .tm-top-card-inner{
        background: linear-gradient(135deg, rgba(226,232,206,.95) 0%, rgba(172,191,164,.30) 100%);
        border: 1px solid rgba(38,38,38,.08);
        border-radius: 22px;
        box-shadow: 0 12px 30px rgba(38,38,38,.08);
        padding: 1.2rem 1.4rem;
    }

    .tm-kicker{
        font-size: .78rem;
        font-weight: 800;
        letter-spacing: .10em;
        text-transform: uppercase;
        color: var(--tm-primary);
    }

    .tm-title{
        margin: .15rem 0 0;
        font-size: 2rem;
        font-weight: 800;
        color: var(--tm-dark);
    }

    .tm-subtitle{
        margin: .3rem 0 0;
        color: var(--tm-muted);
        font-size: .96rem;
    }

    .tm-toolbar{
        display: flex;
        gap: .75rem;
        flex-wrap: wrap;
        justify-content: flex-end;
        align-items: center;
    }

    .tm-btn{
        min-height: 46px;
        padding: 0 1.15rem;
        border-radius: 14px;
        font-weight: 800;
        border: 0;
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        text-decoration: none;
        transition: .18s ease;
    }

    .tm-btn:hover{
        transform: translateY(-1px);
    }

    .tm-btn-back{
        background: var(--tm-secondary);
        color: var(--tm-dark);
        box-shadow: 0 10px 18px rgba(38,38,38,.10);
    }

    .tm-btn-save{
        background: linear-gradient(135deg, var(--tm-primary) 0%, #E76E08 100%);
        color: var(--tm-white);
        box-shadow: 0 10px 18px rgba(255,127,17,.24);
    }

    /* ===== LAYOUT ===== */
    .tm-layout{
        align-items: flex-start;
    }

    /* ===== MAIN SECTION CARDS ===== */
    .tm-section-card{
        background: var(--tm-white);
        border: 1px solid rgba(38,38,38,.08);
        border-radius: 22px;
        box-shadow: 0 10px 28px rgba(38,38,38,.05);
        overflow: hidden;
        margin-bottom: 1.25rem;
        scroll-margin-top: calc(var(--tm-top-offset) + 100px);
    }

    .tm-section-head{
        padding: 1.1rem 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        background: linear-gradient(135deg, rgba(226,232,206,.55) 0%, rgba(172,191,164,.18) 100%);
        border-bottom: 1px solid rgba(38,38,38,.06);
    }

    .tm-section-title{
        margin: 0;
        font-size: 1.08rem;
        font-weight: 800;
        color: var(--tm-dark);
        display: flex;
        align-items: center;
        gap: .7rem;
    }

    .tm-section-icon{
        width: 38px;
        height: 38px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,127,17,.14);
        color: var(--tm-primary);
        font-size: 1rem;
        flex: 0 0 auto;
    }

    .tm-section-sub{
        margin: .2rem 0 0;
        font-size: .89rem;
        color: var(--tm-muted);
    }

    .tm-section-badge{
        width: 38px;
        height: 38px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        background: linear-gradient(135deg, var(--tm-primary), #E76E08);
        color: #fff;
        box-shadow: 0 8px 18px rgba(255,127,17,.22);
        flex: 0 0 auto;
    }

    .tm-section-body{
        padding: 1.2rem 1.25rem 1.3rem;
    }

    /* ===== INPUTS ===== */
    .tm-label{
        display: inline-block;
        margin-bottom: .45rem;
        font-weight: 700;
        color: var(--tm-dark);
        font-size: .9rem;
    }

    .tm-input,
    .tm-select{
        min-height: 50px;
        border-radius: 14px;
        border: 1px solid var(--tm-border);
        background: #fff;
        color: var(--tm-dark);
        box-shadow: none !important;
    }

    .tm-input:focus,
    .tm-select:focus{
        border-color: var(--tm-primary);
        box-shadow: 0 0 0 .2rem rgba(255,127,17,.12) !important;
    }

    textarea.tm-input{
        min-height: auto;
        padding-top: .8rem;
        padding-bottom: .8rem;
    }

    .tm-readonly{
        background: rgba(226,232,206,.35);
        font-weight: 700;
    }

    /* ===== IMAGE PREVIEW ===== */
    .tm-preview-wrap{
        min-height: 360px;
        border-radius: 18px;
        border: 1px dashed rgba(172,191,164,.95);
        background: linear-gradient(180deg, #fff 0%, rgba(226,232,206,.35) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 1rem;
    }

    .tm-preview-image{
        width: 100%;
        max-width: 340px;
        max-height: 340px;
        object-fit: contain;
        border-radius: 14px;
    }

    /* ===== SIDE MENU ===== */
    .tm-aside{
        position: sticky;
        top: calc(var(--tm-top-offset) + 110px);
        z-index: 1020;
    }

    .tm-menu-card{
        background: var(--tm-white);
        border: 1px solid rgba(38,38,38,.08);
        border-radius: 22px;
        box-shadow: 0 10px 28px rgba(38,38,38,.05);
        overflow: hidden;
    }

    .tm-menu-head{
        padding: 1rem 1.1rem;
        border-bottom: 1px solid rgba(38,38,38,.06);
        background: linear-gradient(135deg, rgba(226,232,206,.55) 0%, rgba(172,191,164,.18) 100%);
    }

    .tm-menu-head h5{
        margin: 0;
        font-weight: 800;
        color: var(--tm-dark);
    }

    .tm-menu-head p{
        margin: .25rem 0 0;
        color: var(--tm-muted);
        font-size: .88rem;
    }

    .tm-menu-body{
        padding: .9rem;
    }

    .tm-menu-link{
        display: flex;
        align-items: center;
        gap: .65rem;
        padding: .8rem .9rem;
        border-radius: 14px;
        color: var(--tm-dark);
        text-decoration: none;
        font-weight: 700;
        transition: .18s ease;
    }

    .tm-menu-link:hover{
        background: rgba(255,127,17,.08);
        color: var(--tm-primary);
    }

    .tm-menu-link i{
        width: 18px;
        text-align: center;
    }

    /* ===== AUTOCOMPLETE ===== */
    .autocomplete-wrap{
        position: relative;
    }

    .autocomplete-box{
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        right: 0;
        z-index: 1055;
        background: #fff;
        border: 1px solid var(--tm-border);
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
        color: var(--tm-dark);
        display: block;
    }

    .autocomplete-subtitle{
        font-size: .85rem;
        color: var(--tm-muted);
        display: block;
    }

    .d-none{
        display: none !important;
    }

    @media (max-width: 991.98px){
        :root{
            --tm-top-offset: 76px;
        }

        .tm-top-card,
        .tm-aside{
            position: static;
            top: auto;
        }

        .tm-toolbar{
            justify-content: flex-start;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid mt-3 tm-page">
    <form method="POST"
          action="{{ route('update.trademarks', $trademark->id) }}"
          enctype="multipart/form-data"
          id="trademarkEditForm"
          novalidate>
        @csrf
        @method('PATCH')

        {{-- Top card --}}
        <div class="tm-top-card">
            <div class="tm-top-card-body">
                <div class="row g-3 align-items-center">
                    <div class="col-lg-7">
                        <div class="tm-kicker">Trademark File</div>
                        <h1 class="tm-title">{{ __('messages.edit_trademark') }}</h1>
                        <p class="tm-subtitle">
                            Update the trademark record and save the changes when you are ready.
                        </p>
                    </div>

                    <div class="col-lg-5">
                        <div class="tm-toolbar">
                            <a class="tm-btn tm-btn-back"
                               href="javascript:history.back()">
                                <i class="bi bi-arrow-left-circle"></i>
                                {{ __('messages.back') }}
                            </a>

                            <button type="submit" class="tm-btn tm-btn-save">
                                <i class="bi bi-floppy"></i>
                                {{ __('messages.update') }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    @includeIf('partials.errors')
                </div>
            </div>
        </div>

        <div class="row tm-layout">
            <div class="col-xl-9 col-lg-8">

                {{-- Notes --}}
                <div class="tm-section-card" id="notes">
                    <div class="tm-section-head">
                        <div>
                            <h5 class="tm-section-title">
                                <span class="tm-section-icon"><i class="bi bi-journal-text"></i></span>
                                {{ __('messages.note_important') }}
                            </h5>
                            <p class="tm-section-sub">Internal notes or relevant file context.</p>
                        </div>
                        <span class="tm-section-badge">01</span>
                    </div>

                    <div class="tm-section-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="tm-label">{{ __('messages.note') }}</label>
                                <textarea class="form-control tm-input" id="notes_text" name="notes" rows="3">{{ old('notes', $trademark->notes) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Reference Numbers --}}
                <div class="tm-section-card" id="profile">
                    <div class="tm-section-head">
                        <div>
                            <h5 class="tm-section-title">
                                <span class="tm-section-icon"><i class="bi bi-hash"></i></span>
                                {{ __('messages.reference_numbers') }}
                            </h5>
                            <p class="tm-section-sub">Internal control, client reference and case numbers.</p>
                        </div>
                        <span class="tm-section-badge">02</span>
                    </div>

                    <div class="tm-section-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.our_ref') }}</label>
                                <input id="our_ref" name="our_ref" class="form-control tm-input"
                                    type="number" min="1" step="1"
                                    value="{{ old('our_ref', $trademark->our_ref) }}" readonly>
                            </div>

                            <div class="col-md-6 autocomplete-wrap">
                                <label class="tm-label">{{ __('messages.client_ref') }}</label>
                                <input id="client_ref" name="client_ref" class="form-control tm-input"
                                    type="text"
                                    autocomplete="off"
                                    value="{{ old('client_ref', $trademark->client_ref) }}">
                                <div id="client_ref_suggestions" class="autocomplete-box d-none"></div>
                            </div>

                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.opposition_no') }}</label>
                                <input id="opposition_no" name="opposition_no" class="form-control tm-input"
                                    type="text"
                                    value="{{ old('opposition_no', $trademark->opposition_no) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.filing_date') }}</label>
                                <input id="filing_date_opposition" name="filing_date_opposition" class="form-control tm-input date-mask"
                                    type="text" maxlength="10" placeholder="MM DD YYYY"
                                    value="{{ old('filing_date_opposition', optional($trademark->filing_date_opposition)->format ? $trademark->filing_date_opposition->format('m d Y') : (filled($trademark->filing_date_opposition) ? \Carbon\Carbon::parse($trademark->filing_date_opposition)->format('m d Y') : '') ) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.litigation_no') }}</label>
                                <input id="litigation_no" name="litigation_no" class="form-control tm-input"
                                    type="text"
                                    value="{{ old('litigation_no', $trademark->litigation_no) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.filing_date') }}</label>
                                <input id="filing_date_litigation" name="filing_date_litigation" class="form-control tm-input date-mask"
                                    type="text" maxlength="10" placeholder="MM DD YYYY"
                                    value="{{ old('filing_date_litigation', filled($trademark->filing_date_litigation) ? \Carbon\Carbon::parse($trademark->filing_date_litigation)->format('m d Y') : '') }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- General Information --}}
                <div class="tm-section-card" id="basic-info">
                    <div class="tm-section-head">
                        <div>
                            <h5 class="tm-section-title">
                                <span class="tm-section-icon"><i class="bi bi-info-circle"></i></span>
                                {{ __('messages.general_information') }}
                            </h5>
                            <p class="tm-section-sub">Main filing data, country, status and key dates.</p>
                        </div>
                        <span class="tm-section-badge">03</span>
                    </div>

                    <div class="tm-section-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.application_no') }}</label>
                                <input id="application_no" name="application_no" class="form-control tm-input"
                                    type="text"
                                    value="{{ old('application_no', $trademark->application_no) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.origin') }}</label>
                                <select class="form-control tm-select" name="origin" id="origin">
                                    <option value="">{{ __('messages.select') }}</option>
                                    <option value="{{ __('messages.national') }}" {{ old('origin', $trademark->origin) == __('messages.national') ? 'selected' : '' }}>
                                        {{ __('messages.national') }}
                                    </option>
                                    <option value="{{ __('messages.international') }}" {{ old('origin', $trademark->origin) == __('messages.international') ? 'selected' : '' }}>
                                        {{ __('messages.international') }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.registration_no') }}</label>
                                <input id="registration_no" name="registration_no" class="form-control tm-input"
                                    type="text"
                                    value="{{ old('registration_no', $trademark->registration_no) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.country') }}</label>
                                <select class="form-control tm-select" name="country" id="country">
                                    <option value="">{{ __('messages.select') }}</option>
                                    @include('client.paises')
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.filing_date') }}</label>
                                <input id="filing_date_general" name="filing_date_general" class="form-control tm-input date-mask"
                                    type="text" maxlength="10" placeholder="MM DD YYYY"
                                    value="{{ old('filing_date_general', filled($trademark->filing_date_general) ? \Carbon\Carbon::parse($trademark->filing_date_general)->format('m d Y') : '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.status') }}</label>
                                <select class="form-control tm-select" id="status" name="status">
                                    <option value="{{ __('messages.registered') }}" {{ old('status', $trademark->status) == __('messages.registered') ? 'selected' : '' }}>
                                        {{ __('messages.registered') }}
                                    </option>
                                    <option value="{{ __('messages.pending') }}" {{ old('status', $trademark->status) == __('messages.pending') ? 'selected' : '' }}>
                                        {{ __('messages.pending') }}
                                    </option>
                                    <option value="{{ __('messages.abandoned') }}" {{ old('status', $trademark->status) == __('messages.abandoned') ? 'selected' : '' }}>
                                        {{ __('messages.abandoned') }}
                                    </option>
                                    <option value="{{ __('messages.lapsed') }}" {{ old('status', $trademark->status) == __('messages.lapsed') ? 'selected' : '' }}>
                                        {{ __('messages.lapsed') }}
                                    </option>
                                    <option value="{{ __('messages.inactive') }}" {{ old('status', $trademark->status) == __('messages.inactive') ? 'selected' : '' }}>
                                        {{ __('messages.inactive') }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.first_date') }}</label>
                                <input id="first_date" name="first_date" class="form-control tm-input date-mask"
                                    type="text" maxlength="10" placeholder="MM DD YYYY"
                                    value="{{ old('first_date', filled($trademark->first_date) ? \Carbon\Carbon::parse($trademark->first_date)->format('m d Y') : '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.int_registration_no') }}</label>
                                <input id="int_registration_no" name="int_registration_no" class="form-control tm-input"
                                    type="text"
                                    value="{{ old('int_registration_no', $trademark->int_registration_no) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.registration_date') }}</label>
                                <input id="registrationDate" name="registration_date" class="form-control tm-input date-mask"
                                    type="text" maxlength="10" placeholder="MM DD YYYY"
                                    value="{{ old('registration_date', filled($trademark->registration_date) ? \Carbon\Carbon::parse($trademark->registration_date)->format('m d Y') : '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.int_registration_date') }}</label>
                                <input id="int_registration_date" name="int_registration_date" class="form-control tm-input date-mask"
                                    type="text" maxlength="10" placeholder="MM DD YYYY"
                                    value="{{ old('int_registration_date', filled($trademark->int_registration_date) ? \Carbon\Carbon::parse($trademark->int_registration_date)->format('m d Y') : '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.expiration_date') }}</label>
                                <input id="expirationDate" name="expiration_date" class="form-control tm-input tm-readonly date-mask"
                                    type="text" maxlength="10" placeholder="MM DD YYYY" readonly
                                    value="{{ old('expiration_date', filled($trademark->expiration_date) ? \Carbon\Carbon::parse($trademark->expiration_date)->format('m d Y') : '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.contracting_organization') }}</label>
                                <input id="contracting_organization" name="contracting_organization" class="form-control tm-input"
                                    type="text"
                                    value="{{ old('contracting_organization', $trademark->contracting_organization) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.publication_date') }}</label>
                                <input id="publication_date" name="publication_date" class="form-control tm-input date-mask"
                                    type="text" maxlength="10" placeholder="MM DD YYYY"
                                    value="{{ old('publication_date', filled($trademark->publication_date) ? \Carbon\Carbon::parse($trademark->publication_date)->format('m d Y') : '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.designated_countries') }}</label>
                                <input id="designated_countries" name="designated_countries" class="form-control tm-input"
                                    type="text"
                                    value="{{ old('designated_countries', $trademark->designated_countries) }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Important Dates --}}
                <div class="tm-section-card" id="password">
                    <div class="tm-section-head">
                        <div>
                            <h5 class="tm-section-title">
                                <span class="tm-section-icon"><i class="bi bi-calendar3"></i></span>
                                {{ __('messages.important_dates') }}
                            </h5>
                            <p class="tm-section-sub">Declaration of use and renewal timeline.</p>
                        </div>
                        <span class="tm-section-badge">04</span>
                    </div>

                    <div class="tm-section-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.declarations_use') }}</label>
                            </div>
                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.renewals') }}</label>
                            </div>

                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.last') }}</label>
                                <input id="lastDeclarationDate" name="last_declaration" class="form-control tm-input date-mask"
                                    type="text" maxlength="10" placeholder="MM DD YYYY"
                                    value="{{ old('last_declaration', filled($trademark->last_declaration) ? \Carbon\Carbon::parse($trademark->last_declaration)->format('m d Y') : '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.last') }}</label>
                                <input id="lastRenewalsDate" name="last_renewal" class="form-control tm-input date-mask"
                                    type="text" maxlength="10" placeholder="MM DD YYYY"
                                    value="{{ old('last_renewal', filled($trademark->last_renewal) ? \Carbon\Carbon::parse($trademark->last_renewal)->format('m d Y') : '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.next') }}</label>
                                <input id="declarationOfUseDate" name="next_declaration" class="form-control tm-input tm-readonly date-mask"
                                    type="text" maxlength="10" placeholder="MM DD YYYY" readonly
                                    value="{{ old('next_declaration', filled($trademark->next_declaration) ? \Carbon\Carbon::parse($trademark->next_declaration)->format('m d Y') : '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.next') }}</label>
                                <input id="renewalDate" name="next_renewal" class="form-control tm-input tm-readonly date-mask"
                                    type="text" maxlength="10" placeholder="MM DD YYYY" readonly
                                    value="{{ old('next_renewal', filled($trademark->next_renewal) ? \Carbon\Carbon::parse($trademark->next_renewal)->format('m d Y') : '') }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Trademark Information --}}
                <div class="tm-section-card" id="trademark-section">
                    <div class="tm-section-head">
                        <div>
                            <h5 class="tm-section-title">
                                <span class="tm-section-icon"><i class="bi bi-patch-check"></i></span>
                                {{ __('messages.trademark_information') }}
                            </h5>
                            <p class="tm-section-sub">Trademark name, description, type and image.</p>
                        </div>
                        <span class="tm-section-badge">05</span>
                    </div>

                    <div class="tm-section-body">
                        <div class="row g-4">
                            <div class="col-lg-7">
                                <div class="row g-3">
                                    <div class="col-12 autocomplete-wrap">
                                        <label class="tm-label">{{ __('messages.trademark') }}</label>
                                        <input id="trademark" name="trademark" class="form-control tm-input"
                                            type="text" autocomplete="off"
                                            value="{{ old('trademark', $trademark->trademark) }}">
                                        <div id="trademark_suggestions" class="autocomplete-box d-none"></div>
                                    </div>

                                    <div class="col-12">
                                        <label class="tm-label">{{ __('messages.description') }}</label>
                                        <textarea class="form-control tm-input" id="description_trademark" name="description_trademark" rows="3">{{ old('description_trademark', $trademark->description_trademark) }}</textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="tm-label">{{ __('messages.type_application') }}</label>
                                        <select class="form-control tm-select" id="type_application" name="type_application">
                                            <option value="">{{ __('messages.select') }}</option>
                                            <option value="Trademark" {{ old('type_application', $trademark->type_application) == 'Trademark' ? 'selected' : '' }}>Trademark</option>
                                            <option value="Trade Name" {{ old('type_application', $trademark->type_application) == 'Trade Name' ? 'selected' : '' }}>Trade Name</option>
                                            <option value="Slogan" {{ old('type_application', $trademark->type_application) == 'Slogan' ? 'selected' : '' }}>Slogan</option>
                                            <option value="Collective Mark" {{ old('type_application', $trademark->type_application) == 'Collective Mark' ? 'selected' : '' }}>Collective Mark</option>
                                            <option value="Certification Mark" {{ old('type_application', $trademark->type_application) == 'Certification Mark' ? 'selected' : '' }}>Certification Mark</option>
                                            <option value="Nontraditional" {{ old('type_application', $trademark->type_application) == 'Nontraditional' ? 'selected' : '' }}>Nontraditional</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="tm-label">{{ __('messages.type_mark') }}</label>
                                        <select class="form-control tm-select" id="type_mark" name="type_mark">
                                            <option value="">{{ __('messages.select') }}</option>
                                            <option value="Word Marks" {{ old('type_mark', $trademark->type_mark) == 'Word Marks' ? 'selected' : '' }}>Word Marks</option>
                                            <option value="Design Marks" {{ old('type_mark', $trademark->type_mark) == 'Design Marks' ? 'selected' : '' }}>Design Marks</option>
                                            <option value="Combined Marks" {{ old('type_mark', $trademark->type_mark) == 'Combined Marks' ? 'selected' : '' }}>Combined Marks</option>
                                            <option value="Tridimensional Marks" {{ old('type_mark', $trademark->type_mark) == 'Tridimensional Marks' ? 'selected' : '' }}>Tridimensional Marks</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="tm-label">{{ __('messages.translation') }}</label>
                                        <textarea class="form-control tm-input" id="translation" name="translation" rows="2">{{ old('translation', $trademark->translation) }}</textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="tm-label">{{ __('messages.transliteration') }}</label>
                                        <textarea class="form-control tm-input" id="transliteration_trademark" name="transliteration_trademark" rows="2">{{ old('transliteration_trademark', $trademark->transliteration_trademark) }}</textarea>
                                    </div>

                                    <div class="col-12">
                                        <label class="tm-label">{{ __('messages.disclaimer') }}</label>
                                        <textarea class="form-control tm-input" id="disclaimer" name="disclaimer" rows="2">{{ old('disclaimer', $trademark->disclaimer) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="tm-label">{{ __('messages.design') }}</label>
                                        <input id="design" name="design" class="form-control tm-input"
                                            type="file" accept=".jpg,.jpeg,.png,.webp,image/*">
                                    </div>

                                    <div class="col-12">
                                        <div class="tm-preview-wrap">
                                            <img id="blah"
                                                class="tm-preview-image"
                                                src="{{ $trademark->design ? asset('design/'.$trademark->design) : asset('design/no-image.jpg') }}"
                                                alt="Trademark design preview">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Goods / Services --}}
                <div class="tm-section-card" id="accounts">
                    <div class="tm-section-head">
                        <div>
                            <h5 class="tm-section-title">
                                <span class="tm-section-icon"><i class="bi bi-box-seam"></i></span>
                                {{ __('messages.goods_services') }}
                            </h5>
                            <p class="tm-section-sub">Nice class and goods/services description.</p>
                        </div>
                        <span class="tm-section-badge">06</span>
                    </div>

                    <div class="tm-section-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.class') }}</label>
                                <select class="form-control tm-select" id="class" name="class">
                                    <option value="">{{ __('messages.select') }}</option>
                                    @for ($i = 1; $i <= 45; $i++)
                                        <option value="{{ $i }}" {{ old('class', $trademark->class) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="tm-label">{{ __('messages.description') }}</label>
                                <textarea class="form-control tm-input" id="description_good" name="description_good" rows="4">{{ old('description_good', $trademark->description_good) }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="tm-label">{{ __('messages.translation') }}</label>
                                <textarea class="form-control tm-input" id="translation_good" name="translation_good" rows="4">{{ old('translation_good', $trademark->translation_good) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Priority Information --}}
                <div class="tm-section-card" id="notifications">
                    <div class="tm-section-head">
                        <div>
                            <h5 class="tm-section-title">
                                <span class="tm-section-icon"><i class="bi bi-flag"></i></span>
                                {{ __('messages.priority_information') }}
                            </h5>
                            <p class="tm-section-sub">Priority number, office and priority date.</p>
                        </div>
                        <span class="tm-section-badge">07</span>
                    </div>

                    <div class="tm-section-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.priority_no') }}</label>
                                <input id="priority_no" name="priority_no" class="form-control tm-input"
                                    type="text"
                                    value="{{ old('priority_no', $trademark->priority_no) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.country_office') }}</label>
                                <select class="form-control tm-select" name="country_office" id="country_office">
                                    <option value="">{{ __('messages.select') }}</option>
                                    @include('client.paises')
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.priority_date') }}</label>
                                <input id="priority_date" name="priority_date" class="form-control tm-input date-mask"
                                    type="text" maxlength="10" placeholder="MM DD YYYY"
                                    value="{{ old('priority_date', filled($trademark->priority_date) ? \Carbon\Carbon::parse($trademark->priority_date)->format('m d Y') : '') }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Client Information --}}
                <div class="tm-section-card" id="sessions">
                    <div class="tm-section-head">
                        <div>
                            <h5 class="tm-section-title">
                                <span class="tm-section-icon"><i class="bi bi-building"></i></span>
                                {{ __('messages.client_info') }}
                            </h5>
                            <p class="tm-section-sub">Client, contact, main address and billing preview.</p>
                        </div>
                        <span class="tm-section-badge">08</span>
                    </div>

                    <div class="tm-section-body">
                        <div class="row g-3">
                            <div class="col-12 autocomplete-wrap">
                                <label class="tm-label">{{ __('messages.client') }}</label>
                                <input type="text"
                                    id="client_search"
                                    class="form-control tm-input"
                                    autocomplete="off"
                                    value="{{ old('client_search', optional($trademark->Client)->company_name) }}">
                                <input type="hidden"
                                    id="id_client"
                                    name="id_client"
                                    value="{{ old('id_client', $trademark->id_client) }}">
                                <div id="client_search_suggestions" class="autocomplete-box d-none"></div>
                            </div>

                            <div class="col-12">
                                <label class="tm-label">{{ __('messages.contact') }}</label>
                                <select class="form-control tm-select" name="id_contact" id="id_contact">
                                    @if($trademark->id_contact && $trademark->ContactClient)
                                        <option value="{{ $trademark->id_contact }}" selected>{{ $trademark->ContactClient->name }}</option>
                                    @else
                                        <option value="">{{ __('messages.select') }}</option>
                                    @endif
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="tm-label">{{ __('messages.address') }}</label>
                                <select class="form-control tm-select" name="id_address" id="id_address">
                                    @if($trademark->id_address && $trademark->AddressContact)
                                        <option value="{{ $trademark->id_address }}" selected>{{ $trademark->AddressContact->address }}</option>
                                    @else
                                        <option value="">{{ __('messages.select') }}</option>
                                    @endif
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="tm-label">{{ __('messages.billing_address') }}</label>
                                <select class="form-control tm-select" id="billing_address_preview" disabled>
                                    <option value="">
                                        {{ optional($trademark->AddressContact)->billing_address ?? __('messages.select') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Holder Information --}}
                <div class="tm-section-card" id="holder">
                    <div class="tm-section-head">
                        <div>
                            <h5 class="tm-section-title">
                                <span class="tm-section-icon"><i class="bi bi-person-badge"></i></span>
                                {{ __('messages.holder_info') }}
                            </h5>
                            <p class="tm-section-sub">Holder and related addresses.</p>
                        </div>
                        <span class="tm-section-badge">09</span>
                    </div>

                    <div class="tm-section-body">
                        <div class="row g-3">
                            <div class="col-12 autocomplete-wrap">
                                <label class="tm-label">{{ __('messages.holder') }}</label>
                                <input type="text"
                                    id="holder_search"
                                    class="form-control tm-input"
                                    autocomplete="off"
                                    value="{{ old('holder_search', optional($trademark->Holder)->company_name) }}">
                                <input type="hidden"
                                    id="id_holder"
                                    name="id_holder"
                                    value="{{ old('id_holder', $trademark->id_holder) }}">
                                <div id="holder_search_suggestions" class="autocomplete-box d-none"></div>
                            </div>

                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.address') }}</label>
                                <select class="form-control tm-select" name="address_holder" id="address_holder">
                                    @if($trademark->address_holder && $trademark->AddressHolder)
                                        <option value="{{ $trademark->address_holder }}" selected>{{ $trademark->AddressHolder->address }}</option>
                                    @else
                                        <option value="">{{ __('messages.select') }}</option>
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="tm-label">{{ __('messages.industrial_address') }}</label>
                                <select class="form-control tm-select" name="industrial_address" id="industrial_address">
                                    @if($trademark->industrial_address)
                                        <option value="{{ $trademark->industrial_address }}" selected>{{ $trademark->industrial_address }}</option>
                                    @else
                                        <option value="">{{ __('messages.select') }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Side menu --}}
            <div class="col-xl-3 col-lg-4 mt-4 mt-lg-0">
                <div class="tm-aside">
                    <div class="tm-menu-card">
                        <div class="tm-menu-head">
                            <h5>Sections</h5>
                            <p>Quick navigation through the trademark file.</p>
                        </div>

                        <div class="tm-menu-body">
                            <a class="tm-menu-link" href="#notes"><i class="bi bi-journal-text"></i> {{ __('messages.note_important') }}</a>
                            <a class="tm-menu-link" href="#profile"><i class="bi bi-hash"></i> {{ __('messages.reference_numbers') }}</a>
                            <a class="tm-menu-link" href="#basic-info"><i class="bi bi-info-circle"></i> {{ __('messages.general_information') }}</a>
                            <a class="tm-menu-link" href="#password"><i class="bi bi-calendar3"></i> {{ __('messages.important_dates') }}</a>
                            <a class="tm-menu-link" href="#trademark-section"><i class="bi bi-patch-check"></i> {{ __('messages.trademark_information') }}</a>
                            <a class="tm-menu-link" href="#accounts"><i class="bi bi-box-seam"></i> {{ __('messages.goods_services') }}</a>
                            <a class="tm-menu-link" href="#notifications"><i class="bi bi-flag"></i> {{ __('messages.priority_information') }}</a>
                            <a class="tm-menu-link" href="#sessions"><i class="bi bi-building"></i> {{ __('messages.client_info') }}</a>
                            <a class="tm-menu-link" href="#holder"><i class="bi bi-person-badge"></i> {{ __('messages.holder_info') }}</a>
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
(function () {
    function setSelectedOptionIfExists(selectId, value) {
        if (!value) return;
        const select = document.getElementById(selectId);
        if (!select) return;

        Array.from(select.options).forEach(option => {
            if (option.value === value) {
                option.selected = true;
            }
        });
    }

    setSelectedOptionIfExists('country', @json(old('country', $trademark->country)));
    setSelectedOptionIfExists('country_office', @json(old('country_office', $trademark->country_office)));
})();
</script>

<script>
(function () {
    document.querySelectorAll('.date-mask').forEach(input => {
        input.addEventListener('input', function () {
            let value = this.value.replace(/\D/g, '').substring(0, 8);

            let month = value.substring(0, 2);
            let day   = value.substring(2, 4);
            let year  = value.substring(4, 8);

            let formatted = month;
            if (day.length) formatted += ' ' + day;
            if (year.length) formatted += ' ' + year;

            this.value = formatted;
        });
    });

    function parseCustomDate(value) {
        if (!value) return null;
        const parts = value.trim().split(' ');
        if (parts.length !== 3) return null;

        const month = parseInt(parts[0], 10) - 1;
        const day = parseInt(parts[1], 10);
        const year = parseInt(parts[2], 10);

        const date = new Date(year, month, day);
        if (
            date.getFullYear() !== year ||
            date.getMonth() !== month ||
            date.getDate() !== day
        ) return null;

        return date;
    }

    function formatCustomDate(date) {
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const year = date.getFullYear();
        return `${month} ${day} ${year}`;
    }

    const registrationDate = document.getElementById('registrationDate');
    const expirationDate = document.getElementById('expirationDate');
    const declarationOfUseDate = document.getElementById('declarationOfUseDate');
    const renewalDate = document.getElementById('renewalDate');
    const lastDeclarationDate = document.getElementById('lastDeclarationDate');
    const lastRenewalsDate = document.getElementById('lastRenewalsDate');

    registrationDate?.addEventListener('change', function() {
        const reg = parseCustomDate(this.value);
        if (!reg) return;

        const exp = new Date(reg);
        exp.setFullYear(exp.getFullYear() + 10);

        const dec = new Date(reg);
        dec.setFullYear(dec.getFullYear() + 3);

        expirationDate.value = formatCustomDate(exp);
        declarationOfUseDate.value = formatCustomDate(dec);
        renewalDate.value = formatCustomDate(exp);
    });

    lastDeclarationDate?.addEventListener('change', function() {
        if (renewalDate.value) {
            declarationOfUseDate.value = renewalDate.value;
        } else {
            const date = parseCustomDate(this.value);
            if (!date) return;
            date.setFullYear(date.getFullYear() + 3);
            declarationOfUseDate.value = formatCustomDate(date);
        }
    });

    lastRenewalsDate?.addEventListener('change', function() {
        const date = parseCustomDate(this.value);
        if (!date) return;

        const next = new Date(date);
        next.setFullYear(next.getFullYear() + 10);

        expirationDate.value = formatCustomDate(next);
        declarationOfUseDate.value = formatCustomDate(next);
        renewalDate.value = formatCustomDate(next);
    });
})();
</script>

<script>
(function () {
    function readURL(input) {
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];
        if (!file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('blah').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    document.getElementById('design')?.addEventListener('change', function () {
        readURL(this);
    });
})();
</script>

<script>
(function () {
    function debounce(fn, delay = 300) {
        let timer;
        return function (...args) {
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(this, args), delay);
        };
    }

    function setupAutocomplete({
        inputSelector,
        boxSelector,
        url,
        hiddenSelector = null,
        minLength = 2,
        onSelect = null
    }) {
        const input = document.querySelector(inputSelector);
        const box = document.querySelector(boxSelector);
        const hidden = hiddenSelector ? document.querySelector(hiddenSelector) : null;

        if (!input || !box) return;

        const hideBox = () => {
            box.innerHTML = '';
            box.classList.add('d-none');
        };

        const renderItems = (items) => {
            if (!items.length) {
                hideBox();
                return;
            }

            box.innerHTML = items.map(item => `
                <div class="autocomplete-item"
                     data-id="${item.id ?? ''}"
                     data-value="${(item.value ?? '').replace(/"/g, '&quot;')}">
                    <span class="autocomplete-title">${item.title ?? ''}</span>
                    <span class="autocomplete-subtitle">${item.subtitle ?? ''}</span>
                </div>
            `).join('');

            box.classList.remove('d-none');

            box.querySelectorAll('.autocomplete-item').forEach(el => {
                el.addEventListener('click', function () {
                    const value = this.dataset.value || '';
                    const id = this.dataset.id || '';

                    input.value = value;
                    if (hidden) hidden.value = id;

                    hideBox();

                    if (typeof onSelect === 'function') {
                        onSelect({ id, value });
                    }
                });
            });
        };

        const fetchResults = debounce(async function () {
            const q = input.value.trim();

            if (hidden && !q) hidden.value = '';

            if (q.length < minLength) {
                hideBox();
                return;
            }

            try {
                const response = await fetch(`${url}?q=${encodeURIComponent(q)}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                const data = await response.json();
                renderItems(data);
            } catch (error) {
                hideBox();
            }
        }, 250);

        input.addEventListener('input', function () {
            if (hidden) hidden.value = '';
            fetchResults();
        });

        input.addEventListener('focus', function () {
            if (input.value.trim().length >= minLength) {
                fetchResults();
            }
        });

        document.addEventListener('click', function (e) {
            if (!box.contains(e.target) && e.target !== input) {
                hideBox();
            }
        });
    }

    function loadClientContacts(id) {
        $('#id_contact').empty().append(`<option value="" selected>Loading...</option>`);

        $.ajax({
            type: 'GET',
            url: '{{ url("crear") }}/' + id,
            success: function (response) {
                const data = typeof response === 'string' ? JSON.parse(response) : response;
                $('#id_contact').empty().append(`<option value="">{{ __('messages.select') }}</option>`);
                data.forEach(element => {
                    $('#id_contact').append(`<option value="${element.id}">${element.name}</option>`);
                });
            }
        });
    }

    function loadClientAddresses(id) {
        $('#id_address').empty().append(`<option value="" selected>Loading...</option>`);
        $('#billing_address_preview').empty().append(`<option value="" selected>Loading...</option>`);

        $.ajax({
            type: 'GET',
            url: '{{ url("/trademarks/address") }}/' + id,
            success: function (response) {
                const data = typeof response === 'string' ? JSON.parse(response) : response;

                $('#id_address').empty().append(`<option value="">{{ __('messages.select') }}</option>`);
                $('#billing_address_preview').empty().append(`<option value="">{{ __('messages.select') }}</option>`);

                data.forEach(element => {
                    $('#id_address').append(`<option value="${element.id}">${element.address ?? ''}</option>`);
                    $('#billing_address_preview').append(`<option value="${element.id}">${element.billing_address ?? ''}</option>`);
                });
            }
        });
    }

    function loadHolderAddresses(id) {
        $('#address_holder').empty().append(`<option value="" selected>Loading...</option>`);

        $.ajax({
            type: 'GET',
            url: '{{ url("holder") }}/' + id,
            success: function (response) {
                const data = typeof response === 'string' ? JSON.parse(response) : response;
                $('#address_holder').empty().append(`<option value="">{{ __('messages.select') }}</option>`);
                data.forEach(element => {
                    $('#address_holder').append(`<option value="${element.id}">${element.address}</option>`);
                });
            }
        });
    }

    function loadHolderIndustrialAddresses(id) {
        $('#industrial_address').empty().append(`<option value="" selected>Loading...</option>`);

        $.ajax({
            type: 'GET',
            url: '{{ url("holder/industrial") }}/' + id,
            success: function (response) {
                const data = typeof response === 'string' ? JSON.parse(response) : response;
                $('#industrial_address').empty().append(`<option value="">{{ __('messages.select') }}</option>`);
                data.forEach(element => {
                    $('#industrial_address').append(`<option value="${element.commercial_address}">${element.commercial_address}</option>`);
                });
            }
        });
    }

    setupAutocomplete({
        inputSelector: '#client_ref',
        boxSelector: '#client_ref_suggestions',
        url: '{{ route('ajax.trademarks.client_ref') }}'
    });

    setupAutocomplete({
        inputSelector: '#trademark',
        boxSelector: '#trademark_suggestions',
        url: '{{ route('ajax.trademarks.name') }}'
    });

    setupAutocomplete({
        inputSelector: '#client_search',
        boxSelector: '#client_search_suggestions',
        url: '{{ route('ajax.clients.autocomplete') }}',
        hiddenSelector: '#id_client',
        onSelect: function (item) {
            if (!item.id) return;
            loadClientContacts(item.id);
            loadClientAddresses(item.id);
        }
    });

    setupAutocomplete({
        inputSelector: '#holder_search',
        boxSelector: '#holder_search_suggestions',
        url: '{{ route('ajax.holders.autocomplete') }}',
        hiddenSelector: '#id_holder',
        onSelect: function (item) {
            if (!item.id) return;
            loadHolderAddresses(item.id);
            loadHolderIndustrialAddresses(item.id);
        }
    });
})();
</script>

<script>
(function () {
    const form = document.getElementById('trademarkEditForm');
    if (!form) return;

    const requiredFields = [
        { id: 'our_ref', label: 'Our Ref.' },
        { id: 'trademark', label: 'Trademark' },
        { id: 'status', label: 'Status' },
        { id: 'id_client', label: 'Client' },
    ];

    function clearInvalid(el) {
        if (!el) return;
        el.classList.remove('is-invalid');
        const wrapper = el.closest('.autocomplete-wrap') || el.closest('.input-group') || el.parentElement;
        const feedback = wrapper?.querySelector('.invalid-feedback.dynamic-feedback');
        if (feedback) feedback.remove();
    }

    function markInvalid(el, message) {
        if (!el) return;
        el.classList.add('is-invalid');
        const wrapper = el.closest('.autocomplete-wrap') || el.closest('.input-group') || el.parentElement;
        if (!wrapper) return;

        let feedback = wrapper.querySelector('.invalid-feedback.dynamic-feedback');
        if (!feedback) {
            feedback = document.createElement('div');
            feedback.className = 'invalid-feedback dynamic-feedback d-block';
            feedback.textContent = message;
            wrapper.appendChild(feedback);
        } else {
            feedback.textContent = message;
        }
    }

    function isEmpty(el) {
        if (!el) return true;
        return String(el.value || '').trim() === '';
    }

    form.addEventListener('submit', function (e) {
        const errors = [];

        requiredFields.forEach(field => {
            const el = document.getElementById(field.id);
            clearInvalid(el);

            if (isEmpty(el)) {
                markInvalid(el, `${field.label} is required.`);
                errors.push(field.label);
            }
        });

        if (errors.length) {
            e.preventDefault();

            if (window.Swal) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Please review the form',
                    html: `<div class="text-start">${errors.map(item => `<div>${item}</div>`).join('')}</div>`,
                    confirmButtonColor: '#FF7F11'
                });
            } else {
                alert('Please review the required fields: ' + errors.join(', '));
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
