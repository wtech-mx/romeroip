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

            @include('trademark._file-sections', ['readOnly' => false, 'newFile' => false])

            @include('trademark._mark-section', ['readOnly' => false, 'newFile' => false])

            @include('trademark._text-section', ['fileSectionId' => 'accounts', 'readOnly' => false, 'newFile' => false])

            <section class="tm-section tm-approved-section tm-contact-section" id="holder"><h2 class="tm-section-heading"><span>06 |</span> Owner</h2><div class="tm-contact-layout">                    <div class="tm-field autocomplete-wrap">
                        <label class="tm-label" for="holder_search">{{ 'Owner' }}</label>
                        <div class="tm-control">
                            <input type="text" id="holder_search" class="form-control tm-input" autocomplete="off" value="{{ old('holder_search', optional($trademark->Holder)->company_name) }}">
                            <input type="hidden" id="id_holder" name="id_holder" value="{{ old('id_holder', $trademark->id_holder) }}">
                            <div id="holder_search_suggestions" class="autocomplete-box d-none"></div>
                        </div>
                    </div>
<div class="tm-contact-pair tm-contact-addresses">                    <div class="tm-field is-tall">
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
                    </div>                    <div class="tm-field is-tall">
                        <label class="tm-label" for="industrial_address">{{ 'Commercial Address' }}</label>
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
</div></div></section>

            <section class="tm-section tm-approved-section tm-contact-section" id="sessions"><h2 class="tm-section-heading"><span>07 |</span> Client</h2><div class="tm-contact-layout">                    <div class="tm-field autocomplete-wrap">
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
<div class="tm-contact-pair tm-contact-addresses">                    <div class="tm-field is-tall">
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
                    </div></div><div class="tm-contact-pair">                    <div class="tm-field">
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
</div></div></section>

            @include('trademark._deadline-section', ['readOnly' => false, 'newFile' => false])

            @include('trademark._text-section', ['fileSectionId' => 'notes', 'readOnly' => false, 'newFile' => false])
        </div>
    </form>
</div>
@endsection

@section('js_custom')
<script src="{{ asset('assets/js/trademark-header.js') }}?v={{ filemtime(public_path('assets/js/trademark-header.js')) }}"></script>
<script src="{{ asset('assets/js/trademark-dates.js') }}?v={{ filemtime(public_path('assets/js/trademark-dates.js')) }}"></script>
<script src="{{ asset('assets/js/trademark-field-controls.js') }}?v={{ filemtime(public_path('assets/js/trademark-field-controls.js')) }}"></script>
<script src="{{ asset('assets/js/trademark-logo.js') }}?v={{ filemtime(public_path('assets/js/trademark-logo.js')) }}"></script>
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
