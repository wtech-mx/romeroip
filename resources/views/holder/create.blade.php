@extends('layouts.app')

@section('page_actuality')
{{ __('messages.new') }} {{ __('messages.holder') }}
@endsection

@section('content')
<div class="container-fluid mt-3">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <form method="POST" action="{{ route('store.holder') }}" enctype="multipart/form-data" role="form">
                    @csrf
                    <div class="card-header">
                        <h3 class="mb-3">{{ __('messages.new') }} {{ __('messages.holder') }}</h3>
                        <a class="btn" href="{{ route('index.holder') }}"
                            style="background: {{$configuracion->color_boton_close}}; color: #ffff"> {{ __('messages.back') }}</a>
                        @includeif('partials.errors')
                        <button type="submit" class="btn"
                            style="border: 2px solid #F82018; color: #F82018;">{{ __('messages.save') }}</button>
                    </div>

                    <main class="main-content max-height-vh-100 h-100">
                        <div class="container-fluid">
                            <div class="row mb-5">

                                <div class="col-lg-9 mt-lg-0 mt-4">
                                    <!-- Card holder -->
                                    <div class="card mt-4" id="profile">
                                        <div class="card-header">
                                            <h5>{{ __('messages.holder_info') }}</h5>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="form-label">{{ __('messages.holder') }}</label>
                                                    <div class="input-group">
                                                        <input name="company_name" id="company_name"
                                                            class="form-control" type="text"
                                                            placeholder="{{ __('messages.holder') }}"
                                                            required="required">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">{{ __('messages.country') }}</label>
                                                    <div class="input-group">
                                                        <select class="form-control js-example-basic-single" name="country" id="country">
                                                            <option selected>{{ __('messages.select') }}</option>
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
                                            <h5>{{ __('messages.address') }} {{ __('messages.information') }}</h5>
                                        </div>
                                        <div class="card-body pt-0" id="address_client">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="form-label">{{ __('messages.address') }}</label>
                                                    <div class="input-group">
                                                        <textarea class="form-control" name="address[]" id="address[]" rows="5"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-6 input_fac">
                                                    <label class="form-label">{{ __('messages.industrial_address')}}</label>
                                                    <div class="input-group">
                                                        <textarea class="form-control" name="commercial_address[]" id="commercial_address[]" rows="5"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <a href="javascript:;" id="agregar_address" class="btn" style="border: 2px solid #F82018; color: #F82018; margin-left: 25px;">{{ __('messages.address') }} +</a>
                                            </div>
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
    $('#agregar_address').click(function(){
            agregar_address();
        });

        function agregar_address(){

            var fila='<hr>'+
            '<div class="row">'+
                        '<div class="col-6">'+
                            '<label class="form-label">{{ __('messages.address') }}</label>'+
                            '<div class="input-group">'+
                                '<textarea class="form-control" name="address[]" id="address[]" rows="5"></textarea>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-6">'+
                            '<label class="form-label">{{ __('messages.industrial_address') }}</label>'+
                            '<div class="input-group">'+
                                '<textarea class="form-control" name="commercial_address[]" id="commercial_address[]" rows="5"></textarea>'+
                            '</div>'+
                        '</div>'+
                    '</div>';

            $('#address_client').append(fila);
        }
</script>

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>
@endsection
