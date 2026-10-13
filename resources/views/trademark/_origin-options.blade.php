@php($originValue = \App\Support\TrademarkOrigin::label($currentOrigin))
<option value="" {{ $originValue === '' ? 'selected' : '' }}>Select</option>
<option value="National" {{ $originValue === 'National' ? 'selected' : '' }}>National</option>
<option value="International" {{ $originValue === 'International' ? 'selected' : '' }}>International</option>
@if($originValue !== '' && !in_array($originValue, ['National', 'International'], true))
    <option value="{{ $currentOrigin }}" selected>{{ $currentOrigin }}</option>
@endif
