@php
    $readOnly = $readOnly ?? false;
    $newFile = $newFile ?? false;
@endphp
@foreach(\App\Support\TrademarkFileLayout::sections() as $fileSection)
    <section class="tm-section tm-approved-section" id="{{ $fileSection['id'] }}">
        <h2 class="tm-section-heading"><span>{{ $fileSection['number'] }} |</span> {{ $fileSection['title'] }}</h2>
        <div class="tm-split-tables">
            @foreach($fileSection['columns'] as $column)
                <div class="tm-field-column">
                    @foreach($column as $fileField)
                        @php
                            $key = $fileField['key'];
                            $default = $newFile ? ($key === 'our_ref' ? $nextOurRef : $fileField['default']) : $trademark->{$key};
                            $value = $readOnly ? $default : old($key, $default);
                            if ($fileField['type'] === 'date' && filled($value)) {
                                try { $value = \Carbon\Carbon::parse($value)->format($readOnly ? 'M/d/Y' : 'Y-m-d'); }
                                catch (\Throwable $error) { /* Keep validation input available. */ }
                            }
                            if ($readOnly && $fileField['type'] === 'origin') $value = \App\Support\TrademarkOrigin::label($value);
                            if ($readOnly && $fileField['type'] === 'status') $value = \App\Support\TrademarkStatus::label($value);
                            if ($readOnly && $fileField['type'] === 'country' && strcasecmp((string) $value, 'mexico') === 0) $value = 'Mexico';
                        @endphp
                        <div class="tm-field {{ $fileField['emphasis'] ? 'tm-field-emphasis' : '' }} {{ !$readOnly && !$newFile && $key === 'client_ref' ? 'autocomplete-wrap' : '' }}" data-field="{{ $key }}">
                            @if($readOnly)
                                <span class="tm-label">{{ $fileField['label'] }}</span>
                                <p class="tm-value {{ !filled($value) ? 'tm-empty-value' : '' }}">{{ filled($value) ? $value : '—' }}</p>
                            @else
                                <label class="tm-label" for="{{ $fileField['id'] }}">{{ $fileField['label'] }}</label>
                                <div class="tm-control">
                                    @if(in_array($fileField['type'], ['country', 'status', 'origin'], true))
                                        <select id="{{ $fileField['id'] }}" name="{{ $key }}" class="form-control tm-select {{ in_array($key, ['country', 'contracting_organization'], true) ? 'js-example-basic-single' : '' }}">
                                            @if($fileField['type'] === 'country')
                                                @include('trademark._country-options', ['currentCountry' => $value])
                                            @elseif($fileField['type'] === 'status')
                                                @include('trademark._status-options', ['currentStatus' => $value])
                                            @else
                                                @include('trademark._origin-options', ['currentOrigin' => $value])
                                            @endif
                                        </select>
                                    @else
                                        <input id="{{ $fileField['id'] }}" name="{{ $key }}" class="form-control tm-input {{ $fileField['type'] === 'date' ? 'date-mask' : '' }}" type="{{ $fileField['type'] === 'date' ? 'date' : 'text' }}" value="{{ $value }}" @if($fileField['limit']) maxlength="{{ $fileField['limit'] }}" @endif @if(in_array($key, ['our_ref', 'application_no', 'registration_no'], true)) inputmode="numeric" pattern="[1-9][0-9]{0,{{ $fileField['limit'] - 1 }}}" @endif @if($key === 'client_ref') autocomplete="off" @endif>
                                    @endif
                                    @if(!$newFile && $key === 'client_ref')
                                        <div id="client_ref_suggestions" class="autocomplete-box d-none"></div>
                                    @endif
                                </div>
                            @endif
                        </div>
                        @if($fileField['spacer'])
                            <div class="tm-spacer-row" aria-hidden="true" data-spacer-after="{{ $key }}"></div>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
    </section>
@endforeach
