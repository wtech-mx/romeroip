@php
    $isOwner = $contactSection === 'owner';
    $name = $isOwner ? optional($trademark->Holder)->company_name : optional($trademark->Client)->company_name;
    $address = $isOwner ? optional($trademark->AddressHolder)->address : optional($trademark->AddressContact)->address;
    $secondary = $isOwner ? $trademark->industrial_address : optional($trademark->AddressContact)->billing_address;
@endphp
<section class="tm-section tm-approved-section tm-contact-section" id="{{ $contactSection }}">
    <h2 class="tm-section-heading"><span>{{ $isOwner ? '06' : '07' }} |</span> {{ $isOwner ? 'Owner' : 'Client' }}</h2>
    <div class="tm-contact-layout">
        <div class="tm-field"><span class="tm-label">{{ $isOwner ? 'Owner' : 'Client' }}</span><p class="tm-value">{{ filled($name) ? $name : '—' }}</p></div>
        @if(!$isOwner)<div class="tm-field"><span class="tm-label">Invoice Recipient</span><p class="tm-value">{{ filled($name) ? $name : '—' }}</p></div>@endif
        <div class="tm-contact-pair tm-contact-addresses">
            <div class="tm-field"><span class="tm-label">Address</span><p class="tm-value">{{ filled($address) ? $address : '—' }}</p></div>
            <div class="tm-field"><span class="tm-label">{{ $isOwner ? 'Commercial Address' : 'Billing Address' }}</span><p class="tm-value">{{ filled($secondary) ? $secondary : '—' }}</p></div>
        </div>
        @if(!$isOwner && (filled(optional($trademark->ContactClient)->name) || filled(optional($trademark->ContactClient)->email)))
        <div class="tm-contact-pair">
            <div class="tm-field"><span class="tm-label">Contact</span><p class="tm-value">{{ optional($trademark->ContactClient)->name ?: '—' }}</p></div>
            <div class="tm-field"><span class="tm-label">Email</span><p class="tm-value">{{ optional($trademark->ContactClient)->email ?: '—' }}</p></div>
        </div>@endif
    </div>
</section>
