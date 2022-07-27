@extends('layouts.app')

@section('template_title')
    Client
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('messages.client') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('clients.create') }}" class="btn btn-sm float-right"  data-placement="left" style="background: {{$configuracion->color_boton_add}}; color: #ffff">
                                  {{ __('messages.new_client') }}
                                </a>
                              </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table_id">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        <th>{{ __('messages.company_name') }}</th>
										<th>{{ __('messages.contact_name') }}</th>
										<th>{{ __('messages.email') }}</th>
										<th>{{ __('messages.phone') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clients as $client)
                                        <tr>
                                            <td>{{ ++$i }}</td>

											<td>{{ $client->nombre_compañia }}</td>
											<td>{{ $client->nombre_corto }}</td>
											<td>{{ $client->email }}</td>
											<td>5539907266</td>

                                            <td>
                                                <div class="dropdown ">
                                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                      <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                        <form action="{{ route('clients.destroy',$client->id) }}" method="POST">
                                                            <a class="dropdown-item" href="{{ route('clients.show',$client->id) }}">
                                                                Ver
                                                            </a>
                                                            <a class="dropdown-item" href="{{ route('clients.edit',$client->id) }}">
                                                                Editar
                                                            </a>
                                                            @csrf
                                                            @method('DELETE')
                                                            <a class="dropdown-item">Borrar</a>
                                                        </form>
                                                    </div>
                                                  </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $clients->links() !!}
            </div>
        </div>
    </div>
@endsection
