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
              <h3 class="mb-3">Crear cliente</h3>
               <a class="btn" href="{{ route('clients.index') }}" style="background: {{$configuracion->color_boton_close}}; color: #ffff"> Atrás</a>
                    @includeif('partials.errors')
            </div>

            <div class="card-body mb-5">

            <ul class="nav nav-tabs" id="myTab" role="tablist">

              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Ejemplo 2</button>
              </li>

              <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Ejemplo 3</button>
              </li>

              <li class="nav-item" role="presentation">
                <button class="nav-link" id="ejemplo4-tab" data-bs-toggle="tab" data-bs-target="#ejemplo4-tab-pane" type="button" role="tab" aria-controls="ejemplo4-tab-pane" aria-selected="false">Ejemplo 4</button>
              </li>

            </ul>

            <div class="tab-content" id="myTabContent">

              <div class="tab-pane fade show active" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                  @include('trademark.ejemplo2')
              </div>

              <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                 @include('trademark.ejemplo3')
              </div>

              <div class="tab-pane fade" id="ejemplo4-tab-pane" role="tabpanel" aria-labelledby="ejemplo4-tab" tabindex="0">
                 @include('trademark.ejemplo4')
              </div>

            </div>

            </div>

          </div>
        </div>
      </div>
</div>


@endsection
