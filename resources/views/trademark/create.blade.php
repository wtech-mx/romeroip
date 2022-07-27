@extends('layouts.app')

@section('template_title')
    Crear cliente
@endsection

@section('content')

<div class="container-fluid mt-3">
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <h3 class="mb-3">Crear Watemark</h3>
               <a class="btn" href="javascript: history.go(-1)" style="background: {{$configuracion->color_boton_close}}; color: #ffff"> Back</a>
                    @includeif('partials.errors')
            </div>

            <div class="card-body">
                  @include('trademark.ejemplo2')
            </div>

          </div>
        </div>
      </div>
</div>


@endsection
