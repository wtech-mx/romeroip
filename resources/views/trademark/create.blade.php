@extends('layouts.app')

@section('template_title')
    {{ __('messages.new_trademark') }}
@endsection

@section('css')
<style>
    :root{
        --tm-surface: #f4f6f8;
        --tm-panel: #ffffff;
        --tm-panel-soft: #fafafa;
        --tm-ink: #20242a;
        --tm-muted: #626a73;
        --tm-line: #cfd5dd;
        --tm-line-dark: #1f2933;
        --tm-accent: #2f6f5e;
        --tm-accent-soft: #dff2e6;
    }

    body{ background: var(--tm-surface); }

    .tm-page{
        max-width: 1320px;
        margin: 0 auto;
        padding-bottom: 4rem;
    }

    .tm-file-shell{
        background: var(--tm-panel);
        border: 1px solid var(--tm-line);
        border-radius: 8px;
        padding: 1.7rem;
    }

    .tm-header{
        background: var(--tm-panel-soft);
        border: 1px solid var(--tm-line);
        border-radius: 8px;
        padding: 1.25rem 1.35rem;
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 1rem;
        align-items: start;
    }

    .tm-kicker{
        color: var(--tm-muted);
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .tm-title{
        margin: .35rem 0 0;
        color: var(--tm-ink);
        font-size: clamp(2rem, 4vw, 3rem);
        line-height: 1;
        font-weight: 800;
        letter-spacing: 0;
        text-transform: uppercase;
    }

    .tm-subtitle{
        margin: .55rem 0 0;
        color: var(--tm-muted);
        font-size: .98rem;
    }

    .tm-toolbar{
        display: flex;
        gap: .55rem;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .tm-btn{
        min-height: 38px;
        border: 1px solid var(--tm-line-dark);
        border-radius: 4px;
        padding: 0 .95rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--tm-line-dark);
        background: transparent;
        text-decoration: none;
        font-weight: 700;
    }

    .tm-btn-save{
        background: var(--tm-line-dark);
        color: #fff;
    }

    .tm-btn:hover{
        border-color: var(--tm-accent);
        color: var(--tm-accent);
        background: #fff;
    }

    .tm-section{ margin-top: 2rem; }

    .tm-section-heading{
        margin: 0 0 1rem;
        color: #111827;
        font-size: 1.02rem;
        font-weight: 800;
        letter-spacing: 0;
        text-transform: uppercase;
    }

    .tm-section-heading span{
        font-weight: 500;
        padding-right: .45rem;
    }

    .tm-field-grid{
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem 1.6rem;
    }

    .tm-field-grid.is-single{ grid-template-columns: 1fr; }

    .tm-field{
        min-height: 42px;
        border: 1px solid var(--tm-line-dark);
        background: #fff;
        display: grid;
        grid-template-columns: minmax(142px, 38%) minmax(0, 1fr);
        align-items: stretch;
    }

    .tm-field.is-full{ grid-column: 1 / -1; }
    .tm-field.is-tall{ min-height: 112px; }
    .tm-field.is-logo{ min-height: 172px; }

    .tm-label{
        margin: 0;
        padding: .48rem .65rem;
        border-right: 1px solid var(--tm-line-dark);
        color: #151a20;
        font-size: .94rem;
        font-weight: 600;
        line-height: 1.25;
        text-align: right;
        display: flex;
        align-items: flex-start;
        justify-content: flex-end;
    }

    .tm-control{
        position: relative;
        min-width: 0;
        display: flex;
        align-items: stretch;
    }

    .tm-input,
    .tm-select,
    .select2-container--default .select2-selection--single{
        width: 100%;
        min-height: 40px;
        border: 0 !important;
        border-radius: 0 !important;
        background: transparent !important;
        color: var(--tm-ink);
        padding: .45rem .65rem;
        font-size: .95rem;
        line-height: 1.35;
        box-shadow: none !important;
    }

    textarea.tm-input{
        min-height: 100%;
        resize: vertical;
    }

    .tm-input:focus,
    .tm-select:focus{
        outline: 2px solid rgba(47, 111, 94, .22);
        outline-offset: -2px;
        box-shadow: none !important;
    }

    .tm-select:disabled,
    .tm-input:disabled{
        color: var(--tm-muted);
        opacity: 1;
    }

    .select2-container{ width: 100% !important; }

    .select2-container--default .select2-selection--single .select2-selection__rendered{
        color: var(--tm-ink);
        line-height: 28px;
        padding-left: 0;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow{
        height: 38px;
    }

    .tm-logo-control{
        display: grid;
        grid-template-columns: minmax(0, 1fr) 150px;
        gap: .75rem;
        align-items: center;
        width: 100%;
        padding: .7rem;
    }

    .tm-logo-control .tm-input{
        border: 1px solid var(--tm-line) !important;
        min-height: 42px;
        padding: .35rem;
    }

    .tm-preview-wrap{
        height: 138px;
        border: 1px solid var(--tm-line);
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .tm-preview-image{
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .d-none{ display: none !important; }

    @media (max-width: 991.98px){
        .tm-file-shell{ padding: 1rem; }
        .tm-header{ grid-template-columns: 1fr; }
        .tm-toolbar{ justify-content: flex-start; }
        .tm-field-grid{
            grid-template-columns: 1fr;
            gap: .85rem;
        }
    }

    @media (max-width: 575.98px){
        .tm-field{ grid-template-columns: 1fr; }
        .tm-label{
            border-right: 0;
            border-bottom: 1px solid var(--tm-line-dark);
            justify-content: flex-start;
            text-align: left;
        }
        .tm-logo-control{ grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
@php
    $nextOurRef = $trademark === null
        ? '10000'
        : (string) max(10000, ((int) $trademark->our_ref) + 1);

    $oldSelected = function ($field, $value, $default = null) {
        return (string) old($field, $default) === (string) $value ? 'selected' : '';
    };
@endphp

<div class="container-fluid mt-3 tm-page">
    <form method="POST"
          action="{{ route('store.trademarks') }}"
          enctype="multipart/form-data"
          role="form"
          id="trademarkForm"
          novalidate>
        @csrf

        <div class="tm-file-shell">
            <header class="tm-header">
                <div>
                    <div class="tm-kicker">Legal trademark file</div>
                    <h1 class="tm-title">{{ __('messages.new_trademark') }}</h1>
                    <p class="tm-subtitle">{{ __('messages.new_trademark') }}</p>
                </div>

                <div class="tm-toolbar">
                    <a class="tm-btn" href="javascript:history.back()">{{ __('messages.back') }}</a>
                    <button type="submit" class="tm-btn tm-btn-save">{{ __('messages.save') }}</button>
                </div>
            </header>

            <div class="mt-3">
                @includeif('partials.errors')
            </div>

            <section class="tm-section" id="references">
                <h2 class="tm-section-heading"><span>01 |</span> References</h2>
                <div class="tm-field-grid">
                    <div class="tm-field">
                        <label class="tm-label" for="our_ref">{{ __('messages.our_ref') }}</label>
                        <div class="tm-control">
                            <input id="our_ref" name="our_ref" class="form-control tm-input" type="text" inputmode="numeric" maxlength="5" pattern="[1-9][0-9]{0,4}" value="{{ old('our_ref', $nextOurRef) }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="client_ref">{{ __('messages.client_ref') }}</label>
                        <div class="tm-control">
                            <input id="client_ref" name="client_ref" class="form-control tm-input" type="text" maxlength="20" value="{{ old('client_ref') }}">
                        </div>
                    </div>
                </div>
            </section>

            <section class="tm-section" id="general">
                <h2 class="tm-section-heading"><span>02 |</span> General</h2>
                <div class="tm-field-grid">
                    <div class="tm-field">
                        <label class="tm-label" for="application_no">{{ __('messages.application_no') }}</label>
                        <div class="tm-control">
                            <input id="application_no" name="application_no" class="form-control tm-input" type="text" inputmode="numeric" maxlength="10" pattern="[1-9][0-9]{0,9}" value="{{ old('application_no') }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="int_registration_no">Int'l Registration No.</label>
                        <div class="tm-control">
                            <input id="int_registration_no" name="int_registration_no" class="form-control tm-input" type="text" value="{{ old('int_registration_no') }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="registration_no">{{ __('messages.registration_no') }}</label>
                        <div class="tm-control">
                            <input id="registration_no" name="registration_no" class="form-control tm-input" type="text" inputmode="numeric" maxlength="10" pattern="[1-9][0-9]{0,9}" value="{{ old('registration_no') }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="int_registration_date">Int'l Registration Date</label>
                        <div class="tm-control">
                            <input id="int_registration_date" name="int_registration_date" class="form-control tm-input date-mask" type="date" value="{{ old('int_registration_date') }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="filing_date_general">{{ __('messages.filing_date') }}</label>
                        <div class="tm-control">
                            <input id="filing_date_general" name="filing_date_general" class="form-control tm-input date-mask" type="date" value="{{ old('filing_date_general') }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="contracting_organization">Contracting State or Organization</label>
                        <div class="tm-control">
                            <select class="form-control tm-select js-example-basic-single" name="contracting_organization" id="contracting_organization">
                                <option value="">{{ __('messages.select') }}</option>
                                @include('client.paises')
                            </select>
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="registrationDate">{{ __('messages.registration_date') }}</label>
                        <div class="tm-control">
                            <input id="registrationDate" name="registration_date" class="form-control tm-input date-mask" type="date" value="{{ old('registration_date') }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="designated_countries">Designated Countries</label>
                        <div class="tm-control">
                            <textarea class="form-control tm-input" id="designated_countries" name="designated_countries" rows="2">{{ old('designated_countries') }}</textarea>
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="expirationDate">{{ __('messages.expiration_date') }}</label>
                        <div class="tm-control">
                            <input id="expirationDate" name="expiration_date" class="form-control tm-input date-mask" type="date" value="{{ old('expiration_date') }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="country_office">{{ __('messages.country_office') }}</label>
                        <div class="tm-control">
                            <select class="form-control tm-select" name="country_office" id="country_office">
                                <option value="">{{ __('messages.select') }}</option>
                                @include('client.paises')
                            </select>
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="first_date">{{ __('messages.first_date') }}</label>
                        <div class="tm-control">
                            <input id="first_date" name="first_date" class="form-control tm-input date-mask" type="date" value="{{ old('first_date') }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="priority_date">{{ __('messages.priority_date') }}</label>
                        <div class="tm-control">
                            <input id="priority_date" name="priority_date" class="form-control tm-input date-mask" type="date" value="{{ old('priority_date') }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="status">{{ __('messages.status') }}</label>
                        <div class="tm-control">
                            <select class="form-control tm-select" id="status" name="status">
                                <option value="{{ __('messages.registered') }}" {{ $oldSelected('status', __('messages.registered'), __('messages.registered')) }}>{{ __('messages.registered') }}</option>
                                <option value="{{ __('messages.pending') }}" {{ $oldSelected('status', __('messages.pending')) }}>{{ __('messages.pending') }}</option>
                                <option value="{{ __('messages.abandoned') }}" {{ $oldSelected('status', __('messages.abandoned')) }}>{{ __('messages.abandoned') }}</option>
                                <option value="{{ __('messages.lapsed') }}" {{ $oldSelected('status', __('messages.lapsed')) }}>{{ __('messages.lapsed') }}</option>
                                <option value="{{ __('messages.inactive') }}" {{ $oldSelected('status', __('messages.inactive')) }}>{{ __('messages.inactive') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="priority_no">{{ __('messages.priority_no') }}</label>
                        <div class="tm-control">
                            <input id="priority_no" name="priority_no" class="form-control tm-input" type="text" value="{{ old('priority_no') }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="country">Country</label>
                        <div class="tm-control">
                            <select class="form-control tm-select js-example-basic-single" name="country" id="country">
                                <option value="MEXICO" {{ $oldSelected('country', 'MEXICO', 'MEXICO') }}>MEXICO</option>
                                @include('client.paises')
                            </select>
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="origin">Origin</label>
                        <div class="tm-control">
                            <select class="form-control tm-select" name="origin" id="origin">
                                <option value="-" {{ $oldSelected('origin', '-', '-') }}>-</option>
                                <option value="Nacional" {{ $oldSelected('origin', 'Nacional') }}>Nacional</option>
                                <option value="Extranjero" {{ $oldSelected('origin', 'Extranjero') }}>Extranjero</option>
                            </select>
                        </div>
                    </div>
                </div>
            </section>

            <section class="tm-section" id="trademark-section">
                <h2 class="tm-section-heading"><span>03 |</span> Trademark</h2>
                <div class="tm-field-grid">
                    <div class="tm-field">
                        <label class="tm-label" for="trademark">{{ __('messages.trademark') }}</label>
                        <div class="tm-control">
                            <input id="trademark" name="trademark" class="form-control tm-input" type="text" maxlength="250" value="{{ old('trademark') }}">
                        </div>
                    </div>

                    <div class="tm-field is-logo" id="representationLogoField">
                        <label class="tm-label" for="design">Representation / Logo</label>
                        <div class="tm-logo-control">
                            <input id="design" name="design" class="form-control tm-input" type="file" accept=".jpg,.jpeg,.png,.webp,.gif,image/*">
                            <div class="tm-preview-wrap" id="representationLogoPreview">
                                <img id="blah" class="tm-preview-image" src="{{ asset('design/no-image.jpg') }}" alt="Trademark design preview">
                            </div>
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="type_application">Type of Application</label>
                        <div class="tm-control">
                            <select class="form-control tm-select" id="type_application" name="type_application">
                                <option value="">{{ __('messages.select') }}</option>
                                <option value="Trademark" {{ $oldSelected('type_application', 'Trademark') }}>Trademark</option>
                                <option value="Commercial Name" {{ $oldSelected('type_application', 'Commercial Name') }}>Commercial Name</option>
                                <option value="Slogan" {{ $oldSelected('type_application', 'Slogan') }}>Slogan</option>
                                <option value="Collective Mark" {{ $oldSelected('type_application', 'Collective Mark') }}>Collective Mark</option>
                                <option value="Certification Mark" {{ $oldSelected('type_application', 'Certification Mark') }}>Certification Mark</option>
                            </select>
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="type_mark">Type of Mark</label>
                        <div class="tm-control">
                            <select class="form-control tm-select" id="type_mark" name="type_mark">
                                <option value="">{{ __('messages.select') }}</option>
                                <option value="Word Mark" {{ $oldSelected('type_mark', 'Word Mark') }}>Word Mark</option>
                                <option value="Design Mark" {{ $oldSelected('type_mark', 'Design Mark') }}>Design Mark</option>
                                <option value="Mixed Mark" {{ $oldSelected('type_mark', 'Mixed Mark') }}>Mixed Mark</option>
                                <option value="Three-Dimensional Mark" {{ $oldSelected('type_mark', 'Three-Dimensional Mark') }}>Three-Dimensional Mark</option>
                                <option value="Holographic Mark" {{ $oldSelected('type_mark', 'Holographic Mark') }}>Holographic Mark</option>
                                <option value="Sound Mark" {{ $oldSelected('type_mark', 'Sound Mark') }}>Sound Mark</option>
                                <option value="Scent Mark" {{ $oldSelected('type_mark', 'Scent Mark') }}>Scent Mark</option>
                                <option value="Trade Dress" {{ $oldSelected('type_mark', 'Trade Dress') }}>Trade Dress</option>
                                <option value="Other" {{ $oldSelected('type_mark', 'Other') }}>Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="tm-field is-tall" id="descriptionMarkField">
                        <label class="tm-label" for="description_trademark">Description of the Mark</label>
                        <div class="tm-control">
                            <textarea class="form-control tm-input" id="description_trademark" name="description_trademark" rows="4">{{ old('description_trademark') }}</textarea>
                        </div>
                    </div>

                    <div class="tm-field is-tall">
                        <label class="tm-label" for="translation">{{ __('messages.translation') }}</label>
                        <div class="tm-control">
                            <textarea class="form-control tm-input" id="translation" name="translation" rows="4">{{ old('translation') }}</textarea>
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="transliteration_trademark">{{ __('messages.transliteration') }}</label>
                        <div class="tm-control">
                            <textarea class="form-control tm-input" id="transliteration_trademark" name="transliteration_trademark" rows="2">{{ old('transliteration_trademark') }}</textarea>
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="disclaimer">Disclaimer</label>
                        <div class="tm-control">
                            <textarea class="form-control tm-input" id="disclaimer" name="disclaimer" rows="2">{{ old('disclaimer') }}</textarea>
                        </div>
                    </div>
                </div>
            </section>

            <section class="tm-section" id="accounts">
                <h2 class="tm-section-heading"><span>04 |</span> Goods / Services</h2>
                <div class="tm-field-grid is-single">
                    <div class="tm-field">
                        <label class="tm-label" for="class">{{ __('messages.class') }}</label>
                        <div class="tm-control">
                            <select class="form-control tm-select" id="class" name="class">
                                <option value="">{{ __('messages.select') }}</option>
                                @for ($i = 1; $i <= 45; $i++)
                                    @php($classValue = str_pad($i, 2, '0', STR_PAD_LEFT))
                                    <option value="{{ $classValue }}" {{ $oldSelected('class', $classValue) }}>{{ $classValue }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="tm-field is-tall">
                        <label class="tm-label" for="description_good">{{ __('messages.description') }}</label>
                        <div class="tm-control">
                            <textarea class="form-control tm-input" id="description_good" name="description_good" rows="5">{{ old('description_good') }}</textarea>
                        </div>
                    </div>

                    <div class="tm-field is-tall">
                        <label class="tm-label" for="translation_good">{{ __('messages.translation') }}</label>
                        <div class="tm-control">
                            <textarea class="form-control tm-input" id="translation_good" name="translation_good" rows="4">{{ old('translation_good') }}</textarea>
                        </div>
                    </div>
                </div>
            </section>

            <section class="tm-section" id="holder">
                <h2 class="tm-section-heading"><span>05 |</span> Owner</h2>
                <div class="tm-field-grid">
                    <div class="tm-field">
                        <label class="tm-label" for="id_holder">{{ __('messages.holder') }}</label>
                        <div class="tm-control">
                            <select class="form-control tm-select js-example-basic-single" id="id_holder" name="id_holder">
                                <option value="">{{ __('messages.holder') }}</option>
                                @foreach ($holders as $holder)
                                    <option value="{{ $holder->id }}" {{ $oldSelected('id_holder', $holder->id) }}>{{ $holder->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="tm-field is-tall">
                        <label class="tm-label" for="industrial_address">{{ __('messages.industrial_address') }}</label>
                        <div class="tm-control">
                            <select class="form-control tm-select" name="industrial_address" id="industrial_address">
                                <option value="">Seleccione Industrial / Commercial Address</option>
                            </select>
                        </div>
                    </div>

                    <div class="tm-field is-tall">
                        <label class="tm-label" for="address_holder">{{ __('messages.address') }}</label>
                        <div class="tm-control">
                            <select class="form-control tm-select" name="address_holder" id="address_holder">
                                <option value="">{{ __('messages.select') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </section>

            <section class="tm-section" id="sessions">
                <h2 class="tm-section-heading"><span>06 |</span> Client</h2>
                <div class="tm-field-grid">
                    <div class="tm-field">
                        <label class="tm-label" for="id_client">{{ __('messages.client') }}</label>
                        <div class="tm-control">
                            <select class="form-control tm-select js-example-basic-single" id="id_client" name="id_client">
                                <option value="">{{ __('messages.client') }}</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}" {{ $oldSelected('id_client', $client->id) }}>{{ $client->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="invoice_recipient_preview">Invoice Recipient</label>
                        <div class="tm-control">
                            <input id="invoice_recipient_preview" class="form-control tm-input" type="text" disabled>
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="id_contact">{{ __('messages.contact') }}</label>
                        <div class="tm-control">
                            <select class="form-control tm-select" name="id_contact" id="id_contact">
                                <option value="">{{ __('messages.select') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="client_contact_email">{{ __('messages.email') }}</label>
                        <div class="tm-control">
                            <input id="client_contact_email" class="form-control tm-input" type="text" disabled>
                        </div>
                    </div>

                    <div class="tm-field is-tall">
                        <label class="tm-label" for="id_address">{{ __('messages.address') }}</label>
                        <div class="tm-control">
                            <select class="form-control tm-select" name="id_address" id="id_address">
                                <option value="">{{ __('messages.select') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="tm-field is-tall">
                        <label class="tm-label" for="billing_address_preview">{{ __('messages.billing_address') }}</label>
                        <div class="tm-control">
                            <select class="form-control tm-select" id="billing_address_preview" disabled>
                                <option value="">{{ __('messages.select') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </section>

            <section class="tm-section" id="dates-deadlines">
                <h2 class="tm-section-heading"><span>07 |</span> Dates and Deadlines</h2>
                <div class="tm-field-grid">
                    <div class="tm-field">
                        <label class="tm-label" for="publication_date">{{ __('messages.publication_date') }}</label>
                        <div class="tm-control">
                            <input id="publication_date" name="publication_date" class="form-control tm-input date-mask" type="date" value="{{ old('publication_date') }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="filing_date_opposition">Opposition Date</label>
                        <div class="tm-control">
                            <input id="filing_date_opposition" name="filing_date_opposition" class="form-control tm-input date-mask" type="date" value="{{ old('filing_date_opposition') }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="opposition_no">{{ __('messages.opposition_no') }}</label>
                        <div class="tm-control">
                            <input id="opposition_no" name="opposition_no" class="form-control tm-input" type="text" value="{{ old('opposition_no') }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="filing_date_litigation">Office Action Date</label>
                        <div class="tm-control">
                            <input id="filing_date_litigation" name="filing_date_litigation" class="form-control tm-input date-mask" type="date" value="{{ old('filing_date_litigation') }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="litigation_no">{{ __('messages.litigation_no') }}</label>
                        <div class="tm-control">
                            <input id="litigation_no" name="litigation_no" class="form-control tm-input" type="text" value="{{ old('litigation_no') }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="lastDeclarationDate">{{ __('messages.declarations_use') }} - {{ __('messages.last') }}</label>
                        <div class="tm-control">
                            <input id="lastDeclarationDate" name="last_declaration" class="form-control tm-input date-mask" type="date" value="{{ old('last_declaration') }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="declarationOfUseDate">{{ __('messages.declarations_use') }} - {{ __('messages.next') }}</label>
                        <div class="tm-control">
                            <input id="declarationOfUseDate" name="next_declaration" class="form-control tm-input date-mask" type="date" value="{{ old('next_declaration') }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="lastRenewalsDate">{{ __('messages.renewals') }} - {{ __('messages.last') }}</label>
                        <div class="tm-control">
                            <input id="lastRenewalsDate" name="last_renewal" class="form-control tm-input date-mask" type="date" value="{{ old('last_renewal') }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="renewalDate">{{ __('messages.renewals') }} - {{ __('messages.next') }}</label>
                        <div class="tm-control">
                            <input id="renewalDate" name="next_renewal" class="form-control tm-input date-mask" type="date" value="{{ old('next_renewal') }}">
                        </div>
                    </div>
                </div>
            </section>

            <section class="tm-section" id="notes">
                <h2 class="tm-section-heading"><span>08 |</span> Notes</h2>
                <div class="tm-field-grid is-single">
                    <div class="tm-field is-tall">
                        <label class="tm-label" for="notes_text">{{ __('messages.note') }}</label>
                        <div class="tm-control">
                            <textarea class="form-control tm-input" id="notes_text" name="notes" rows="5">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
            </section>
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

    setSelectedOptionIfExists('country', @json(old('country', 'MEXICO')));
    setSelectedOptionIfExists('country_office', @json(old('country_office')));
    setSelectedOptionIfExists('contracting_organization', @json(old('contracting_organization')));
})();
</script>

<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>

<script>
(function () {
    const typeApplication = document.getElementById('type_application');
    const typeMark = document.getElementById('type_mark');
    const descriptionField = document.getElementById('descriptionMarkField');
    const descriptionTypes = new Set(['Holographic Mark', 'Sound Mark', 'Scent Mark', 'Trade Dress', 'Other']);

    function syncTrademarkConditionalFields() {
        const value = typeMark?.value || '';
        if (descriptionField) {
            descriptionField.classList.toggle('d-none', !descriptionTypes.has(value));
        }
    }

    function syncTypeApplicationMark() {
        if (!typeApplication || !typeMark) return;

        if (['Commercial Name', 'Slogan'].includes(typeApplication.value)) {
            typeMark.value = 'Word Mark';
            typeMark.dispatchEvent(new Event('change', { bubbles: true }));
        }
    }

    typeApplication?.addEventListener('change', syncTypeApplicationMark);
    typeMark?.addEventListener('change', syncTrademarkConditionalFields);
    syncTypeApplicationMark();
    syncTrademarkConditionalFields();
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
    function syncClientPreview() {
        const select = document.getElementById('id_client');
        const invoicePreview = document.getElementById('invoice_recipient_preview');
        if (!select || !invoicePreview) return;
        invoicePreview.value = select.selectedOptions[0]?.textContent?.trim() || '';
    }

    function syncSelectedClientDetails() {
        const contactSelect = document.getElementById('id_contact');
        const emailInput = document.getElementById('client_contact_email');
        const addressSelect = document.getElementById('id_address');
        const billingSelect = document.getElementById('billing_address_preview');

        if (contactSelect && emailInput) {
            emailInput.value = contactSelect.selectedOptions[0]?.dataset.email || '';
        }

        if (addressSelect && billingSelect) {
            const billing = addressSelect.selectedOptions[0]?.dataset.billing || '';
            billingSelect.innerHTML = `<option value="">${billing || @json(__('messages.select'))}</option>`;
        }
    }

    function loadClientContacts(id) {
        $('#id_contact').empty().append(`<option value="" selected>Loading...</option>`);
        $('#client_contact_email').val('');

        $.ajax({
            type: 'GET',
            url: '{{ url("/trademarks/crear") }}/' + id,
            success: function (response) {
                const data = typeof response === 'string' ? JSON.parse(response) : response;
                $('#id_contact').empty().append(`<option value="">{{ __('messages.select') }}</option>`);
                data.forEach(element => {
                    $('#id_contact').append(`<option value="${element.id}" data-email="${element.email ?? ''}">${element.name}</option>`);
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
                    $('#id_address').append(`<option value="${element.id}" data-billing="${element.billing_address ?? ''}">${element.address ?? ''}</option>`);
                });
            }
        });
    }

    function loadHolderAddresses(id) {
        $('#address_holder').empty().append(`<option value="" selected>Loading...</option>`);

        $.ajax({
            type: 'GET',
            url: '{{ url("/trademarks/holder") }}/' + id,
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
            url: '{{ url("/trademarks/holder/industrial") }}/' + id,
            success: function (response) {
                const data = typeof response === 'string' ? JSON.parse(response) : response;
                $('#industrial_address').empty().append(`<option value="">{{ __('messages.select') }}</option>`);
                data.forEach(element => {
                    $('#industrial_address').append(`<option value="${element.commercial_address}">${element.commercial_address}</option>`);
                });
            }
        });
    }

    $('#id_client').on('change', function () {
        const id = $(this).val();
        syncClientPreview();

        if (!id) {
            $('#id_contact').empty().append(`<option value="">{{ __('messages.select') }}</option>`);
            $('#id_address').empty().append(`<option value="">{{ __('messages.select') }}</option>`);
            $('#billing_address_preview').empty().append(`<option value="">{{ __('messages.select') }}</option>`);
            $('#client_contact_email').val('');
            return;
        }

        loadClientContacts(id);
        loadClientAddresses(id);
    });

    $('#id_holder').on('change', function () {
        const id = $(this).val();

        if (!id) {
            $('#address_holder').empty().append(`<option value="">{{ __('messages.select') }}</option>`);
            $('#industrial_address').empty().append(`<option value="">{{ __('messages.select') }}</option>`);
            return;
        }

        loadHolderAddresses(id);
        loadHolderIndustrialAddresses(id);
    });

    document.getElementById('id_contact')?.addEventListener('change', syncSelectedClientDetails);
    document.getElementById('id_address')?.addEventListener('change', syncSelectedClientDetails);
    syncClientPreview();
    syncSelectedClientDetails();
})();
</script>

<script>
$(document).ready(function() {
    function formatDate(date) {
        let year = date.getFullYear();
        let month = String(date.getMonth() + 1).padStart(2, '0');
        let day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

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
});
</script>

<script>
(function () {
    const form = document.getElementById('trademarkForm');
    if (!form) return;

    const requiredFields = [];

    function clearInvalid(el) {
        if (!el) return;
        el.classList.remove('is-invalid');
        const wrapper = el.closest('.tm-control') || el.parentElement;
        const feedback = wrapper?.querySelector('.invalid-feedback.dynamic-feedback');
        if (feedback) feedback.remove();
    }

    function markInvalid(el, message) {
        if (!el) return;
        el.classList.add('is-invalid');
        const wrapper = el.closest('.tm-control') || el.parentElement;
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

    function validateReferenceFields(errors) {
        const ourRef = document.getElementById('our_ref');
        const clientRef = document.getElementById('client_ref');
        const ourRefValue = String(ourRef?.value || '').trim();
        const clientRefValue = String(clientRef?.value || '').trim();

        clearInvalid(ourRef);
        clearInvalid(clientRef);

        if (ourRefValue && !/^[1-9][0-9]{0,4}$/.test(ourRefValue)) {
            markInvalid(ourRef, 'O/Ref. allows up to 5 digits and cannot start with 0.');
            errors.push('O/Ref.');
        }

        if (clientRefValue && !/^[A-Za-z0-9 ]{1,20}$/.test(clientRefValue)) {
            markInvalid(clientRef, 'C/Ref. only allows letters, numbers and spaces, up to 20 characters.');
            errors.push('C/Ref.');
        }
    }

    function validateStructuralNumberFields(errors) {
        [
            { id: 'application_no', label: 'Application No.' },
            { id: 'registration_no', label: 'Registration No.' }
        ].forEach(field => {
            const el = document.getElementById(field.id);
            const value = String(el?.value || '').trim();
            clearInvalid(el);

            if (value && !/^[1-9][0-9]{0,9}$/.test(value)) {
                markInvalid(el, `${field.label} allows up to 10 digits and cannot start with 0.`);
                errors.push(field.label);
            }
        });
    }

    ['application_no', 'registration_no'].forEach(id => {
        document.getElementById(id)?.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').replace(/^0+/, '').slice(0, 10);
        });
    });

    document.getElementById('our_ref')?.addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 5);
    });

    document.getElementById('client_ref')?.addEventListener('input', function () {
        this.value = this.value.replace(/[^A-Za-z0-9 ]/g, '').slice(0, 20);
    });

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

        validateReferenceFields(errors);
        validateStructuralNumberFields(errors);

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
        }
    });

    form.querySelectorAll('input, select, textarea').forEach(el => {
        el.addEventListener('input', () => clearInvalid(el));
        el.addEventListener('change', () => clearInvalid(el));
    });
})();
</script>
@endsection
