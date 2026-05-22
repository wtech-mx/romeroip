@php
    $hasSearch = isset($clients);
    $totalClients = $hasSearch ? $clients->total() : 0;
@endphp

<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h5 class="mb-0">{{ __('messages.all_trademark') }}: {{ $totalClients }}</h5>
                @if($hasSearch)
                    <p class="text-sm mb-0">
                        @if($totalClients > 0)
                            Se encontraron {{ $totalClients }} resultado{{ $totalClients === 1 ? '' : 's' }}.
                        @else
                            No se encontraron resultados con esos filtros.
                        @endif
                    </p>
                @endif
            </div>

            <div class="float-right">
                <a href="{{ route('create.clients') }}" class="btn btn-sm float-right" data-placement="left" style="background-color: #F82018; color: #ffffff;">
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
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clients ?? [] as $client)
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
                    @empty
                        <tr class="text-center">
                            <td colspan="5">
                                {{ $hasSearch ? 'Sin resultados para mostrar.' : 'Usa los filtros para buscar clientes.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($hasSearch && $clients->hasPages())
            <div class="mt-3">
                {{ $clients->links() }}
            </div>
        @endif
    </div>
</div>
