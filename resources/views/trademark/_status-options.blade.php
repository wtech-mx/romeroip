@php
    $currentStatus = (string) $currentStatus;
    $statusKey = \App\Support\TrademarkStatus::key($currentStatus);
    $statusChoices = ['registered', 'pending', 'abandoned', 'lapsed', 'inactive'];
@endphp
@if($statusKey !== '' && !in_array($statusKey, $statusChoices, true))
    <option value="{{ $currentStatus }}" selected>{{ \App\Support\TrademarkStatus::label($currentStatus) }}</option>
@elseif($statusKey === '')
    <option value="" selected>{{ __('messages.select') }}</option>
@endif
@foreach($statusChoices as $choice)
    <option value="{{ $statusKey === $choice ? $currentStatus : __('messages.' . $choice) }}" {{ $statusKey === $choice ? 'selected' : '' }}>{{ ucfirst($choice) }}</option>
@endforeach
