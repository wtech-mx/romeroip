{{-- @php($trademarks = App\Models\Trademarks::all())
@livewire('trademarks.index') --}}
@extends('layouts.app')

@section('content')

@include('filtros')

<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card">
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
                    <a href="{{ route('create.trademarks') }}" class="btn btn-sm mb-0 mt-sm-0 mt-1" style="border: 2px solid #F82018; color: #F82018;" data-type="csv" type="button" name="button">&nbsp; {{ __('messages.new_trademark') }}</a>
                    <button class="btn btn-sm mb-0 mt-sm-0 mt-1" style="background: #F82018; color: #fff;" data-type="csv" type="button" name="button">{{ __('messages.export') }}</button>
                  </div>
                </div>

              </div>
            </div>

            <div class="card-body px-0 pb-0" style="padding-top: 1rem;">
              <div class="table-responsive">
                <table class="table table-flush" id="products-list">
                  <thead class="thead-light">
                    <tr style="font-size: 13px;">
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
                            <tr style="font-size: 12px;">
                             <td class="text-center ">
                                <div class="form-check" style="">
                                    <input class="form-check-input" type="checkbox"  >
                                </div>
                            </td>
                            <td class="text-center">{{ $trademark->our_ref }}</td>
                            <td class="text-center">{{ $trademark->trademark }}</td>
                            <td class="text-center">{{ $trademark->class }}</td>
                            <td class="text-center">{{ $trademark->application_no }}</td>
                            <td class="text-center">{{ $trademark->registration_no }}</td>
                            <td class="text-center">{{ $trademark->registration_date }}</td>
                            <td class="text-center">{{ $trademark->last_declaration }}</td>
                            <td class="text-center">{{ $trademark->last_renewal }}</td>
                                @if ($trademark->id_holder == NULL)
                                    <td class="text-center"></td>
                                @else
                                <td class="text-center"></td>
                                    {{-- <td class="text-center">{{$trademark->Holder->company_name}}</td> --}}
                                @endif

                                @if ($trademark->id_client == NULL)
                                    <td class="text-center"></td>
                                @else
                                <td class="text-center"></td>
                                    {{-- <td class="text-center">{{$trademark->Client->company_name}}</td> --}}
                                @endif
                            <td class="text-center">{{ $trademark->client_ref }}</td>
                            <td class="text-center">{{ $trademark->origin }}</td>
                            <td class="text-center">{{ $trademark->status }}</td>
                            <td class="text-sm">
                                <a href="{{ route('edit.trademarks', $trademark->id) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit product">
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
