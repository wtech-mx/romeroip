<section class="owner-section" aria-labelledby="owner-address-title">
    <h2 id="owner-address-title">Address Information</h2>
    <div data-owner-addresses>
        @foreach($rows as $address)
            @include('holder._address-row', ['index' => $loop->index, 'address' => $address, 'removable' => $loop->index > 0])
        @endforeach
    </div>
    <button class="tm-btn owner-add-address" type="button" data-owner-add-address>+ Address</button>
</section>
<template data-owner-address-template>
    @include('holder._address-row', ['index' => '__INDEX__', 'address' => (object) ['id' => null, 'address' => '', 'commercial_address' => ''], 'removable' => true])
</template>
