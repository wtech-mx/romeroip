{{-- @php($trademarks = App\Models\Trademarks::all())
@livewire('trademarks.index') --}}
@extends('layouts.app')

@section('content')

@include('filtros')

<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- Card header -->
            <div class="card-header pb-0">
              <div class="d-lg-flex">
                <div>
                    @if(Route::currentRouteName() != 'index.trademarks')
                    <h5 class="mb-0">{{ __('messages.all_trademark') }}: {{ $trademarks->count() }}</h5>
                    @else
                    <h5 class="mb-0">{{ __('messages.all_trademark') }}: 0</h5>
                    @endif
                  <p class="text-sm mb-0">

                  </p>
                </div>

                <div class="ms-auto my-auto mt-lg-0 mt-4">
                  <div class="ms-auto my-auto">
                    <a href="{{ route('create.trademarks') }}" class="btn btn-sm mb-0 mt-sm-0 mt-1" style="border: 2px solid #F82018; color: #F82018;" data-type="csv" type="button" name="button">&nbsp; {{ __('messages.new_trademark') }}</a>
                    <button class="btn btn-sm mb-0 mt-sm-0 mt-1" style="background: #F82018; color: #fff;" data-type="csv" type="button" name="button">{{ __('messages.export') }}</button>
                  </div>
                </div>

              </div>
            </div>

            <div class="card-body px-0 pb-0" style="padding-top: 1rem;">
              <div class="table-responsive">
                <table class="table table-flush" id="products-list">
                  <thead class="thead-light">
                    <tr style="font-size: 13px;">
                      <th>#</th>
                      <th>{{ __('messages.our_ref') }}</th>
                      <th>{{ __('messages.trademark') }}</th>
                      <th>{{ __('messages.class') }}</th>
                      <th>{{ __('messages.application_no') }}</th>
                      <th>{{ __('messages.registration_no') }}</th>
                      <th>{{ __('messages.registration_date') }}</th>
                      <th>{{ __('messages.declaration_use') }}</th>
                      <th>{{ __('messages.renewal') }}</th>
                      <th>{{ __('messages.holder') }}</th>
                      <th>{{ __('messages.client') }}</th>
                      <th>{{ __('messages.client_ref') }}</th>
                      <th>{{ __('messages.origin') }}</th>
                      <th>{{ __('messages.status') }}</th>
                      <th>{{ __('messages.action') }}</th>
                    </tr>
                  </thead>

                  <tbody>
                   @if(Route::currentRouteName() != 'index.trademarks')
                        @foreach ($trademarks as $trademark)
                            <tr style="font-size: 12px;">
                             <td class="text-center ">
                                <div class="form-check" style="">
                                    <input class="form-check-input" type="checkbox"  >
                                </div>
                            </td>
                            <td class="text-center">{{ $trademark->our_ref }}</td>
                            <td class="text-center">{{ $trademark->trademark }}</td>
                            <td class="text-center">{{ $trademark->class }}</td>
                            <td class="text-center">{{ $trademark->application_no }}</td>
                            <td class="text-center">{{ $trademark->registration_no }}</td>
                            <td class="text-center">{{ $trademark->registration_date }}</td>
                            <td class="text-center">{{ $trademark->last_declaration }}</td>
                            <td class="text-center">{{ $trademark->last_renewal }}</td>
                                @if ($trademark->id_holder == NULL)
                                    <td class="text-center"></td>
                                @else
                                <td class="text-center"></td>
                                    {{-- <td class="text-center">{{$trademark->Holder->company_name}}</td> --}}
                                @endif

                                @if ($trademark->id_client == NULL)
                                    <td class="text-center"></td>
                                @else
                                <td class="text-center"></td>
                                    {{-- <td class="text-center">{{$trademark->Client->company_name}}</td> --}}
                                @endif
                            <td class="text-center">{{ $trademark->client_ref }}</td>
                            <td class="text-center">{{ $trademark->origin }}</td>
                            <td class="text-center">{{ $trademark->status }}</td>
                            <td class="text-sm">
                                <a href="{{ route('edit.trademarks', $trademark->id) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit product">
                                <i class="fas fa-user-edit text-secondary"></i>
                                </a>
                                {{-- <a href="javascript:;" data-bs-toggle="tooltip" data-bs-original-title="Delete product">
                                <i class="fas fa-trash text-secondary"></i>
                                </a> --}}
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
