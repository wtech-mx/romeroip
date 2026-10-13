@php
    $currentStatus = (string) $currentStatus;
    $statusKey = \App\Support\TrademarkStatus::key($currentStatus);
    $statusChoices = ['pending', 'registered', 'abandoned'];
@endphp
<option value="" {{ $statusKey === '' ? 'selected' : '' }}>Select</option>
@if($statusKey !== '' && !in_array($statusKey, $statusChoices, true))
    <option value="{{ $currentStatus }}" selected>{{ \App\Support\TrademarkStatus::label($currentStatus) }}</option>
@endif
@foreach($statusChoices as $choice)
    <option value="{{ $statusKey === $choice ? $currentStatus : ucfirst($choice) }}" {{ $statusKey === $choice ? 'selected' : '' }}>{{ ucfirst($choice) }}</option>
@endforeach
