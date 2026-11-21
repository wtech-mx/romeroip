<section class="owner-section" aria-labelledby="owner-contact-title">
    <h2 id="owner-contact-title">Contact Information</h2>
    <div class="owner-contact-grid">
        @foreach(['telephone' => ['Telephone', 'Telephone number', 'tel', 60], 'telephone_secondary' => ['Telephone', 'Telephone number', 'tel', 60], 'extension' => ['Extension', 'Ext.', 'text', 20], 'mobile' => ['Mobile', 'Mobile number', 'tel', 60], 'email' => ['Email', 'Email address', 'email', 255]] as $field => [$label, $placeholder, $type, $length])
        <div @if($field === 'extension') data-individual-field @if(!$isIndividual) hidden @endif @elseif($field === 'telephone_secondary') data-company-field @if($isIndividual) hidden @endif @endif><label for="owner-{{ $field }}">{{ $label }}</label><input id="owner-{{ $field }}" name="{{ $field }}" type="{{ $type }}" @disabled(($field === 'extension' && !$isIndividual) || ($field === 'telephone_secondary' && $isIndividual)) class="form-control" placeholder="{{ $placeholder }}" maxlength="{{ $length }}" value="{{ old($field, $owner?->getAttribute($field) ?? '') }}"></div>
        @endforeach
    </div>
</section>
