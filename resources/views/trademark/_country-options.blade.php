@php
    // Reuse the project's country catalog with real values, without duplicating Mexico.
    preg_match_all('/<option[^>]*>([^<]+)/', file_get_contents(resource_path('views/client/paises.blade.php')), $countryMatches);
    $countries = array_values(array_unique(array_map('trim', $countryMatches[1])));
    $currentCountry = trim((string) ($currentCountry ?? ''));
    $knownCountry = false;
@endphp
<option value="" {{ $currentCountry === '' ? 'selected' : '' }}>Select</option>
@foreach($countries as $countryName)
    @php
        $isSelected = strcasecmp($countryName, $currentCountry) === 0;
        $knownCountry = $knownCountry || $isSelected;
    @endphp
    <option value="{{ $isSelected ? $currentCountry : $countryName }}" {{ $isSelected ? 'selected' : '' }}>{{ $countryName }}</option>
@endforeach
@if($currentCountry !== '' && !$knownCountry)
    <option value="{{ $currentCountry }}" selected>{{ $currentCountry }}</option>
@endif
