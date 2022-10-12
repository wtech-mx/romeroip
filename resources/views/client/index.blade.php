@extends('layouts.app')
@section('page_actuality')
{{ __('messages.client') }}
@endsection

@section('content')

@include('client.search')

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        @if(Route::currentRouteName() != 'index.clients')
                        <h5 class="mb-0">{{ __('messages.all_trademark') }}: {{ $clients->count() }}</h5>
                        @else
                        <h5 class="mb-0">{{ __('messages.all_trademark') }}: 0</h5>
                        @endif

                         <div class="float-right">
                            <a href="{{ route('create.clients') }}" class="btn btn-sm float-right"  data-placement="left" style="background-color: #F82018; color: #ffffff;">
                              {{ __('messages.new_client') }}
                            </a>
                          </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="example">
                            <thead class="thead">
                                <tr class="text-center">
                                    <th>{{ __('messages.company_name') }}</th>
                                    <th>{{ __('messages.email') }}</th>
                                    <th>{{ __('messages.vat_no') }}</th>
                                    <th>{{ __('messages.country') }}</th>
                                    <th>{{ __('messages.action') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(Route::currentRouteName() != 'index.clients')
                                    @foreach ($clients as $client)
                                        <tr class="text-center">

                                            <td>{{ $client->company_name }}</td>
                                            <td>{{ $client->email }}</td>
                                            <td>{{ $client->vat_no }}</td>
                                            <td>{{ $client->country }}</td>

                                            <td>
                                                <a class="dropdown-item" href="{{ route('edit.clients', $client->id) }}">
                                                    <i class="fas fa-user-edit text-secondary"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
