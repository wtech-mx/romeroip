@php
    $readOnly = $readOnly ?? false;
    $newFile = $newFile ?? false;
    $sectionId = $fileSectionId;
    $sectionFields = $sectionId === 'accounts'
        ? ['class' => 'Class', 'description_good' => 'Description', 'translation_good' => 'Translation']
        : ['notes' => 'Notes'];
@endphp
<section class="tm-section tm-approved-section tm-text-section" id="{{ $sectionId }}">
    <h2 class="tm-section-heading"><span>{{ $sectionId === 'accounts' ? '05' : '09' }} |</span> {{ $sectionId === 'accounts' ? 'Goods / Services' : 'Notes' }}</h2>
    <div class="tm-text-table tm-field-column">
        @foreach($sectionFields as $key => $label)
            @php($value = $newFile ? old($key) : ($readOnly ? $trademark->{$key} : old($key, $trademark->{$key})))
            <div class="tm-field {{ $key !== 'class' ? 'tm-text-multiline' : '' }}">
                <label class="tm-label" @if(!$readOnly) for="{{ $key === 'notes' ? 'notes_text' : $key }}" @endif>{{ $label }}</label>
                @if($readOnly)<p class="tm-value">{{ filled($value) ? $value : '—' }}</p>
                @else<div class="tm-control">
                    @if($key === 'class')
                    <select class="form-control tm-select" name="class" id="class">
                        <option value="">Select</option>
                        @for($i = 1; $i <= 45; $i++)
                            @php($classOption = str_pad($i, 2, '0', STR_PAD_LEFT))
                            <option value="{{ $classOption }}" @selected($value === $classOption)>{{ $classOption }}</option>
                        @endfor
                    </select>
                    @else<textarea class="form-control tm-input" name="{{ $key }}" id="{{ $key === 'notes' ? 'notes_text' : $key }}" rows="2">{{ $value }}</textarea>@endif
                </div>@endif
            </div>
        @endforeach
    </div>
</section>
