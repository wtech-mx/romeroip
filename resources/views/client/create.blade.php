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
                        <button type="submit" class="btn"
                            style="border: 2px solid #F82018; color: #F82018;">Save</button>
                    </div>

                    <main class="main-content max-height-vh-100 h-100">
                        <div class="container-fluid">
                            <div class="row mb-5">

                                <div class="col-lg-9 mt-lg-0 mt-4">
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
                                                        <input name="company_name" id="company_name"
                                                            class="form-control" type="text"
                                                            placeholder="{{ __('messages.company_name') }}"
                                                            required="required">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">{{ __('messages.website') }}</label>
                                                    <div class="input-group">
                                                        <input name="web_page" id="web_page" class="form-control"
                                                            type="text" placeholder="{{ __('messages.website') }}">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">{{ __('messages.vat_no') }}</label>
                                                    <div class="input-group">
                                                        <input name="vat_no" id="vat_no" class="form-control"
                                                            type="text" placeholder="{{ __('messages.vat_no') }}">
                                                    </div>
                                                </div>
                                                <div class="col-12">
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

                                    <!-- Card Address  -->
                                    <div class="card mt-4">
                                        <div class="card-header d-flex">
                                            <h5>{{ __('messages.address') }}</h5>
                                        </div>
                                        <div class="card-body pt-0" id="address_client">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="form-label">{{ __('messages.address') }}</label>
                                                    <div class="input-group">
                                                        <textarea class="form-control" name="address" id="address"
                                                            rows="5"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-6 input_fac" style="display: none;">
                                                    <label class="form-label">{{ __('messages.billing_address')
                                                        }}</label>
                                                    <div class="input-group">
                                                        <textarea class="form-control" name="billing_address"
                                                            id="billing_address" rows="5"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <a id="factura" class="btn"
                                                    style="border: 2px solid #F82018; color: #F82018; margin-left: 25px;">¿Dirección
                                                    de factura?</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Card Phone -->
                                    <div class="card mt-4">
                                        <div class="card-header d-flex">
                                            <h5>{{ __('messages.phone') }}</h5>
                                        </div>
                                        <div class="card-body pt-0" id="phone_client">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="form-label">{{ __('messages.phone') }}</label>
                                                    <div class="input-group">
                                                        <input name="phone[]" id="phone[]" class="form-control"
                                                            type="text" placeholder="{{ __('messages.phone') }}">
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <label class="form-label">Fax</label>
                                                    <div class="input-group">
                                                        <input name="fax[]" id="fax[]" class="form-control"
                                                            type="text" placeholder="Fax">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <a href="javascript:;" id="agregar_phone" class="btn"
                                            style="border: 2px solid #F82018; color: #F82018; margin-left: 25px;"">{{
                                                __('messages.phone') }} +</a>
                                        </div>
                                    </div>

                                    <!-- Card Contact -->
                                    <div class="card mt-4 mb-5">
                                        <div class="card-header">
                                            <h5>{{ __('messages.contact') }}</h5>
                                        </div>
                                        <div class="card-body pt-0" id="contact">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="form-label">{{ __('messages.contact_name')}}</label>
                                                    <div class="input-group">
                                                        <input name="name[]" id="name[]" class="form-control"
                                                            type="text" placeholder="{{ __('messages.contact_name') }}" required="required">
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <label class="form-label">{{ __('messages.short_name') }}</label>
                                                    <div class="input-group">
                                                        <input name="short_name[]" id="short_name[]"
                                                            class="form-control" type="text"
                                                            placeholder="{{ __('messages.short_name') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="form-label">{{ __('messages.position')}}</label>
                                                    <div class="input-group">
                                                        <input name="position[]" id="position[]" class="form-control"
                                                            type="text" placeholder="{{ __('messages.position') }}">
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <label class="form-label">{{ __('messages.email') }}</label>
                                                    <div class="input-group">
                                                        <input name="email[]" id="email[]" class="form-control"
                                                            type="text" placeholder="{{ __('messages.email') }}">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <a class="btn" value="{{__('messages.contact') }} +" id="add"
                                                style="border: 2px solid #F82018; color: #F82018; margin-left: 25px;"">{{__('messages.contact') }} +</a>
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
    $(document).ready(function(){
            var i=1;
        $('#add').click(function(){
            i++;
        $('#contact').append('<hr>'+
            '<div id="row'+i+'">'+
                '<div class="row">' +
                    '<div class="col-3">' +
                        '<h5>{{ __('messages.contact') }} '+i+'</h5>'+
                    '</div>'+
                    '<div class="col-3">' +
                        '<button name="remove" id="'+i+'" class="btn btn_remove" style="background: #F82018; color: #ffff">X</button>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-6">' +
                        '<label class="form-label">{{ __('messages.contact_name')}}</label>' +
                        '<div class="input-group">' +
                            '<input name="name[]" id="name[]" class="form-control" type="text" placeholder="{{ __('messages.contact_name') }}">'+
                        '</div>'+
                    '</div>'+

                    '<div class="col-6">'+
                        '<label class="form-label">{{ __('messages.short_name') }}</label>'+
                        '<div class="input-group">'+
                            '<input name="short_name[]" id="short_name[]" class="form-control" type="text" placeholder="{{ __('messages.short_name') }}">'+
                        '</div>'+
                    '</div>'+
                '</div>'+
                '<div class="row">'+
                    '<div class="col-6">'+
                        '<label class="form-label">{{ __('messages.position')}}</label>'+
                        '<div class="input-group">'+
                            '<input name="position[]" id="position[]" class="form-control" type="text" placeholder="{{ __('messages.position') }}">'+
                        '</div>'+
                    '</div>'+

                    '<div class="col-6">'+
                        '<label class="form-label">{{ __('messages.email') }}</label>'+
                        '<div class="input-group">'+
                            '<input name="email[]" id="email[]" class="form-control" type="text" placeholder="{{ __('messages.email') }}">'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</div>');
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });
    });
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
                                '<input name="phone[]" id="phone[]" class="form-control" type="text" placeholder="{{ __('messages.phone') }}">'+
                            '</div>'+
                        '</div>'+
                    '</div>';

            $('#phone_client').append(fila);
        }
</script>

<script type="text/javascript">

    $(document).ready(function(){
        $("#factura").click(function(){
            $(".input_fac").toggle("slide");
        });
    });
</script>
@endsection
