@php
    $offices = $offices ?? false;
    $selectedCountry = (string) ($currentCountry ?? '');
    $selectedCode = \App\Support\CountryCatalog::code($selectedCountry, $offices);
@endphp
<option value="" @selected($selectedCountry === '')>Select</option>
@foreach(\App\Support\CountryCatalog::entries($offices) as $code => $name)
    {{-- Preserve a saved value exactly; ISO metadata identifies the catalog entry. --}}
    <option value="{{ $selectedCode === $code ? $selectedCountry : $name }}" data-country-code="{{ $code }}" @selected($selectedCode === $code)>{{ $name }}</option>
@endforeach
@if($selectedCountry !== '' && !$selectedCode)
    <option value="{{ $selectedCountry }}" selected>{{ $selectedCountry }}</option>
@endif
