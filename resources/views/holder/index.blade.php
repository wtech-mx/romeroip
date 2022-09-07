@extends('layouts.app')
@section('page_actuality')
{{ __('messages.holder') }}
@endsection

@section('content')

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            {{ __('messages.holder') }}
                        </span>

                         <div class="float-right">
                            <a href="{{ route('create.holder') }}" class="btn btn-sm float-right"  data-placement="left" style="background: {{$configuracion->color_boton_add}}; color: #ffff">
                              {{ __('messages.new') }} {{ __('messages.holder') }}
                            </a>
                          </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table_id">
                            <thead class="thead">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>{{ __('messages.company_name') }}</th>
                                    <th>{{ __('messages.country') }}</th>
                                    <th>{{ __('messages.note') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($holder as $holders)
                                    <tr class="text-center">

                                        <td>{{ $holders->id }}</td>
                                        <td>{{ $holders->company_name }}</td>
                                        <td>{{ $holders->country }}</td>
                                        <td>{{ $holders->notas }}</td>

                                        <td>
                                            <a class="dropdown-item" href="{{ route('edit.holder', $holders->id) }}">
                                                Editar
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
