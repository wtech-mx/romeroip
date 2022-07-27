@extends('layouts.app')

@section('template_title')
    Crear cliente
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
                  <h5 class="mb-0">ALL TRADEMARKS</h5>
                  <p class="text-sm mb-0">

                  </p>
                </div>
                
                <div class="ms-auto my-auto mt-lg-0 mt-4">
                  <div class="ms-auto my-auto">
                    <a href="/trademarks/create" class="btn bg-gradient-primary btn-sm mb-0" target="">+&nbsp; New Trademark</a>
                    <button type="button" class="btn btn-outline-primary btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#import">
                      Import
                    </button>
                    <div class="modal fade" id="import" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog mt-lg-10">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel">Import CSV</h5>
                            <i class="fas fa-upload ms-3"></i>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <p>You can browse your computer for a file.</p>
                            <input type="text" placeholder="Browse file..." class="form-control mb-3">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" value="" id="importCheck" checked="">
                              <label class="custom-control-label" for="importCheck">I accept the terms and conditions</label>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn bg-gradient-primary btn-sm">Upload</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <button class="btn btn-outline-primary btn-sm export mb-0 mt-sm-0 mt-1" data-type="csv" type="button" name="button">Export</button>
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
                      <th>Our Ref.</th>
                      <th>Trademark Name</th>
                      <th>Class</th>
                      <th>Application No.</th>
                      <th>Filing Date</th>
                      <th>Registration No.</th>
                      <th>Registration Date	</th>
                      <th>Declaration of Use</th>
                      <th>Status</th>
                      <th>Action</th>
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
