@php
    $readOnly = $readOnly ?? false;
    $newFile = $newFile ?? false;
    $markValue = fn($key) => $newFile ? old($key) : ($readOnly ? $trademark->{$key} : old($key, $trademark->{$key}));
    $markDesign = !$newFile ? $trademark->design : null;
@endphp
<section class="tm-section tm-approved-section tm-mark-section" id="trademark-section">
    <h2 class="tm-section-heading"><span>04 |</span> Trademark</h2>
    <div class="tm-mark-layout">
        <div class="tm-field-column">
            <div class="tm-field autocomplete-wrap">
                <label class="tm-label" @if(!$readOnly) for="trademark" @endif>Trademark</label>
                @if($readOnly)<p class="tm-value">{{ $markValue('trademark') ?: '—' }}</p>
                @else
                    <div class="tm-control">
                        <input id="trademark" name="trademark" class="form-control tm-input" type="text" maxlength="250" autocomplete="off" value="{{ $markValue('trademark') }}">
                        <div id="trademark_suggestions" class="autocomplete-box d-none"></div>
                    </div>
                @endif
            </div>
        </div>
        <div class="tm-mark-middle">
            <div class="tm-field-column">
                <div class="tm-field  {{ $readOnly && !filled($markValue('type_application')) && false ? 'tm-mobile-empty' : '' }}">
                    <label class="tm-label" @if(!$readOnly) for="type_application" @endif>Type of Appl.</label>
                    @if($readOnly)<p class="tm-value">{{ $markValue('type_application') }}</p>
                    @else<div class="tm-control">
<select class="form-control tm-select" id="type_application" name="type_application">
                                <option value="">{{ __('messages.select') }}</option>
                                <option value="Trademark" {{ $markValue('type_application') == 'Trademark' ? 'selected' : '' }}>Trademark</option>
                                <option value="Commercial Name" {{ $markValue('type_application') == 'Commercial Name' ? 'selected' : '' }}>Commercial Name</option>
                                <option value="Slogan" {{ $markValue('type_application') == 'Slogan' ? 'selected' : '' }}>Slogan</option>
                                <option value="Collective Mark" {{ $markValue('type_application') == 'Collective Mark' ? 'selected' : '' }}>Collective Mark</option>
                                <option value="Certification Mark" {{ $markValue('type_application') == 'Certification Mark' ? 'selected' : '' }}>Certification Mark</option>
                            </select>
                    </div>@endif
                </div>
                <div class="tm-field  {{ $readOnly && !filled($markValue('type_mark')) && false ? 'tm-mobile-empty' : '' }}">
                    <label class="tm-label" @if(!$readOnly) for="type_mark" @endif>Type of Mark</label>
                    @if($readOnly)<p class="tm-value">{{ $markValue('type_mark') }}</p>
                    @else<div class="tm-control">
<select class="form-control tm-select" id="type_mark" name="type_mark">
                                <option value="">{{ __('messages.select') }}</option>
                                <option value="Word Mark" {{ $markValue('type_mark') == 'Word Mark' ? 'selected' : '' }}>Word Mark</option>
                                <option value="Design Mark" {{ $markValue('type_mark') == 'Design Mark' ? 'selected' : '' }}>Design Mark</option>
                                <option value="Mixed Mark" {{ $markValue('type_mark') == 'Mixed Mark' ? 'selected' : '' }}>Mixed Mark</option>
                                <option value="Three-Dimensional Mark" {{ $markValue('type_mark') == 'Three-Dimensional Mark' ? 'selected' : '' }}>Three-Dimensional Mark</option>
                                <option value="Holographic Mark" {{ $markValue('type_mark') == 'Holographic Mark' ? 'selected' : '' }}>Holographic Mark</option>
                                <option value="Sound Mark" {{ $markValue('type_mark') == 'Sound Mark' ? 'selected' : '' }}>Sound Mark</option>
                                <option value="Scent Mark" {{ $markValue('type_mark') == 'Scent Mark' ? 'selected' : '' }}>Scent Mark</option>
                                <option value="Trade Dress" {{ $markValue('type_mark') == 'Trade Dress' ? 'selected' : '' }}>Trade Dress</option>
                                <option value="Other" {{ $markValue('type_mark') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                    </div>@endif
                </div>
                <div class="tm-field tm-mark-multiline {{ $readOnly && !filled($markValue('translation')) && true ? 'tm-mobile-empty' : '' }}">
                    <label class="tm-label" @if(!$readOnly) for="translation" @endif>Translation</label>
                    @if($readOnly)<p class="tm-value">{{ $markValue('translation') }}</p>
                    @else<div class="tm-control">
                        <textarea id="translation" name="translation" class="form-control tm-input" rows="2" placeholder="Enter translation (if applicable)">{{ $markValue('translation') }}</textarea>
                    </div>@endif
                </div>
                <div class="tm-field tm-mark-multiline {{ $readOnly && !filled($markValue('transliteration_trademark')) && true ? 'tm-mobile-empty' : '' }}">
                    <label class="tm-label" @if(!$readOnly) for="transliteration_trademark" @endif>Transliteration</label>
                    @if($readOnly)<p class="tm-value">{{ $markValue('transliteration_trademark') }}</p>
                    @else<div class="tm-control">
                        <textarea id="transliteration_trademark" name="transliteration_trademark" class="form-control tm-input" rows="2" placeholder="Enter transliteration (if applicable)">{{ $markValue('transliteration_trademark') }}</textarea>
                    </div>@endif
                </div>
            </div>
            <div class="tm-field-column tm-mark-logo {{ $readOnly && !$markDesign ? 'tm-mobile-empty' : '' }}" id="representationLogoField">
                <div class="tm-logo-control" id="representationLogoPreview">
                    <img id="blah" class="tm-preview-image" @if($markDesign) src="{{ asset('design/'.$markDesign) }}" @else hidden @endif alt="Trademark representation">
                    @if(!$readOnly)
                        <div class="tm-upload-hint"><i class="bi bi-image" aria-hidden="true"></i><label for="design">Representation / Logo</label>
                        <span>Drag and drop an image here<br>or</span>
                        <label class="tm-file-link" for="design">Choose file</label>
                        <small>JPG, PNG, WEBP or GIF. Max. 4 MB.</small></div>
                        <input id="design" name="design" type="file" accept=".jpg,.jpeg,.png,.webp,.gif" aria-label="Representation / Logo">
                    @elseif(!$markDesign)<span class="tm-logo-empty">Representation / Logo</span>@endif
                </div>
            </div>
        </div>
        @if(!$readOnly || filled($markValue('disclaimer')) || filled($markValue('description_trademark')))
        <div class="tm-field-column">
            @foreach(['disclaimer' => 'Disclaimer', 'description_trademark' => 'Description'] as $key => $label)
                @if(!$readOnly || filled($markValue($key)))
                <div class="tm-field tm-mark-multiline">
                    <label class="tm-label" @if(!$readOnly) for="{{ $key }}" @endif>{{ $label }}</label>
                    @if($readOnly)<p class="tm-value">{{ $markValue($key) }}</p>
                    @else<div class="tm-control"><textarea id="{{ $key }}" name="{{ $key }}" class="form-control tm-input" rows="2" placeholder="Enter {{ strtolower($label) }} (if applicable)">{{ $markValue($key) }}</textarea></div>@endif
                </div>
                @endif
            @endforeach
        </div>
        @endif
    </div>
</section>
