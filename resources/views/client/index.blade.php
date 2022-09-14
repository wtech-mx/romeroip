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
                        <table class="table table-striped table-hover" id="example">
                            <thead class="thead">
                                <tr class="text-center">
                                    <th>{{ __('messages.company_name') }}</th>
                                    <th>{{ __('messages.email') }}</th>
                                    <th>{{ __('messages.vat_no') }}</th>
                                    <th>{{ __('messages.country') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                 @foreach ($clients as $client)
                                    <tr class="text-center">

                                        <td>{{ $client->company_name }}</td>
                                        <td>{{ $client->email }}</td>
                                        <td>{{ $client->vat_no }}</td>
                                        <td>{{ $client->country }}</td>

                                        <td>
                                            <a class="dropdown-item" href="{{ route('edit.clients', $client->id) }}">
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
@section('js_custom')
<script>
$(document).ready(function () {
    // Setup - add a text input to each footer cell
    $('#example thead tr')
        .clone(true)
        .addClass('filters')
        .appendTo('#example thead');

    var table = $('#example').DataTable({
        orderCellsTop: true,
        fixedHeader: true,
        initComplete: function () {
            var api = this.api();

            // For each column
            api
                .columns()
                .eq(0)
                .each(function (colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters th').eq(
                        $(api.column(colIdx).header()).index()
                    );
                    var title = $(cell).text();
                    $(cell).html('<input type="text" placeholder="' + title + '" />');

                    // On every keypress in this input
                    $(
                        'input',
                        $('.filters th').eq($(api.column(colIdx).header()).index())
                    )
                        .off('keyup change')
                        .on('change', function (e) {
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})'; //$(this).parents('th').find('select').val();

                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search(
                                    this.value != ''
                                        ? regexr.replace('{search}', '(((' + this.value + ')))')
                                        : '',
                                    this.value != '',
                                    this.value == ''
                                )
                                .draw();
                        })
                        .on('keyup', function (e) {
                            e.stopPropagation();

                            $(this).trigger('change');
                            $(this)
                                .focus()[0]
                                .setSelectionRange(cursorPosition, cursorPosition);
                        });
                });
        },
    });
});
</script>
@endsection
