@extends('layouts.app')
@section('page_actuality')
{{ __('messages.client') }}
@endsection

@section('content')

@include('client.search')

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-sm-12">
            <div id="client-results">
                @include('client._results')
            </div>
        </div>
    </div>
</div>
@endsection

@section('js_custom')
<script>
$(function () {
    const $form = $('#client-search-form');
    const $results = $('#client-results');
    const $submit = $form.find('[type="submit"]');

    function loadClients(url, data) {
        $submit.prop('disabled', true);
        $results.css('opacity', '0.55');

        $.ajax({
            url: url,
            method: 'GET',
            data: data,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function (html) {
                $results.html(html);
            },
            error: function () {
                alert('No se pudo realizar la busqueda. Intenta nuevamente.');
            },
            complete: function () {
                $submit.prop('disabled', false);
                $results.css('opacity', '1');
            }
        });
    }

    $form.on('submit', function (event) {
        event.preventDefault();
        loadClients($form.attr('action'), $form.serialize());
    });

    $results.on('click', '.pagination a', function (event) {
        event.preventDefault();
        loadClients($(this).attr('href'), {});
    });
});
</script>
@endsection
