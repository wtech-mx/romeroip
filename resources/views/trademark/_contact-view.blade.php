@php
    $isOwner = $contactSection === 'owner';
    $name = $isOwner ? optional($trademark->Holder)->company_name : optional($trademark->Client)->company_name;
    $address = $isOwner ? optional($trademark->AddressHolder)->address : optional($trademark->AddressContact)->address;
@endphp
<section class="tm-section tm-approved-section tm-contact-section" id="{{ $contactSection }}">
    <h2 class="tm-section-heading"><span>{{ $isOwner ? '06' : '07' }} |</span> {{ $isOwner ? 'Owner' : 'Client' }}</h2>
    <div class="tm-contact-layout">
        <div class="tm-field tm-party-name"><span class="tm-label">{{ $isOwner ? 'Owner' : 'Client' }}</span><p class="tm-value">{{ filled($name) ? $name : '—' }}</p></div>
        @if($isOwner)
        <div class="tm-contact-pair tm-contact-addresses">
            <div class="tm-field"><span class="tm-label">Address</span><p class="tm-value">{{ filled($address) ? $address : '—' }}</p></div>
            <div class="tm-field"><span class="tm-label">Estab.<br>Address</span><p class="tm-value">{{ filled($trademark->industrial_address) ? $trademark->industrial_address : '—' }}</p></div>
        </div>
        @else
        <div class="tm-contact-pair tm-client-pair">
            <div class="tm-contact-table tm-client-details">
                <div class="tm-field"><span class="tm-label">Contact</span><p class="tm-value">{{ optional($trademark->ContactClient)->name ?: '—' }}</p></div>
                <div class="tm-field"><span class="tm-label">Email</span><p class="tm-value">{{ optional($trademark->ContactClient)->email ?: '—' }}</p></div>
            </div>
            <div class="tm-contact-table tm-client-address"><div class="tm-field"><span class="tm-label">Address</span><p class="tm-value">{{ filled($address) ? $address : '—' }}</p></div></div>
        </div>
        @endif
    </div>
</section>
