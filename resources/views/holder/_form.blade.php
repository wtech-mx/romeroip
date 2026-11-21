@php
    $ownerType = old('owner_type', $owner->owner_type ?? 'Company') ?: 'Company';
    $isIndividual = $ownerType === 'Individual';
    $addressRows = old('address');
    if (is_array($addressRows)) {
        $rows = collect($addressRows)->map(fn ($text, $i) => (object) ['id' => old('address_ids.'.$i), 'address' => $text, 'commercial_address' => old('commercial_address.'.$i)]);
    } else { $rows = $addresses->isNotEmpty() ? $addresses : collect([(object) ['id' => null, 'address' => '', 'commercial_address' => '']]); }
@endphp
@foreach(old('removed_address_ids', []) as $removedId)<input type="hidden" name="removed_address_ids[]" value="{{ $removedId }}">@endforeach
<section class="owner-section" aria-labelledby="owner-info-title">
    <h2 id="owner-info-title">Owner Information</h2>
    <fieldset class="owner-type"><legend>Owner Type</legend>
        @foreach(['Company', 'Individual'] as $type)
        <label><input type="radio" name="owner_type" value="{{ $type }}" @checked($ownerType === $type)> {{ $type }}</label>
        @endforeach
    </fieldset>
    <div class="owner-information-grid" data-owner-type="{{ $ownerType }}">
        <div class="owner-full"><label for="company_name" data-owner-name-label>{{ $isIndividual ? 'Full Name' : 'Company Name' }}</label><input id="company_name" name="company_name" class="form-control" value="{{ old('company_name', $owner->company_name ?? '') }}" placeholder="{{ $isIndividual ? 'Full name (name and surnames)' : 'Company name' }}" maxlength="255" required></div>
        @if(!$isIndividual) @include('holder._country-field') @endif
        <div data-individual-field @if(!$isIndividual) hidden @endif><label for="owner-curp">CURP</label><input id="owner-curp" name="curp" class="form-control" placeholder="CURP" value="{{ old('curp', $owner->curp ?? '') }}" maxlength="30" @disabled(!$isIndividual)></div>
        <div class="owner-common-field owner-tax"><label for="owner-rfc" data-owner-tax-label>{{ $isIndividual ? 'RFC' : 'Tax No.' }}</label><input id="owner-rfc" name="rfc" class="form-control" placeholder="{{ $isIndividual ? 'RFC' : 'Tax number' }}" value="{{ old('rfc', $owner->rfc ?? '') }}" maxlength="30"></div>
        <div data-individual-field @if(!$isIndividual) hidden @endif><label for="owner-sex">Sex</label><select id="owner-sex" name="sex" class="form-control" @disabled(!$isIndividual)><option value="">Select</option>@foreach(['Female','Male','Other'] as $sex)<option value="{{ $sex }}" @selected(old('sex', $owner->sex ?? '') === $sex)>{{ $sex }}</option>@endforeach</select></div>
        <div data-individual-field @if(!$isIndividual) hidden @endif><label for="owner-date-of-birth">Date of Birth</label><input type="date" id="owner-date-of-birth" name="date_of_birth" class="form-control date-mask" max="{{ now()->format('Y-m-d') }}" value="{{ old('date_of_birth', $owner->date_of_birth ?? '') }}" @disabled(!$isIndividual)></div>
        <div data-individual-field @if(!$isIndividual) hidden @endif><label for="owner-place-of-birth">Place of Birth</label><input id="owner-place-of-birth" name="place_of_birth" class="form-control" placeholder="Place of birth" value="{{ old('place_of_birth', $owner->place_of_birth ?? '') }}" maxlength="255" @disabled(!$isIndividual)></div>
        @if($isIndividual) @include('holder._country-field') @endif
    </div>
</section>
@if($isIndividual)
    @include('holder._address-section')
    @include('holder._contact-section')
@else
    @include('holder._contact-section')
    @include('holder._address-section')
@endif
