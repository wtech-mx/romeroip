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

<div class="container-fluid mt-3 tm-page tm-compact-file">
    <form method="POST"
          action="{{ route('store.trademarks') }}"
          enctype="multipart/form-data"
          role="form"
          id="trademarkForm"
          novalidate>
        @csrf

        <div class="tm-toolbar tm-page-actions" aria-label="File actions">
            <a class="tm-btn" href="{{ route('index.trademarks') }}">{{ __('messages.back') }}</a>
            <button type="submit" class="tm-btn tm-btn-save">{{ __('messages.save') }}</button>
        </div>
        <div class="tm-file-shell">
            @include('trademark._header', ['isNewFile' => true])

            <div class="mt-3">
                @includeif('partials.errors')
            </div>

            @include('trademark._file-sections', ['readOnly' => false, 'newFile' => true])

            @include('trademark._mark-section', ['readOnly' => false, 'newFile' => true])

            @include('trademark._text-section', ['fileSectionId' => 'accounts', 'readOnly' => false, 'newFile' => true])

            <section class="tm-section tm-approved-section tm-contact-section" id="holder" data-address-url="{{ url('/trademarks/holder') }}" data-estab-url="{{ url('/trademarks/holder/industrial') }}"><h2 class="tm-section-heading"><span>06 |</span> Owner</h2><div class="tm-contact-layout"><div class="tm-field">
                        <label class="tm-label" for="id_holder">{{ 'Owner' }}</label>
                        <div class="tm-control">
                            <select class="form-control tm-select js-example-basic-single" id="id_holder" name="id_holder">
                                <option value="">{{ 'Owner' }}</option>
                                @foreach ($holders as $holder)
                                    <option value="{{ $holder->id }}" {{ $oldSelected('id_holder', $holder->id) }}>{{ $holder->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><div class="tm-contact-pair tm-contact-addresses"><div class="tm-field is-tall">
                        <label class="tm-label" for="address_holder">{{ __('messages.address') }}</label>
                        <div class="tm-control">
                            <select class="form-control tm-select" name="address_holder" id="address_holder">
                                <option value="">{{ __('messages.select') }}</option>
                            </select>
                        </div>
                    </div><div class="tm-field is-tall">
                        <label class="tm-label" for="industrial_address">Estab.<br>Address</label>
                        <div class="tm-control">
                            <select class="form-control tm-select" name="industrial_address" id="industrial_address">
                                <option value="">Seleccione Industrial / Commercial Address</option>
                            </select>
                        </div>
                    </div></div></div></section>

            <section class="tm-section tm-approved-section tm-contact-section" id="sessions" data-contact-url="{{ url('/trademarks/crear') }}" data-address-url="{{ url('/trademarks/address') }}"><h2 class="tm-section-heading"><span>07 |</span> Client</h2><div class="tm-contact-layout"><div class="tm-field">
                        <label class="tm-label" for="id_client">{{ __('messages.client') }}</label>
                        <div class="tm-control">
                            <select class="form-control tm-select js-example-basic-single" id="id_client" name="id_client">
                                <option value="">{{ __('messages.client') }}</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}" {{ $oldSelected('id_client', $client->id) }}>{{ $client->company_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><div class="tm-contact-pair tm-client-pair"><div class="tm-contact-table tm-client-details"><div class="tm-field">
                        <label class="tm-label" for="id_contact">{{ __('messages.contact') }}</label>
                        <div class="tm-control">
                            <select class="form-control tm-select" name="id_contact" id="id_contact">
                                <option value="">{{ __('messages.select') }}</option>
                            </select>
                        </div>
                    </div><div class="tm-field">
                        <label class="tm-label" for="client_contact_email">{{ __('messages.email') }}</label>
                        <div class="tm-control">
                            <select id="client_contact_email" class="form-control tm-select"><option value="">Select</option></select>
                        </div>
                    </div></div><div class="tm-contact-table tm-client-address"><div class="tm-field is-tall">
                        <label class="tm-label" for="id_address">{{ __('messages.address') }}</label>
                        <div class="tm-control">
                            <select class="form-control tm-select" name="id_address" id="id_address">
                                <option value="">{{ __('messages.select') }}</option>
                            </select>
                        </div>
                    </div></div></div></div></section>

            @include('trademark._deadline-section', ['readOnly' => false, 'newFile' => true])

            @include('trademark._text-section', ['fileSectionId' => 'notes', 'readOnly' => false, 'newFile' => true])
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
                    const option = new Option(element.name ?? '', element.id); option.dataset.email = element.email ?? ''; $('#id_contact').append(option);
                });
            }
        });
    }

    function loadClientAddresses(id) {
        $('#id_address').empty().append(`<option value="" selected>Loading...</option>`);

        $.ajax({
            type: 'GET',
            url: '{{ url("/trademarks/address") }}/' + id,
            success: function (response) {
                const data = typeof response === 'string' ? JSON.parse(response) : response;

                $('#id_address').empty().append(`<option value="">{{ __('messages.select') }}</option>`);

                data.forEach(element => {
                    const option = new Option(element.address ?? '', element.id); $('#id_address').append(option);
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
                    const option = new Option(element.address ?? '', element.id); $('#address_holder').append(option);
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
                    const option = new Option(element.commercial_address ?? '', element.commercial_address); $('#industrial_address').append(option);
                });
            }
        });
    }

    $('#id_client').on('change', function () {
        const id = $(this).val();

        if (!id) {
            $('#id_contact').empty().append(`<option value="">{{ __('messages.select') }}</option>`);
            $('#id_address').empty().append(`<option value="">{{ __('messages.select') }}</option>`);
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

})();
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
<script src="{{ asset('assets/js/trademark-contacts.js') }}?v={{ filemtime(public_path('assets/js/trademark-contacts.js')) }}"></script>
@endsection
