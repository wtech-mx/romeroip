@extends('layouts.app')

@section('template_title')
    {{ $client->name ?? 'Show Client' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Ver cliente</span>
                        </div>
                        <div class="float-right">
                            <a class="btn" href="{{ route('clients.index') }}" style="background: {{$configuracion->color_boton_close}}; color: #ffff"> Atrás</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
                                <strong>Nombre de la Compañia:</strong>
                                {{ $client->nombre_compañia }}
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
                                <strong>RFC:</strong>
                                {{ $client->rfc }}
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
                                <strong>Pais:</strong>
                                {{ $client->pais }}
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 mb-5">
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
                                <strong>Nombre del contacto:</strong>
                                {{ $client->nombre }}
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
                                <strong>Nombre corto:</strong>
                                {{ $client->nombre_corto }}
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
                                <strong>Posicion:</strong>
                                {{ $client->posicion }}
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
                                <strong>Email:</strong>
                                {{ $client->email }}
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
                                <strong>Página web:</strong>
                                {{ $client->pagina_web }}
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 mb-5">
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
                                <strong>Notas:</strong>
                                {{ $client->notas }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
