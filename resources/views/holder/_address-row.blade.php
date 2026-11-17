<div class="owner-address-row" data-owner-address-row>
    <input type="hidden" name="address_ids[]" value="{{ $address->id }}">
    <div><label for="owner-address-{{ $index }}">Address</label><textarea id="owner-address-{{ $index }}" name="address[]" class="form-control" rows="3" placeholder="Full address (street, number, neighborhood, municipality, state and postal code)">{{ $address->address }}</textarea></div>
    <div><label for="owner-commercial-address-{{ $index }}">Industrial / Commercial Address</label><textarea id="owner-commercial-address-{{ $index }}" name="commercial_address[]" class="form-control" rows="3" placeholder="Full industrial or commercial address (if applicable)">{{ $address->commercial_address }}</textarea></div>
</div>
