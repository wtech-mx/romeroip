<div class="owner-address-row" data-owner-address-row data-address-id="{{ $address->id }}" @if($removable ?? false) data-additional-address @endif>
    @if($removable ?? false)<button class="owner-remove-address" type="button" data-owner-remove-address title="Remove Address" aria-label="Remove Address"><svg width="12" height="12" viewBox="0 0 12 12" aria-hidden="true"><path d="m2 2 8 8M10 2l-8 8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></button>@endif
    <input type="hidden" name="address_ids[]" value="{{ $address->id }}">
    <div><label for="owner-address-{{ $index }}">Address</label><textarea id="owner-address-{{ $index }}" name="address[]" class="form-control" rows="3" placeholder="Full address (street, number, neighborhood, municipality, state and postal code)">{{ $address->address }}</textarea></div>
    <div><label for="owner-commercial-address-{{ $index }}">Industrial / Commercial Address</label><textarea id="owner-commercial-address-{{ $index }}" name="commercial_address[]" class="form-control" rows="3" placeholder="Full industrial or commercial address (if applicable)">{{ $address->commercial_address }}</textarea></div>
</div>
