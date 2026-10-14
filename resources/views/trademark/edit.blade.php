@extends('layouts.app')

@section('template_title')
    {{ __('messages.edit_trademark') }}
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

    .tm-title-line{
        display: flex;
        flex-wrap: wrap;
        gap: .7rem;
        align-items: center;
        margin-bottom: .45rem;
    }

    .tm-title{
        margin: 0;
        color: var(--tm-ink);
        font-size: clamp(2rem, 4vw, 3rem);
        line-height: 1;
        font-weight: 800;
        letter-spacing: 0;
        text-transform: uppercase;
    }

    .tm-status-pill{
        background: var(--tm-accent-soft);
        color: var(--tm-accent);
        border-radius: 999px;
        padding: .25rem .75rem;
        font-size: .82rem;
        font-weight: 700;
    }

    .tm-header-meta{
        display: grid;
        gap: .22rem;
        color: var(--tm-ink);
        font-size: 1rem;
    }

    .tm-header-muted{ color: var(--tm-muted); }

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
    .tm-select{
        width: 100%;
        min-height: 40px;
        border: 0;
        border-radius: 0;
        background: transparent;
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

    .tm-input:disabled,
    .tm-select:disabled{
        color: var(--tm-muted);
        opacity: 1;
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
        border: 1px solid var(--tm-line);
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

    .autocomplete-wrap{ position: relative; }

    .autocomplete-box{
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        right: 0;
        z-index: 1055;
        background: #fff;
        border: 1px solid var(--tm-line);
        border-radius: 4px;
        box-shadow: 0 14px 30px rgba(15, 23, 42, .13);
        max-height: 260px;
        overflow-y: auto;
        padding: 6px;
    }

    .autocomplete-item{
        padding: 10px 12px;
        border-radius: 3px;
        cursor: pointer;
        transition: background-color .15s ease;
    }

    .autocomplete-item:hover{ background: rgba(47, 111, 94, .1); }

    .autocomplete-title{
        display: block;
        color: var(--tm-ink);
        font-weight: 700;
    }

    .autocomplete-subtitle{
        display: block;
        color: var(--tm-muted);
        font-size: .85rem;
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
<div class="container-fluid mt-3 tm-page tm-compact-file">
    @php
        $dateValue = function ($field) use ($trademark) {
            $value = old($field, $trademark->{$field});

            if (!filled($value)) {
                return '';
            }

            try {
                return \Carbon\Carbon::parse($value)->format('Y-m-d');
            } catch (\Throwable $e) {
                return $value;
            }
        };

    @endphp

    <form method="POST"
          action="{{ route('update.trademarks', $trademark->id) }}"
          enctype="multipart/form-data"
          id="trademarkEditForm"
          novalidate>
        @csrf
        @method('PATCH')

        <div class="tm-toolbar tm-page-actions" aria-label="File actions">
            <a class="tm-btn" href="{{ route('index.trademarks') }}">{{ __('messages.back') }}</a>
            <button type="submit" class="tm-btn tm-btn-save">{{ __('messages.update') }}</button>
        </div>
        <div class="tm-file-shell">
            @include('trademark._header', ['isNewFile' => false])

            <div class="mt-3">
                @includeIf('partials.errors')
            </div>

            <section class="tm-section" id="references">
                <h2 class="tm-section-heading"><span>01 |</span> References</h2>
                <div class="tm-split-tables">
                    <div class="tm-field-column">
                        <div class="tm-field">
                            <label class="tm-label" for="our_ref">{{ __('messages.our_ref') }}</label>
                            <div class="tm-control">
                                <input id="our_ref" name="our_ref" class="form-control tm-input" type="text" inputmode="numeric" maxlength="5" pattern="[1-9][0-9]{0,4}" value="{{ old('our_ref', $trademark->our_ref) }}">
                            </div>
                        </div>

                        <div class="tm-field autocomplete-wrap">
                            <label class="tm-label" for="client_ref">{{ __('messages.client_ref') }}</label>
                            <div class="tm-control">
                                <input id="client_ref" name="client_ref" class="form-control tm-input" type="text" maxlength="20" autocomplete="off" value="{{ old('client_ref', $trademark->client_ref) }}">
                                <div id="client_ref_suggestions" class="autocomplete-box d-none"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tm-field-column">
                        <div class="tm-field">
                            <label class="tm-label" for="origin">Department</label>
                            <div class="tm-control">
                                <select class="form-control tm-select" name="origin" id="origin">
                                    @include('trademark._origin-options', ['currentOrigin' => old('origin', $trademark->origin)])
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="tm-section" id="general">
                <h2 class="tm-section-heading"><span>02 |</span> General</h2>
                <div class="tm-split-tables">
                    <div class="tm-field-column">
                        <div class="tm-field">
                            <label class="tm-label" for="application_no">{{ __('messages.application_no') }}</label>
                            <div class="tm-control">
                                <input id="application_no" name="application_no" class="form-control tm-input" type="text" inputmode="numeric" maxlength="10" pattern="[1-9][0-9]{0,9}" value="{{ old('application_no', $trademark->application_no) }}">
                            </div>
                        </div>

                        <div class="tm-field">
                            <label class="tm-label" for="filing_date_general">{{ __('messages.filing_date') }}</label>
                            <div class="tm-control">
                                <input id="filing_date_general" name="filing_date_general" class="form-control tm-input date-mask" type="date" value="{{ $dateValue('filing_date_general') }}">
                            </div>
                        </div>

                        <div class="tm-field">
                            <label class="tm-label" for="registration_no">{{ __('messages.registration_no') }}</label>
                            <div class="tm-control">
                                <input id="registration_no" name="registration_no" class="form-control tm-input" type="text" inputmode="numeric" maxlength="10" pattern="[1-9][0-9]{0,9}" value="{{ old('registration_no', $trademark->registration_no) }}">
                            </div>
                        </div>

                        <div class="tm-field">
                            <label class="tm-label" for="registrationDate">{{ __('messages.registration_date') }}</label>
                            <div class="tm-control">
                                <input id="registrationDate" name="registration_date" class="form-control tm-input date-mask" type="date" value="{{ $dateValue('registration_date') }}">
                            </div>
                        </div>

                        <div class="tm-field">
                            <label class="tm-label" for="first_date">{{ __('messages.first_date') }}</label>
                            <div class="tm-control">
                                <input id="first_date" name="first_date" class="form-control tm-input date-mask" type="date" value="{{ $dateValue('first_date') }}">
                            </div>
                        </div>

                        <div class="tm-field">
                            <label class="tm-label" for="expirationDate">{{ __('messages.expiration_date') }}</label>
                            <div class="tm-control">
                                <input id="expirationDate" name="expiration_date" class="form-control tm-input date-mask" type="date" value="{{ $dateValue('expiration_date') }}">
                            </div>
                        </div>

                        <div class="tm-field">
                            <label class="tm-label" for="status">{{ __('messages.status') }}</label>
                            <div class="tm-control">
                                <select class="form-control tm-select" id="status" name="status">
                                    @include('trademark._status-options', ['currentStatus' => old('status', $trademark->status)])
                                </select>
                            </div>
                        </div>

                        <div class="tm-field">
                            <label class="tm-label" for="country">Country / Office</label>
                            <div class="tm-control">
                                <select class="form-control tm-select js-example-basic-single" name="country" id="country">
                                    @include('trademark._country-options', ['currentCountry' => old('country', $trademark->country ?: 'Mexico')])
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="tm-field-column">
                        <div class="tm-field">
                            <label class="tm-label" for="priority_no">Priority Application No.</label>
                            <div class="tm-control">
                                <input id="priority_no" name="priority_no" class="form-control tm-input" type="text" value="{{ old('priority_no', $trademark->priority_no) }}">
                            </div>
                        </div>

                        <div class="tm-field">
                            <label class="tm-label" for="priority_date">{{ __('messages.priority_date') }}</label>
                            <div class="tm-control">
                                <input id="priority_date" name="priority_date" class="form-control tm-input date-mask" type="date" value="{{ $dateValue('priority_date') }}">
                            </div>
                        </div>

                        <div class="tm-field">
                            <label class="tm-label" for="country_office">Priority Country / Office</label>
                            <div class="tm-control">
                                <select class="form-control tm-select" name="country_office" id="country_office">
                                    @include('trademark._country-options', ['currentCountry' => old('country_office', $trademark->country_office)])
                                </select>
                            </div>
                        </div>

                        <div class="tm-field">
                            <label class="tm-label" for="int_registration_no">Int'l Registration No.</label>
                            <div class="tm-control">
                                <input id="int_registration_no" name="int_registration_no" class="form-control tm-input" type="text" value="{{ old('int_registration_no', $trademark->int_registration_no) }}">
                            </div>
                        </div>

                        <div class="tm-field">
                            <label class="tm-label" for="int_registration_date">Int'l Registration Date</label>
                            <div class="tm-control">
                                <input id="int_registration_date" name="int_registration_date" class="form-control tm-input date-mask" type="date" value="{{ $dateValue('int_registration_date') }}">
                            </div>
                        </div>

                        <div class="tm-field">
                            <label class="tm-label" for="contracting_organization">Contracting Party</label>
                            <div class="tm-control">
                                <select class="form-control tm-select js-example-basic-single" name="contracting_organization" id="contracting_organization">
                                    @include('trademark._country-options', ['currentCountry' => old('contracting_organization', $trademark->contracting_organization)])
                                </select>
                            </div>
                        </div>

                        <div class="tm-field">
                            <label class="tm-label" for="designated_countries">Designated Countries</label>
                            <div class="tm-control">
                                <input class="form-control tm-input" id="designated_countries" name="designated_countries" type="text" value="{{ old('designated_countries', $trademark->designated_countries) }}">
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            <section class="tm-section" id="trademark-section">
                <h2 class="tm-section-heading"><span>03 |</span> Trademark</h2>
                <div class="tm-field-grid">
                    <div class="tm-field autocomplete-wrap">
                        <label class="tm-label" for="trademark">{{ __('messages.trademark') }}</label>
                        <div class="tm-control">
                            <input id="trademark" name="trademark" class="form-control tm-input" type="text" autocomplete="off" maxlength="250" value="{{ old('trademark', $trademark->trademark) }}">
                            <div id="trademark_suggestions" class="autocomplete-box d-none"></div>
                        </div>
                    </div>

                    <div class="tm-field is-logo" id="representationLogoField">
                        <label class="tm-label" for="design">Representation / Logo</label>
                        <div class="tm-logo-control">
                            <input id="design" name="design" class="form-control tm-input" type="file" accept=".jpg,.jpeg,.png,.webp,.gif,image/*">
                            <div class="tm-preview-wrap" id="representationLogoPreview">
                                <img id="blah" class="tm-preview-image" src="{{ $trademark->design ? asset('design/'.$trademark->design) : asset('design/no-image.jpg') }}" alt="Trademark design preview">
                            </div>
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="type_application">Type of Application</label>
                        <div class="tm-control">
                            <select class="form-control tm-select" id="type_application" name="type_application">
                                <option value="">{{ __('messages.select') }}</option>
                                <option value="Trademark" {{ old('type_application', $trademark->type_application) == 'Trademark' ? 'selected' : '' }}>Trademark</option>
                                <option value="Commercial Name" {{ old('type_application', $trademark->type_application) == 'Commercial Name' ? 'selected' : '' }}>Commercial Name</option>
                                <option value="Slogan" {{ old('type_application', $trademark->type_application) == 'Slogan' ? 'selected' : '' }}>Slogan</option>
                                <option value="Collective Mark" {{ old('type_application', $trademark->type_application) == 'Collective Mark' ? 'selected' : '' }}>Collective Mark</option>
                                <option value="Certification Mark" {{ old('type_application', $trademark->type_application) == 'Certification Mark' ? 'selected' : '' }}>Certification Mark</option>
                            </select>
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="type_mark">Type of Mark</label>
                        <div class="tm-control">
                            <select class="form-control tm-select" id="type_mark" name="type_mark">
                                <option value="">{{ __('messages.select') }}</option>
                                <option value="Word Mark" {{ old('type_mark', $trademark->type_mark) == 'Word Mark' ? 'selected' : '' }}>Word Mark</option>
                                <option value="Design Mark" {{ old('type_mark', $trademark->type_mark) == 'Design Mark' ? 'selected' : '' }}>Design Mark</option>
                                <option value="Mixed Mark" {{ old('type_mark', $trademark->type_mark) == 'Mixed Mark' ? 'selected' : '' }}>Mixed Mark</option>
                                <option value="Three-Dimensional Mark" {{ old('type_mark', $trademark->type_mark) == 'Three-Dimensional Mark' ? 'selected' : '' }}>Three-Dimensional Mark</option>
                                <option value="Holographic Mark" {{ old('type_mark', $trademark->type_mark) == 'Holographic Mark' ? 'selected' : '' }}>Holographic Mark</option>
                                <option value="Sound Mark" {{ old('type_mark', $trademark->type_mark) == 'Sound Mark' ? 'selected' : '' }}>Sound Mark</option>
                                <option value="Scent Mark" {{ old('type_mark', $trademark->type_mark) == 'Scent Mark' ? 'selected' : '' }}>Scent Mark</option>
                                <option value="Trade Dress" {{ old('type_mark', $trademark->type_mark) == 'Trade Dress' ? 'selected' : '' }}>Trade Dress</option>
                                <option value="Other" {{ old('type_mark', $trademark->type_mark) == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="tm-field is-tall" id="descriptionMarkField">
                        <label class="tm-label" for="description_trademark">Description of the Mark</label>
                        <div class="tm-control">
                            <textarea class="form-control tm-input" id="description_trademark" name="description_trademark" rows="4">{{ old('description_trademark', $trademark->description_trademark) }}</textarea>
                        </div>
                    </div>

                    <div class="tm-field is-tall">
                        <label class="tm-label" for="translation">{{ __('messages.translation') }}</label>
                        <div class="tm-control">
                            <textarea class="form-control tm-input" id="translation" name="translation" rows="4">{{ old('translation', $trademark->translation) }}</textarea>
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="transliteration_trademark">{{ __('messages.transliteration') }}</label>
                        <div class="tm-control">
                            <textarea class="form-control tm-input" id="transliteration_trademark" name="transliteration_trademark" rows="2">{{ old('transliteration_trademark', $trademark->transliteration_trademark) }}</textarea>
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="disclaimer">Disclaimer</label>
                        <div class="tm-control">
                            <textarea class="form-control tm-input" id="disclaimer" name="disclaimer" rows="2">{{ old('disclaimer', $trademark->disclaimer) }}</textarea>
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
                                    @php
                                        $classValue = str_pad($i, 2, '0', STR_PAD_LEFT);
                                        $selectedClass = old('class', $trademark->class);
                                        $isSelectedClass = (string) $selectedClass === $classValue || (string) $selectedClass === (string) $i;
                                    @endphp
                                    <option value="{{ $classValue }}" {{ $isSelectedClass ? 'selected' : '' }}>{{ $classValue }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="tm-field is-tall">
                        <label class="tm-label" for="description_good">{{ __('messages.description') }}</label>
                        <div class="tm-control">
                            <textarea class="form-control tm-input" id="description_good" name="description_good" rows="5">{{ old('description_good', $trademark->description_good) }}</textarea>
                        </div>
                    </div>

                    <div class="tm-field is-tall">
                        <label class="tm-label" for="translation_good">{{ __('messages.translation') }}</label>
                        <div class="tm-control">
                            <textarea class="form-control tm-input" id="translation_good" name="translation_good" rows="4">{{ old('translation_good', $trademark->translation_good) }}</textarea>
                        </div>
                    </div>
                </div>
            </section>

            <section class="tm-section" id="holder">
                <h2 class="tm-section-heading"><span>05 |</span> Owner</h2>
                <div class="tm-field-grid">
                    <div class="tm-field autocomplete-wrap">
                        <label class="tm-label" for="holder_search">{{ __('messages.holder') }}</label>
                        <div class="tm-control">
                            <input type="text" id="holder_search" class="form-control tm-input" autocomplete="off" value="{{ old('holder_search', optional($trademark->Holder)->company_name) }}">
                            <input type="hidden" id="id_holder" name="id_holder" value="{{ old('id_holder', $trademark->id_holder) }}">
                            <div id="holder_search_suggestions" class="autocomplete-box d-none"></div>
                        </div>
                    </div>

                    <div class="tm-field is-tall">
                        <label class="tm-label" for="industrial_address">{{ __('messages.industrial_address') }}</label>
                        <div class="tm-control">
                            <select class="form-control tm-select" name="industrial_address" id="industrial_address">
                                @if($trademark->industrial_address)
                                    <option value="{{ $trademark->industrial_address }}" selected>{{ $trademark->industrial_address }}</option>
                                @else
                                    <option value="">{{ __('messages.select') }}</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="tm-field is-tall">
                        <label class="tm-label" for="address_holder">{{ __('messages.address') }}</label>
                        <div class="tm-control">
                            <select class="form-control tm-select" name="address_holder" id="address_holder">
                                @if($trademark->address_holder && $trademark->AddressHolder)
                                    <option value="{{ $trademark->address_holder }}" selected>{{ $trademark->AddressHolder->address }}</option>
                                @else
                                    <option value="">{{ __('messages.select') }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </section>

            <section class="tm-section" id="sessions">
                <h2 class="tm-section-heading"><span>06 |</span> Client</h2>
                <div class="tm-field-grid">
                    <div class="tm-field autocomplete-wrap">
                        <label class="tm-label" for="client_search">{{ __('messages.client') }}</label>
                        <div class="tm-control">
                            <input type="text" id="client_search" class="form-control tm-input" autocomplete="off" value="{{ old('client_search', optional($trademark->Client)->company_name) }}">
                            <input type="hidden" id="id_client" name="id_client" value="{{ old('id_client', $trademark->id_client) }}">
                            <div id="client_search_suggestions" class="autocomplete-box d-none"></div>
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="invoice_recipient_preview">Invoice Recipient</label>
                        <div class="tm-control">
                            <input id="invoice_recipient_preview" class="form-control tm-input" type="text" value="{{ old('client_search', optional($trademark->Client)->company_name) }}" disabled>
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="id_contact">{{ __('messages.contact') }}</label>
                        <div class="tm-control">
                            <select class="form-control tm-select" name="id_contact" id="id_contact">
                                @if($trademark->id_contact && $trademark->ContactClient)
                                    <option value="{{ $trademark->id_contact }}" selected data-email="{{ $trademark->ContactClient->email }}">{{ $trademark->ContactClient->name }}</option>
                                @else
                                    <option value="">{{ __('messages.select') }}</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="client_contact_email">{{ __('messages.email') }}</label>
                        <div class="tm-control">
                            <input id="client_contact_email" class="form-control tm-input" type="text" value="{{ optional($trademark->ContactClient)->email }}" disabled>
                        </div>
                    </div>

                    <div class="tm-field is-tall">
                        <label class="tm-label" for="id_address">{{ __('messages.address') }}</label>
                        <div class="tm-control">
                            <select class="form-control tm-select" name="id_address" id="id_address">
                                @if($trademark->id_address && $trademark->AddressContact)
                                    <option value="{{ $trademark->id_address }}" selected data-billing="{{ $trademark->AddressContact->billing_address }}">{{ $trademark->AddressContact->address }}</option>
                                @else
                                    <option value="">{{ __('messages.select') }}</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="tm-field is-tall">
                        <label class="tm-label" for="billing_address_preview">{{ __('messages.billing_address') }}</label>
                        <div class="tm-control">
                            <select class="form-control tm-select" id="billing_address_preview" disabled>
                                <option value="">{{ optional($trademark->AddressContact)->billing_address ?? __('messages.select') }}</option>
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
                            <input id="publication_date" name="publication_date" class="form-control tm-input date-mask" type="date" value="{{ $dateValue('publication_date') }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="filing_date_opposition">Opposition Date</label>
                        <div class="tm-control">
                            <input id="filing_date_opposition" name="filing_date_opposition" class="form-control tm-input date-mask" type="date" value="{{ $dateValue('filing_date_opposition') }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="opposition_no">{{ __('messages.opposition_no') }}</label>
                        <div class="tm-control">
                            <input id="opposition_no" name="opposition_no" class="form-control tm-input" type="text" value="{{ old('opposition_no', $trademark->opposition_no) }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="filing_date_litigation">Office Action Date</label>
                        <div class="tm-control">
                            <input id="filing_date_litigation" name="filing_date_litigation" class="form-control tm-input date-mask" type="date" value="{{ $dateValue('filing_date_litigation') }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="litigation_no">{{ __('messages.litigation_no') }}</label>
                        <div class="tm-control">
                            <input id="litigation_no" name="litigation_no" class="form-control tm-input" type="text" value="{{ old('litigation_no', $trademark->litigation_no) }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="lastDeclarationDate">{{ __('messages.declarations_use') }} - {{ __('messages.last') }}</label>
                        <div class="tm-control">
                            <input id="lastDeclarationDate" name="last_declaration" class="form-control tm-input date-mask" type="date" value="{{ $dateValue('last_declaration') }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="declarationOfUseDate">{{ __('messages.declarations_use') }} - {{ __('messages.next') }}</label>
                        <div class="tm-control">
                            <input id="declarationOfUseDate" name="next_declaration" class="form-control tm-input date-mask" type="date" value="{{ $dateValue('next_declaration') }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="lastRenewalsDate">{{ __('messages.renewals') }} - {{ __('messages.last') }}</label>
                        <div class="tm-control">
                            <input id="lastRenewalsDate" name="last_renewal" class="form-control tm-input date-mask" type="date" value="{{ $dateValue('last_renewal') }}">
                        </div>
                    </div>

                    <div class="tm-field">
                        <label class="tm-label" for="renewalDate">{{ __('messages.renewals') }} - {{ __('messages.next') }}</label>
                        <div class="tm-control">
                            <input id="renewalDate" name="next_renewal" class="form-control tm-input date-mask" type="date" value="{{ $dateValue('next_renewal') }}">
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
                            <textarea class="form-control tm-input" id="notes_text" name="notes" rows="5">{{ old('notes', $trademark->notes) }}</textarea>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </form>
</div>
@endsection

@section('js_custom')
<script src="{{ asset('assets/js/trademark-header.js') }}?v={{ filemtime(public_path('assets/js/trademark-header.js')) }}"></script>
<script src="{{ asset('assets/js/trademark-dates.js') }}?v={{ filemtime(public_path('assets/js/trademark-dates.js')) }}"></script>
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
    setSelectedOptionIfExists('contracting_organization', @json(old('contracting_organization', $trademark->contracting_organization)));
})();
</script>

<script>
(function () {
    const typeApplication = document.getElementById('type_application');
    const typeMark = document.getElementById('type_mark');
    const descriptionField = document.getElementById('descriptionMarkField');
    const hasExistingDescription = @json(filled($trademark->description_trademark));
    const descriptionTypes = new Set(['Holographic Mark', 'Sound Mark', 'Scent Mark', 'Trade Dress', 'Other']);

    function syncTrademarkConditionalFields() {
        const value = typeMark?.value || '';
        const showDescription = descriptionTypes.has(value) || (hasExistingDescription && !value);

        if (descriptionField) {
            descriptionField.classList.toggle('d-none', !showDescription);
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
    function debounce(fn, delay = 300) {
        let timer;
        return function (...args) {
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(this, args), delay);
        };
    }

    function setupAutocomplete({ inputSelector, boxSelector, url, hiddenSelector = null, minLength = 2, onSelect = null }) {
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
                    input.dispatchEvent(new Event('trademark:selection', { bubbles: true }));
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

    function syncClientPreview() {
        const clientInput = document.getElementById('client_search');
        const invoicePreview = document.getElementById('invoice_recipient_preview');
        if (clientInput && invoicePreview) {
            invoicePreview.value = clientInput.value;
        }
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
            syncClientPreview();
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

    document.getElementById('client_search')?.addEventListener('input', syncClientPreview);
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

        let registrationDate = new Date(value + 'T00:00:00');
        if (isNaN(registrationDate.getTime())) return;

        let expirationDate = new Date(registrationDate);
        expirationDate.setFullYear(expirationDate.getFullYear() + 10);

        let declarationOfUseDate = new Date(registrationDate);
        declarationOfUseDate.setFullYear(declarationOfUseDate.getFullYear() + 3);

        $('#expirationDate').val(formatDate(expirationDate)).trigger('change');
        $('#declarationOfUseDate').val(formatDate(declarationOfUseDate)).trigger('change');
        $('#renewalDate').val(formatDate(expirationDate)).trigger('change');
    });

    $('#lastDeclarationDate').on('change', function() {
        let renewalDate = $('#renewalDate').val();
        $('#declarationOfUseDate').val(renewalDate).trigger('change');
    });

    $('#lastRenewalsDate').on('change', function() {
        let expirationDate = $('#expirationDate').val();
        if (!expirationDate) return;

        let d = new Date(expirationDate + 'T00:00:00');
        d.setFullYear(d.getFullYear() + 10);

        $('#expirationDate').val(formatDate(d)).trigger('change');
        $('#declarationOfUseDate').val(formatDate(d)).trigger('change');
        $('#renewalDate').val(formatDate(d)).trigger('change');
    });
});
</script>

<script>
(function () {
    const form = document.getElementById('trademarkEditForm');
    if (!form) return;

    const requiredFields = [];

    function clearInvalid(el) {
        if (!el) return;
        el.classList.remove('is-invalid');
        const wrapper = el.closest('.autocomplete-wrap') || el.closest('.tm-control') || el.parentElement;
        const feedback = wrapper?.querySelector('.invalid-feedback.dynamic-feedback');
        if (feedback) feedback.remove();
    }

    function markInvalid(el, message) {
        if (!el) return;
        el.classList.add('is-invalid');
        const wrapper = el.closest('.autocomplete-wrap') || el.closest('.tm-control') || el.parentElement;
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

        if (clientRefValue && !/^[\p{L}\p{N} .\/()\[\]-]{1,20}$/u.test(clientRefValue)) {
            markInvalid(clientRef, 'C/Ref. allows letters, numbers, spaces, - . / ( ) [ ], up to 20 characters.');
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
        this.value = this.value.replace(/[^\p{L}\p{N} .\/()\[\]-]/gu, '').slice(0, 20);
    });

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

        validateReferenceFields(errors);
        validateStructuralNumberFields(errors);

        if (errors.length) {
            e.preventDefault();

            if (window.Swal) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Please review the form',
                    html: `<div class="text-start">${errors.map(item => `<div>${item}</div>`).join('')}</div>`,
                    confirmButtonColor: '#2f6f5e'
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
