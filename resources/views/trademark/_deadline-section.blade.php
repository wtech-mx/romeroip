@php
    $readOnly = $readOnly ?? false;
    $newFile = $newFile ?? false;
@endphp
<section class="tm-section tm-approved-section tm-deadline-section" id="dates-deadlines">
    <h2 class="tm-section-heading"><span>08 |</span> Dates and Deadlines</h2>
    <div class="tm-deadline-tables">
        <div class="tm-field-column">
            @php
                $value = $newFile ? old('publication_date') : ($readOnly ? $trademark->publication_date : old('publication_date', $trademark->publication_date));
                if (filled($value)) { try { $value = \Carbon\Carbon::parse($value)->format($readOnly ? 'M/d/Y' : 'Y-m-d'); } catch (\Throwable $error) {} }
            @endphp
            <div class="tm-field" data-field="publication_date">
                <label class="tm-label" @if(!$readOnly) for="publication_date" @endif>Publication Date</label>
                @if($readOnly)<p class="tm-value">{{ filled($value) ? $value : '—' }}</p>
                @else<div class="tm-control"><input type="date" class="form-control tm-input date-mask" id="publication_date" name="publication_date" value="{{ $value }}"></div>@endif
            </div>
            <div class="tm-spacer-row" aria-hidden="true"></div>
            @php
                $value = $newFile ? old('filing_date_opposition') : ($readOnly ? $trademark->filing_date_opposition : old('filing_date_opposition', $trademark->filing_date_opposition));
                if (filled($value)) { try { $value = \Carbon\Carbon::parse($value)->format($readOnly ? 'M/d/Y' : 'Y-m-d'); } catch (\Throwable $error) {} }
            @endphp
            <div class="tm-field" data-field="filing_date_opposition">
                <label class="tm-label" @if(!$readOnly) for="filing_date_opposition" @endif>Opposition Date</label>
                @if($readOnly)<p class="tm-value">{{ filled($value) ? $value : '—' }}</p>
                @else<div class="tm-control"><input type="date" class="form-control tm-input date-mask" id="filing_date_opposition" name="filing_date_opposition" value="{{ $value }}"></div>@endif
            </div>
            @php
                $value = $newFile ? old('opposition_deadline') : ($readOnly ? $trademark->opposition_deadline : old('opposition_deadline', $trademark->opposition_deadline));
                if (filled($value)) { try { $value = \Carbon\Carbon::parse($value)->format($readOnly ? 'M/d/Y' : 'Y-m-d'); } catch (\Throwable $error) {} }
            @endphp
            <div class="tm-field" data-field="opposition_deadline">
                <label class="tm-label" @if(!$readOnly) for="opposition_deadline" @endif>Opposition Deadline</label>
                @if($readOnly)<p class="tm-value">{{ filled($value) ? $value : '—' }}</p>
                @else<div class="tm-control"><input type="date" class="form-control tm-input date-mask" id="opposition_deadline" name="opposition_deadline" value="{{ $value }}"></div>@endif
            </div>
            @php
                $value = $newFile ? old('opposition_response_date') : ($readOnly ? $trademark->opposition_response_date : old('opposition_response_date', $trademark->opposition_response_date));
                if (filled($value)) { try { $value = \Carbon\Carbon::parse($value)->format($readOnly ? 'M/d/Y' : 'Y-m-d'); } catch (\Throwable $error) {} }
            @endphp
            <div class="tm-field" data-field="opposition_response_date">
                <label class="tm-label" @if(!$readOnly) for="opposition_response_date" @endif>Opposition Response Date</label>
                @if($readOnly)<p class="tm-value">{{ filled($value) ? $value : '—' }}</p>
                @else<div class="tm-control"><input type="date" class="form-control tm-input date-mask" id="opposition_response_date" name="opposition_response_date" value="{{ $value }}"></div>@endif
            </div>
            @php
                $value = $newFile ? old('closing_arguments_deadline') : ($readOnly ? $trademark->closing_arguments_deadline : old('closing_arguments_deadline', $trademark->closing_arguments_deadline));
                if (filled($value)) { try { $value = \Carbon\Carbon::parse($value)->format($readOnly ? 'M/d/Y' : 'Y-m-d'); } catch (\Throwable $error) {} }
            @endphp
            <div class="tm-field" data-field="closing_arguments_deadline">
                <label class="tm-label" @if(!$readOnly) for="closing_arguments_deadline" @endif>Closing Arguments Deadline</label>
                @if($readOnly)<p class="tm-value">{{ filled($value) ? $value : '—' }}</p>
                @else<div class="tm-control"><input type="date" class="form-control tm-input date-mask" id="closing_arguments_deadline" name="closing_arguments_deadline" value="{{ $value }}"></div>@endif
            </div>
            @php
                $value = $newFile ? old('closing_arguments_date') : ($readOnly ? $trademark->closing_arguments_date : old('closing_arguments_date', $trademark->closing_arguments_date));
                if (filled($value)) { try { $value = \Carbon\Carbon::parse($value)->format($readOnly ? 'M/d/Y' : 'Y-m-d'); } catch (\Throwable $error) {} }
            @endphp
            <div class="tm-field" data-field="closing_arguments_date">
                <label class="tm-label" @if(!$readOnly) for="closing_arguments_date" @endif>Closing Arguments Date</label>
                @if($readOnly)<p class="tm-value">{{ filled($value) ? $value : '—' }}</p>
                @else<div class="tm-control"><input type="date" class="form-control tm-input date-mask" id="closing_arguments_date" name="closing_arguments_date" value="{{ $value }}"></div>@endif
            </div>
        </div>
        <div class="tm-field-column">
            @php
                $value = $newFile ? old('filing_date_litigation') : ($readOnly ? $trademark->filing_date_litigation : old('filing_date_litigation', $trademark->filing_date_litigation));
                if (filled($value)) { try { $value = \Carbon\Carbon::parse($value)->format($readOnly ? 'M/d/Y' : 'Y-m-d'); } catch (\Throwable $error) {} }
            @endphp
            <div class="tm-field" data-field="filing_date_litigation">
                <label class="tm-label" @if(!$readOnly) for="filing_date_litigation" @endif>Office Action Date</label>
                @if($readOnly)<p class="tm-value">{{ filled($value) ? $value : '—' }}</p>
                @else<div class="tm-control"><input type="date" class="form-control tm-input date-mask" id="filing_date_litigation" name="filing_date_litigation" value="{{ $value }}"></div>@endif
            </div>
            @php
                $value = $newFile ? old('first_office_action_deadline') : ($readOnly ? $trademark->first_office_action_deadline : old('first_office_action_deadline', $trademark->first_office_action_deadline));
                if (filled($value)) { try { $value = \Carbon\Carbon::parse($value)->format($readOnly ? 'M/d/Y' : 'Y-m-d'); } catch (\Throwable $error) {} }
            @endphp
            <div class="tm-field" data-field="first_office_action_deadline">
                <label class="tm-label" @if(!$readOnly) for="first_office_action_deadline" @endif>1st Office Action Deadline</label>
                @if($readOnly)<p class="tm-value">{{ filled($value) ? $value : '—' }}</p>
                @else<div class="tm-control"><input type="date" class="form-control tm-input date-mask" id="first_office_action_deadline" name="first_office_action_deadline" value="{{ $value }}"></div>@endif
            </div>
            @php
                $value = $newFile ? old('second_office_action_deadline') : ($readOnly ? $trademark->second_office_action_deadline : old('second_office_action_deadline', $trademark->second_office_action_deadline));
                if (filled($value)) { try { $value = \Carbon\Carbon::parse($value)->format($readOnly ? 'M/d/Y' : 'Y-m-d'); } catch (\Throwable $error) {} }
            @endphp
            <div class="tm-field" data-field="second_office_action_deadline">
                <label class="tm-label" @if(!$readOnly) for="second_office_action_deadline" @endif>2nd Office Action Deadline</label>
                @if($readOnly)<p class="tm-value">{{ filled($value) ? $value : '—' }}</p>
                @else<div class="tm-control"><input type="date" class="form-control tm-input date-mask" id="second_office_action_deadline" name="second_office_action_deadline" value="{{ $value }}"></div>@endif
            </div>
            @php
                $value = $newFile ? old('office_action_response') : ($readOnly ? $trademark->office_action_response : old('office_action_response', $trademark->office_action_response));
                if (filled($value)) { try { $value = \Carbon\Carbon::parse($value)->format($readOnly ? 'M/d/Y' : 'Y-m-d'); } catch (\Throwable $error) {} }
            @endphp
            <div class="tm-field" data-field="office_action_response">
                <label class="tm-label" @if(!$readOnly) for="office_action_response" @endif>Office Action Response</label>
                @if($readOnly)<p class="tm-value">{{ filled($value) ? $value : '—' }}</p>
                @else<div class="tm-control"><input type="date" class="form-control tm-input date-mask" id="office_action_response" name="office_action_response" value="{{ $value }}"></div>@endif
            </div>
            <div class="tm-spacer-row" aria-hidden="true"></div>
            @php
                $value = $newFile ? old('suspension_request_date') : ($readOnly ? $trademark->suspension_request_date : old('suspension_request_date', $trademark->suspension_request_date));
                if (filled($value)) { try { $value = \Carbon\Carbon::parse($value)->format($readOnly ? 'M/d/Y' : 'Y-m-d'); } catch (\Throwable $error) {} }
            @endphp
            <div class="tm-field" data-field="suspension_request_date">
                <label class="tm-label" @if(!$readOnly) for="suspension_request_date" @endif>Request for Suspension Date</label>
                @if($readOnly)<p class="tm-value">{{ filled($value) ? $value : '—' }}</p>
                @else<div class="tm-control"><input type="date" class="form-control tm-input date-mask" id="suspension_request_date" name="suspension_request_date" value="{{ $value }}"></div>@endif
            </div>
            @php
                $value = $newFile ? old('suspension_period_end_date') : ($readOnly ? $trademark->suspension_period_end_date : old('suspension_period_end_date', $trademark->suspension_period_end_date));
                if (filled($value)) { try { $value = \Carbon\Carbon::parse($value)->format($readOnly ? 'M/d/Y' : 'Y-m-d'); } catch (\Throwable $error) {} }
            @endphp
            <div class="tm-field" data-field="suspension_period_end_date">
                <label class="tm-label" @if(!$readOnly) for="suspension_period_end_date" @endif>Suspension Period End Date</label>
                @if($readOnly)<p class="tm-value">{{ filled($value) ? $value : '—' }}</p>
                @else<div class="tm-control"><input type="date" class="form-control tm-input date-mask" id="suspension_period_end_date" name="suspension_period_end_date" value="{{ $value }}"></div>@endif
            </div>
        </div>
    </div>
    <div class="tm-deadline-identifiers">
        @foreach(['opposition_no' => 'Opposition No.', 'litigation_no' => 'Litigation No.'] as $key => $label)
            @php($value = $newFile ? old($key) : ($readOnly ? $trademark->{$key} : old($key, $trademark->{$key})))
            @if(!$readOnly || filled($value))
            <div class="tm-field-column"><div class="tm-field">
                <label class="tm-label" @if(!$readOnly) for="{{ $key }}" @endif>{{ $label }}</label>
                @if($readOnly)<p class="tm-value">{{ $value }}</p>
                @else<div class="tm-control"><input class="form-control tm-input" id="{{ $key }}" name="{{ $key }}" value="{{ $value }}"></div>@endif
            </div></div>
            @endif
        @endforeach
    </div>
</section>
