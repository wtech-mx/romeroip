<script type="application/json" id="tm-column-config">{!! json_encode([
    'definitions' => \App\Support\ResultsColumns::definitions(),
    'preferences' => \App\Support\ResultsColumns::normalize(auth()->user()->getAttribute('results_columns')),
    'url' => route('account.results'),
    'token' => csrf_token(),
], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
<script src="{{ asset('assets/js/trademark-columns.js') }}?v={{ filemtime(public_path('assets/js/trademark-columns.js')) }}"></script>
