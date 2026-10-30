@php
    // Names stay as values: existing files store country names, not ISO codes.
    $catalogCountries = array_values(\App\Support\CountryCatalog::entries(true));
    $savedCountries = \App\Models\Trademarks::whereNotNull('country')->distinct()->pluck('country')->all();
    $countryNames = [];
    foreach (array_filter(array_merge($catalogCountries, $savedCountries, [(string) request('country')])) as $name) {
        $name = \App\Support\CountryCatalog::label($name, true);
        $countryNames[mb_strtolower(trim($name))] = $countryNames[mb_strtolower(trim($name))] ?? $name;
    }
    natcasesort($countryNames);
@endphp
@foreach($countryNames as $countryName)
    <option value="{{ $countryName }}" {{ strcasecmp(\App\Support\CountryCatalog::label(request('country'), true), $countryName) === 0 ? 'selected' : '' }}>{{ $countryName }}</option>
@endforeach
