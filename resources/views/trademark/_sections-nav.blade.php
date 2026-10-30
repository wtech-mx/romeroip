@php
    $sectionLinks = ['references' => 'References', 'general' => 'General', 'maintenance' => 'Maintenance', 'trademark-section' => 'Trademark', 'accounts' => 'Goods / Services', ($readOnly ? 'owner' : 'holder') => 'Owner', ($readOnly ? 'client' : 'sessions') => 'Client', 'dates-deadlines' => 'Dates and Deadlines', 'notes' => 'Notes'];
@endphp
<aside class="tm-sections-panel" aria-label="Sections navigation">
    <div class="tm-sections-wide">
        <h2>Sections</h2>
        <nav aria-label="File sections">
            @foreach($sectionLinks as $target => $label)
            <a href="#{{ $target }}" data-section-link="{{ $target }}"><span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><span class="tm-section-divider">|</span>{{ $label }}</a>
            @endforeach
        </nav>
    </div>
    <label class="tm-sections-compact">Sections
        <select aria-label="Go to section" data-section-picker>
            @foreach($sectionLinks as $target => $label)<option value="{{ $target }}">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }} | {{ $label }}</option>@endforeach
        </select>
    </label>
    @if($editing)
    <div class="tm-sections-save"><button class="tm-btn tm-btn-primary" type="submit" form="trademarkEditForm">Update</button></div>
    @elseif($readOnly)
    <div class="tm-sections-save"><a class="tm-btn tm-btn-primary" data-edit-current-section href="{{ route('edit.trademarks', $trademark->id) }}">Edit</a></div>
    @endif
</aside>
