@extends('layouts.app')

@section('page_actuality')
{{ __('messages.new_client') }}
@endsection

@section('content')
<div class="container-fluid mt-3">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <form method="POST" action="{{ route('store.clients') }}" enctype="multipart/form-data" role="form">
                    @csrf
                    <div class="card-header">
                        <h3 class="mb-3">{{ __('messages.new_client') }}</h3>
                        <a class="btn" href="{{ route('index.clients') }}"
                            style="background: {{$configuracion->color_boton_close}}; color: #ffff"> Back</a>
                        @includeif('partials.errors')
                        <button type="submit" class="btn" style="background: {{$configuracion->color_boton_save}}; color: #ffff">Save</button>
                    </div>

                    <main class="main-content max-height-vh-100 h-100">
                            <div class="container-fluid">
                                <div class="row mb-5">

                                    <div class="col-lg-9 mt-lg-0 mt-4">
                                        <!-- Card notes  -->
                                        <div class="card" id="notes">
                                            <div class="card-header">
                                                <h5>{{ __('messages.note_important') }}</h5>
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="form-label">{{ __('messages.note') }}</label>
                                                        <div class="input-group">
                                                            <textarea class="form-control" name="notes" id="notes" rows="1"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Card Client -->
                                        <div class="card mt-4" id="profile">
                                            <div class="card-header">
                                                <h5>{{ __('messages.client') }}</h5>
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="form-label">{{ __('messages.company_name') }}</label>
                                                        <div class="input-group">
                                                            <input name="company_name" id="company_name" class="form-control" type="text"
                                                                placeholder="{{ __('messages.company_name') }}"
                                                                required="required">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label">R.F.C.</label>
                                                        <div class="input-group">
                                                            <input name="vat_no" id="vat_no" class="form-control"
                                                                type="text" placeholder="R.F.C."
                                                                required="required">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.country') }}</label>
                                                        <div class="input-group">
                                                            <select class="form-control" name="country" id="country">
                                                                @include('client.paises')
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Card Contact -->
                                        <div class="card mt-4">
                                            <div class="card-header">
                                                <h5>{{ __('messages.contact') }}</h5>
                                            </div>
                                            <div class="card-body pt-0" id="contact">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.contact_name')}}</label>
                                                        <div class="input-group">
                                                            <input name="name[]" id="name[]" class="form-control"
                                                                type="text" placeholder="{{ __('messages.contact_name') }}"
                                                                required="required">
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.short_name') }}</label>
                                                        <div class="input-group">
                                                            <input name="short_name[]" id="short_name[]" class="form-control" type="text"
                                                                placeholder="{{ __('messages.short_name') }}"
                                                                required="required">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.position')}}</label>
                                                        <div class="input-group">
                                                            <input name="position[]" id="position[]" class="form-control"
                                                                type="text"
                                                                placeholder="{{ __('messages.position') }}"
                                                                required="required">
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.email') }}</label>
                                                        <div class="input-group">
                                                            <input name="email[]" id="email[]" class="form-control" type="text"
                                                                placeholder="{{ __('messages.email') }}"
                                                                required="required">
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.website') }}</label>
                                                        <div class="input-group">
                                                            <input name="web_page[]" id="web_page[]" class="form-control"
                                                                type="text" placeholder="{{ __('messages.website') }}"
                                                                required="required">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 text-center">
                                                <a href="javascript:;" id="agregar" class="btn" style="background: {{$configuracion->color_boton_add}}; color: #ffff">{{ __('messages.contact') }} +</a>
                                            </div>
                                        </div>

                                        <!-- Card Address  -->
                                        <div class="card mt-4">
                                            <div class="card-header d-flex">
                                                <h5>{{ __('messages.address') }} {{ __('messages.client') }}</h5>
                                            </div>
                                            <div class="card-body pt-0" id="address_client">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.address') }}</label>
                                                        <div class="input-group">
                                                            <textarea class="form-control" name="address[]" id="address[]" rows="1"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.billing_address') }}</label>
                                                        <div class="input-group">
                                                            <textarea class="form-control" name="billing_address[]" id="billing_address[]" rows="1"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 text-center">
                                                <a href="javascript:;" id="agregar_address" class="btn" style="background: {{$configuracion->color_boton_add}}; color: #ffff">{{ __('messages.address') }} +</a>
                                            </div>
                                        </div>

                                        <!-- Card Phone -->
                                        <div class="card mt-4">
                                            <div class="card-header d-flex">
                                                <h5>{{ __('messages.phone') }} {{ __('messages.client') }}</h5>
                                            </div>
                                            <div class="card-body pt-0" id="phone_client">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="form-label">{{ __('messages.phone') }}</label>
                                                        <div class="input-group">
                                                            <input name="phone[]" id="phone[]" class="form-control"
                                                            type="number" placeholder="{{ __('messages.phone') }}"
                                                            required="required">
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label class="form-label">Fax</label>
                                                        <div class="input-group">
                                                            <input name="fax[]" id="fax[]" class="form-control"
                                                            type="number" placeholder="Fax"
                                                            required="required">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="col-12 text-center">
                                                    <a href="javascript:;" id="agregar_phone" class="btn" style="background: {{$configuracion->color_boton_add}}; color: #ffff">{{ __('messages.phone') }} +</a>
                                                </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                    </main>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js_custom')
    <script type="text/javascript">
        $('#agregar').click(function(){
            agregar();
        });

        function agregar(){

            var fila='<hr>'+
                    '<div class="row">'+
                        '<div class="col-6">' +
                            '<label class="form-label">{{ __('messages.contact_name')}}</label>' +
                            '<div class="input-group">' +
                                '<input name="name[]" id="name[]" class="form-control" type="text" placeholder="{{ __('messages.contact_name') }}" required="required">'+
                            '</div>'+
                        '</div>'+

                        '<div class="col-6">'+
                            '<label class="form-label">{{ __('messages.short_name') }}</label>'+
                            '<div class="input-group">'+
                                '<input name="short_name[]" id="short_name[]" class="form-control" type="text" placeholder="{{ __('messages.short_name') }}" required="required">'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row">'+
                        '<div class="col-6">'+
                            '<label class="form-label">{{ __('messages.position')}}</label>'+
                            '<div class="input-group">'+
                                '<input name="position[]" id="position[]" class="form-control" type="text" placeholder="{{ __('messages.position') }}" required="required">'+
                            '</div>'+
                        '</div>'+

                        '<div class="col-6">'+
                            '<label class="form-label">{{ __('messages.email') }}</label>'+
                            '<div class="input-group">'+
                                '<input name="email[]" id="email[]" class="form-control" type="text" placeholder="{{ __('messages.email') }}" required="required">'+
                            '</div>'+
                        '</div>'+

                        '<div class="col-6">'+
                            '<label class="form-label">{{ __('messages.website') }}</label>'+
                            '<div class="input-group">'+
                                '<input name="web_page[]" id="web_page[]" class="form-control" type="text" placeholder="{{ __('messages.website') }}" required="required">'+
                            '</div>'+
                        '</div>'+

                    '</div>';

            $('#contact').append(fila);
        }
    </script>

    <script type="text/javascript">
        $('#agregar_address').click(function(){
            agregar_address();
        });

        function agregar_address(){

            var fila='<hr>'+
                    '<div class="row">'+
                        '<div class="col-6">'+
                            '<label class="form-label">{{ __('messages.address') }}</label>'+
                            '<div class="input-group">'+
                                '<textarea class="form-control" name="address[]" id="address[]" rows="1"></textarea>'+
                            '</div>'+
                        '</div>'+

                        '<div class="col-6">'+
                            '<label class="form-label">{{ __('messages.billing_address') }}</label>'+
                            '<div class="input-group">'+
                                '<textarea class="form-control" name="billing_address[]" name="billing_address[]" rows="1"></textarea>'+
                            '</div>'+
                        '</div>'+
                    '</div>';

            $('#address_client').append(fila);
        }
    </script>

    <script type="text/javascript">
        $('#agregar_phone').click(function(){
            agregar_phone();
        });

        function agregar_phone(){

            var fila='<hr>'+
                    '<div class="row">'+
                        '<div class="col-6">'+
                            '<label class="form-label">{{ __('messages.phone') }}</label>'+
                            '<div class="input-group">'+
                                '<input name="phone[]" id="phone[]" class="form-control" type="number" placeholder="{{ __('messages.phone') }}" required="required">'+
                            '</div>'+
                        '</div>'+

                        '<div class="col-6">'+
                            '<label class="form-label">Fax</label>'+
                            '<div class="input-group">'+
                                '<input name="fax[]" id="fax[]" class="form-control" type="number" placeholder="Fax" required="required">'+
                            '</div>'+
                        '</div>'+
                    '</div>';

            $('#phone_client').append(fila);
        }
    </script>
@endsection
