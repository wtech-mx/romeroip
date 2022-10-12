<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <form action="{{ route('advance_search.clients') }}" method="GET" >

                    <div class="card-header pb-0">
                        <div class="d-lg-flex">
                            <h5 class="mb-0">{{ __('messages.simple_search') }}</h5>
                            <p class="text-sm mb-0"></p>

                            <div class="ms-auto my-auto mt-lg-0 mt-4">
                                <div class="ms-auto my-auto">

                                    <button class="btn btn-sm mb-0 mt-sm-0 mt-1" type="submit" style="background-color: #F82018; color: #ffffff;">{{ __('messages.search') }}</button>
                                    {{-- @if(Route::currentRouteName() != 'index.trademarks')
                                    <a class="btn btn-sm mb-0 mt-sm-0 mt-1" href="{{ route('index.trademarks') }}" style="border: 2px solid #F82018; color: #F82018;"><i class="fa fa-refresh"></i></a>
                                    @endif --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body" style="padding-left: 1.5rem; padding-top: 1rem;">
                            <div class="row">
                                <div class="col-3">
                                    <label class="form-label">{{ __('messages.company_name') }}</label>
                                    <div class="input-group">
                                        <input name="company_name" class="form-control"
                                            type="search" placeholder="{{ __('messages.company_name') }}">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label class="form-label">{{ __('messages.email') }}</label>
                                    <div class="input-group">
                                        <input name="email" class="form-control"
                                            type="text" placeholder="{{ __('messages.email') }}">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label class="form-label">{{ __('messages.vat_no') }}.</label>
                                    <div class="input-group">
                                        <input name="vat_no" class="form-control"
                                            type="text" placeholder="{{ __('messages.vat_no') }}">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label class="form-label">{{ __('messages.country') }}</label>
                                    <div class="input-group">
                                        <input name="country" class="form-control"
                                            type="text" placeholder="{{ __('messages.country') }}">
                                    </div>
                                </div>
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
