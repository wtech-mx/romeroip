@php
    // Names stay as values: existing files store country names, not ISO codes.
    $rows = array_map('str_getcsv', file(resource_path('data/kept01_countries_territories.csv'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
    array_shift($rows);
    $catalogCountries = array_column($rows, 0);
    $savedCountries = \App\Models\Trademarks::whereNotNull('country')->distinct()->pluck('country')->all();
    $countryNames = [];
    foreach (array_filter(array_merge($catalogCountries, $savedCountries, [(string) request('country')])) as $name) {
        $countryNames[mb_strtolower(trim($name))] = $countryNames[mb_strtolower(trim($name))] ?? $name;
    }
    natcasesort($countryNames);
@endphp
@foreach($countryNames as $countryName)
    <option value="{{ $countryName }}" {{ strcasecmp((string) request('country'), $countryName) === 0 ? 'selected' : '' }}>{{ $countryName }}</option>
@endforeach
