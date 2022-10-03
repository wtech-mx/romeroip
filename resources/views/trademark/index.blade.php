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
                  <h5 class="mb-0">{{ __('messages.all_trademark') }}</h5>
                  <p class="text-sm mb-0">

                  </p>
                </div>

                <div class="ms-auto my-auto mt-lg-0 mt-4">
                  <div class="ms-auto my-auto">
                    <a href="{{ route('create.trademarks') }}" class="btn btn-outline-primary btn-sm export mb-0 mt-sm-0 mt-1" data-type="csv" type="button" name="button">+&nbsp; {{ __('messages.new_trademark') }}</a>
                    <button class="btn btn-outline-primary btn-sm export mb-0 mt-sm-0 mt-1" data-type="csv" type="button" name="button">{{ __('messages.export') }}</button>
                  </div>
                </div>

              </div>
            </div>

            <div class="card-body px-0 pb-0" style="padding-top: 1rem;">
              <div class="table-responsive">
                <table class="table table-flush" id="products-list">
                  <thead class="thead-light">
                    <tr>
                      <th>#</th>
                      <th>{{ __('messages.our_ref') }}</th>
                      <th>{{ __('messages.trademark_name') }}</th>
                      <th>{{ __('messages.class') }}</th>
                      <th>{{ __('messages.application_no') }}</th>
                      <th>{{ __('messages.filing_date') }}</th>
                      <th>{{ __('messages.registration_no') }}</th>
                      <th>{{ __('messages.registration_date') }}</th>
                      <th>{{ __('messages.declaration_use') }}</th>
                      <th>{{ __('messages.status') }}</th>
                      <th>{{ __('messages.action') }}</th>
                    </tr>
                  </thead>

                  <tbody>
                        @foreach ($trademarks as $trademark)
                            <tr>
                            <td class="text-center ">
                                <div class="form-check" style="left: 20px; position: absolute;">
                                    <input class="form-check-input" type="checkbox" value="" id="fcustomCheck1" >
                                </div>
                            </td>
                            <td class="text-center">{{ $trademark->our_ref }}</td>
                            <td class="text-center">{{ $trademark->trademark }}</td>
                            <td class="text-center">{{ $trademark->class }}</td>
                            <td class="text-center">{{ $trademark->application_no }}</td>
                            <td class="text-center">{{ $trademark->filing_date_opposition }}</td>
                            <td class="text-center">{{ $trademark->registration_no }}</td>
                            <td class="text-center">{{ $trademark->registration_date }}</td>
                            <td class="text-center">{{ $trademark->last_declaration }}</td>
                            <td class="text-center">{{ $trademark->status }}</td>
                            <td class="text-sm">
                                <a href="{{ route('edit.trademarks', $trademark->id) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit product">
                                <i class="fas fa-user-edit text-secondary"></i>
                                </a>
                                <a href="javascript:;" data-bs-toggle="tooltip" data-bs-original-title="Delete product">
                                <i class="fas fa-trash text-secondary"></i>
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
