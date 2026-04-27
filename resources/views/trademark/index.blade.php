{{-- @php($trademarks = App\Models\Trademarks::all())
@livewire('trademarks.index') --}}
@extends('layouts.app')

@section('css')
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

    .tm-index-page{
        max-width: 1440px;
        margin-left: 0;
        margin-right: auto;
        padding-bottom: 4rem;
    }

    .tm-search-panel,
    .tm-results-panel{
        background: #FBFAF6 !important;
        border: 1px solid var(--tm-border) !important;
        border-radius: 0 !important;
        box-shadow: none !important;
    }

    .tm-search-panel{
        margin-bottom: 1rem;
    }

    .tm-search-panel .card-header,
    .tm-results-panel .card-header{
        padding: 1.55rem 2rem 1rem !important;
        border-bottom: 1px solid var(--tm-border-soft);
        background: transparent;
    }

    .tm-search-panel h5,
    .tm-results-panel h5{
        margin: 0;
        color: var(--tm-dark);
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .tm-search-panel .card-body,
    .tm-results-panel .card-body{
        padding: 1.35rem 2rem 1.75rem !important;
    }

    .tm-search-panel .row{
        row-gap: 1.15rem;
    }

    .tm-search-panel [class*="col-"]{
        position: relative;
    }

    .tm-search-panel .form-label{
        margin-bottom: .28rem;
        color: var(--tm-muted);
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .tm-search-panel .input-group{
        display: flex;
        width: 100%;
    }

    .tm-search-panel .form-control{
        width: 100%;
        min-height: 48px;
        border: 0 !important;
        border-bottom: 1px solid var(--tm-border-soft) !important;
        border-radius: 0 !important;
        background: transparent !important;
        color: var(--tm-dark);
        font-weight: 600;
        padding: .68rem .2rem .65rem 0;
        box-shadow: none !important;
    }

    .tm-search-panel .form-control:focus{
        border-color: var(--tm-primary) !important;
        background: rgba(255,255,255,.55) !important;
    }

    .tm-search-panel .btn,
    .tm-results-panel .btn{
        min-height: 40px;
        padding: 0 .95rem;
        border-radius: 3px !important;
        font-weight: 700;
        border: 1px solid var(--tm-dark) !important;
        background: transparent !important;
        color: var(--tm-dark) !important;
        box-shadow: none !important;
    }

    .tm-search-panel button[type="submit"],
    .tm-results-panel button{
        background: var(--tm-dark) !important;
        color: #fff !important;
    }

    .autocomplete-box{
        border-color: var(--tm-border);
        border-radius: 3px;
        box-shadow: 0 10px 22px rgba(31,35,40,.08);
    }

    .autocomplete-item{
        border-radius: 2px;
    }

    .autocomplete-item:hover{
        background: rgba(138,111,62,.10);
    }

    .tm-table-wrap{
        border-top: 0;
    }

    .tm-results-table{
        margin: 0;
        color: var(--tm-dark);
    }

    .tm-results-table thead th{
        padding: .85rem 1rem;
        border-bottom: 1px solid var(--tm-border);
        background: #F7F4ED;
        color: var(--tm-muted);
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-align: left;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .tm-results-table tbody td{
        padding: 1rem;
        border-bottom: 1px solid var(--tm-border-soft);
        color: var(--tm-dark);
        font-size: .88rem;
        font-weight: 600;
        text-align: left !important;
        vertical-align: top;
        white-space: nowrap;
    }

    .tm-results-table tbody tr:hover{
        background: rgba(138,111,62,.05);
    }

    .tm-edit-link{
        color: var(--tm-dark);
        font-weight: 700;
        text-decoration: none;
        border-bottom: 1px solid var(--tm-primary);
        margin-right: .75rem;
    }

    .tm-empty-count{
        color: var(--tm-muted);
        font-size: .9rem;
        font-weight: 600;
    }

    @media (max-width: 991.98px){
        .tm-search-panel .card-header,
        .tm-results-panel .card-header,
        .tm-search-panel .card-body,
        .tm-results-panel .card-body{
            padding-left: 1.25rem !important;
            padding-right: 1.25rem !important;
        }

        .tm-search-panel .col-3,
        .tm-search-panel .col-6{
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>
@endsection

@section('content')

<div class="tm-index-page">
  @include('filtros')

<div class="container-fluid py-0">
      <div class="row">
        <div class="col-12">
          <div class="card tm-results-panel">
            <!-- Card header -->
            <div class="card-header pb-0">
              <div class="d-lg-flex">
                <div>
                    @if(Route::currentRouteName() != 'index.trademarks')
                    <h5 class="mb-0">{{ __('messages.all_trademark') }}: {{ $trademarks->count() }}</h5>
                    @else
                    <h5 class="mb-0">{{ __('messages.all_trademark') }}: 0</h5>
                    @endif
                  <p class="text-sm mb-0">

                  </p>
                </div>

                <div class="ms-auto my-auto mt-lg-0 mt-4">
                  <div class="ms-auto my-auto">
                    <a href="{{ route('create.trademarks') }}" class="btn btn-sm mb-0 mt-sm-0 mt-1" data-type="csv" type="button" name="button">{{ __('messages.new_trademark') }}</a>
                    <button class="btn btn-sm mb-0 mt-sm-0 mt-1" data-type="csv" type="button" name="button">{{ __('messages.export') }}</button>
                  </div>
                </div>

              </div>
            </div>

            <div class="card-body px-0 pb-0">
              <div class="table-responsive tm-table-wrap">
                <table class="table table-flush tm-results-table" id="products-list">
                  <thead class="thead-light">
                    <tr>
                      <th>#</th>
                      <th>{{ __('messages.our_ref') }}</th>
                      <th>{{ __('messages.trademark') }}</th>
                      <th>{{ __('messages.class') }}</th>
                      <th>{{ __('messages.application_no') }}</th>
                      <th>{{ __('messages.registration_no') }}</th>
                      <th>{{ __('messages.registration_date') }}</th>
                      <th>{{ __('messages.declaration_use') }}</th>
                      <th>{{ __('messages.renewal') }}</th>
                      <th>{{ __('messages.holder') }}</th>
                      <th>{{ __('messages.client') }}</th>
                      <th>{{ __('messages.client_ref') }}</th>
                      <th>{{ __('messages.origin') }}</th>
                      <th>{{ __('messages.status') }}</th>
                      <th>{{ __('messages.action') }}</th>
                    </tr>
                  </thead>

                  <tbody>
                   @if(Route::currentRouteName() != 'index.trademarks')
                        @foreach ($trademarks as $trademark)
                            <tr>
                             <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"  >
                                </div>
                            </td>
                            <td>{{ $trademark->our_ref }}</td>
                            <td>{{ $trademark->trademark }}</td>
                            <td>{{ $trademark->class }}</td>
                            <td>{{ $trademark->application_no }}</td>
                            <td>{{ $trademark->registration_no }}</td>
                            <td>{{ $trademark->registration_date }}</td>
                            <td>{{ $trademark->last_declaration }}</td>
                            <td>{{ $trademark->last_renewal }}</td>
                                @if ($trademark->id_holder == NULL)
                                    <td></td>
                                @else
                                <td></td>
                                    {{-- <td class="text-center">{{$trademark->Holder->company_name}}</td> --}}
                                @endif

                                @if ($trademark->id_client == NULL)
                                    <td></td>
                                @else
                                <td></td>
                                    {{-- <td class="text-center">{{$trademark->Client->company_name}}</td> --}}
                                @endif
                            <td>{{ $trademark->client_ref }}</td>
                            <td>{{ $trademark->origin }}</td>
                            <td>{{ $trademark->status }}</td>
                            <td class="text-sm">
                                <a href="{{ route('show.trademarks', $trademark->id) }}" class="tm-edit-link" data-bs-toggle="tooltip" data-bs-original-title="View trademark">
                                    view
                                </a>
                                <a href="{{ route('edit.trademarks', $trademark->id) }}" class="tm-edit-link" data-bs-toggle="tooltip" data-bs-original-title="Edit trademark">
                                    edit
                                </a>
                                {{-- <a href="javascript:;" data-bs-toggle="tooltip" data-bs-original-title="Delete product">
                                <i class="fas fa-trash text-secondary"></i>
                                </a> --}}
                            </td>
                            </tr>
                        @endforeach
                    @endif
                  </tbody>

                </table>

              </div>
            </div>
          </div>
        </div>
      </div>
</div>
</div>

@endsection

@section('js_custom')
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

                        if (hidden) {
                            hidden.value = id;
                        }

                        hideBox();

                        if (typeof onSelect === 'function') {
                            onSelect({ id, value });
                        }
                    });
                });
            };

            const fetchResults = debounce(async function () {
                const q = input.value.trim();

                if (hidden && !q) {
                    hidden.value = '';
                }

                if (q.length < minLength) {
                    hideBox();
                    return;
                }

                try {
                    const response = await fetch(`${url}?q=${encodeURIComponent(q)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const data = await response.json();
                    renderItems(data);
                } catch (error) {
                    hideBox();
                }
            }, 250);

            input.addEventListener('input', function () {
                if (hidden) {
                    hidden.value = '';
                }
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

        function loadClientContacts(id) {
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
        }

        function loadClientAddresses(id) {
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
        }

        function loadHolderAddresses(id) {
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
        }

        function loadHolderIndustrialAddresses(id) {
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
        }
    })();
    </script>
@endsection
