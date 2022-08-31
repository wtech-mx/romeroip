@extends('layouts.app')
@section('page_actuality')
{{ __('messages.client') }}
@endsection

@section('content')

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            {{ __('messages.client') }}
                        </span>

                         <div class="float-right">
                            <a href="{{ route('create.clients') }}" class="btn btn-sm float-right"  data-placement="left" style="background: {{$configuracion->color_boton_add}}; color: #ffff">
                              {{ __('messages.new_client') }}
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
                                    <th>R.F.C.</th>
                                    <th>{{ __('messages.country') }}</th>
                                    <th>{{ __('messages.note') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)
                                    <tr class="text-center">

                                        <td>{{ $client->id }}</td>
                                        <td>{{ $client->company_name }}</td>
                                        <td>{{ $client->vat_no }}</td>
                                        <td>{{ $client->country }}</td>
                                        <td>{{ $client->notes }}</td>

                                        <td>
                                            <a class="dropdown-item" href="{{ route('edit.clients', $client->id) }}">
                                                Editar
                                            </a>
                                            {{-- <form action="{{ route('delete.clients',$client->id) }}" method="POST">
                                                {{csrf_field() }}
                                                <input type="hidden" name="_method" value="DELETE">
                                                <a class="btn" type="submit">Borrar</a>
                                            </form> --}}
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
