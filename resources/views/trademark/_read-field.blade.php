<div class="tm-field {{ $item['full'] ? 'is-full' : '' }} {{ $item['tall'] ? 'is-tall' : '' }} {{ $item['logo'] ? 'is-logo' : '' }}">
    <span class="tm-label">{{ $item['label'] }}</span>

    @if($item['logo'])
        <div class="tm-logo-box">
            <img class="tm-design-image" src="{{ asset('design/'.$item['value']) }}" alt="Trademark design">
        </div>
    @else
        <p class="tm-value {{ ($section['title'] === 'General' && in_array($item['label'], [__('messages.registration_date'), __('messages.expiration_date')], true)) || ($section['title'] === 'References' && $item['label'] !== 'Department') ? 'tm-emphasized' : '' }}">{{ $item['value'] ?? '—' }}</p>
    @endif
</div>
