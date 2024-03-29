@extends('layouts.app')

@section('template_title')
{{ __('messages.update') }} {{ __('messages.holder') }}
@endsection

@section('content')

<div class="container-fluid mt-3">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <form method="POST" action="{{ route('update.holder', $holder->id) }}" enctype="multipart/form-data"
                    role="form">
                    @csrf
                    <div class="card-header">
                        <h3 class="mb-3">{{ __('messages.update') }} {{ __('messages.holder') }}</h3>
                        <a class="btn" href="{{ route('index.holder') }}"
                            style="background: {{$configuracion->color_boton_close}}; color: #ffff"> {{ __('messages.back') }}</a>
                        @includeif('partials.errors')
                        <button type="submit" class="btn"
                        style="border: 2px solid #F82018; color: #F82018;">{{ __('messages.update') }}</button>
                    </div>

                    <main class="main-content max-height-vh-100 h-100">

                        <input type="hidden" name="_method" value="PATCH">
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
                                                            required="required" value="{{$holder->company_name}}">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">{{ __('messages.country') }}</label>
                                                    <div class="input-group">
                                                        <select class="form-control js-example-basic-single" name="country" id="country">
                                                            <option value="{{$holder->country}}">{{$holder->country}}
                                                            </option>
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
                                        <div class="card-body pt-0" id="address_holder">
                                            <div class="row">
                                                @foreach ($address_holder as $address)
                                                <div class="col-6">
                                                    <label class="form-label">{{ __('messages.address') }}</label>
                                                    <div class="input-group">
                                                        <textarea class="form-control" name="address[]" id="address[]" rows="5">{{$address->address}}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-6 input_fac">
                                                    <label class="form-label">{{ __('messages.industrial_address')}}</label>
                                                    <div class="input-group">
                                                        <textarea class="form-control" name="commercial_address[]" id="commercial_address[]" rows="5">{{$address->address}}</textarea>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <a href="javascript:;" id="agregar_address2" class="btn" style="border: 2px solid #F82018; color: #F82018; margin-left: 25px;">{{ __('messages.address') }} +</a>
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
    $('#agregar_address2').click(function(){
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
                            '<label class="form-label">{{ __('messages.industrial_address') }}</label>'+
                            '<div class="input-group">'+
                                '<textarea class="form-control" name="commercial_address[]" id="commercial_address[]" rows="1"></textarea>'+
                            '</div>'+
                        '</div>'+
                    '</div>';

            $('#address_holder').append(fila);
        }
</script>

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>
@endsection
