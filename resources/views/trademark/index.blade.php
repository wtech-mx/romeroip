@extends('layouts.app')

@section('template_title')
{{ __('messages.all_trademark') }}
@endsection

@section('content')

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
                    <a href="https://wtech.com.mx/romeroip/trademarks/create" class="btn bg-gradient-primary btn-sm mb-0" target="">+&nbsp; {{ __('messages.new_trademark') }}</a>
                    {{-- <button type="button" class="btn btn-outline-primary btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#import">
                        {{ __('messages.import') }}
                    </button>
                    <div class="modal fade" id="import" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog mt-lg-10">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel">{{ __('messages.import') }} CSV</h5>
                            <i class="fas fa-upload ms-3"></i>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <p>{{ __('messages.text_import') }}</p>
                            <input type="text" placeholder="{{ __('messages.import_place') }}..." class="form-control mb-3">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="" id="importCheck" checked="">
                              <label class="custom-control-label" for="importCheck">{{ __('messages.import_check') }}</label>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary btn-sm" data-bs-dismiss="modal">{{ __('messages.close') }}</button>
                            <button type="button" class="btn bg-gradient-primary btn-sm">{{ __('messages.upload') }}</button>
                          </div>
                        </div>
                      </div>
                    </div> --}}
                    <button class="btn btn-outline-primary btn-sm export mb-0 mt-sm-0 mt-1" data-type="csv" type="button" name="button">{{ __('messages.export') }}</button>
                  </div>
                </div>

              </div>
            </div>

            <div class="card-body px-0 pb-0">
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
                    <tr>
                      <td class="text-center ">
                        <div class="form-check" style="left: 20px; position: absolute;">
                            <input class="form-check-input" type="checkbox" value="" id="fcustomCheck1" >
                        </div>
                      </td>
                      <td class="text-center">101</td>
                      <td class="text-center">Vencedor y Diseño</td>
                      <td class="text-center">30</td>
                      <td class="text-center">159967</td>
                      <td class="text-center">Jan/24/1980</td>
                      <td class="text-center">255822	</td>
                      <td class="text-center">Feb/04/1981	</td>
                      <td class="text-center">Jan/24/2025	</td>
                      <td>
                          <span class="badge badge-danger badge-sm">
                              Pendiente
                          </span>
                      </td>
                      <td class="text-sm">
                        <a href="javascript:;" data-bs-toggle="tooltip" data-bs-original-title="Preview product">
                          <i class="fas fa-eye text-secondary"></i>
                        </a>
                        <a href="javascript:;" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit product">
                          <i class="fas fa-user-edit text-secondary"></i>
                        </a>
                        <a href="javascript:;" data-bs-toggle="tooltip" data-bs-original-title="Delete product">
                          <i class="fas fa-trash text-secondary"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>

                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection
