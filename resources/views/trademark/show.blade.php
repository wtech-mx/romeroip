@extends('layouts.app')

@section('template_title')
    {{ $trademark->trademark ?: __('messages.trademark') }}
@endsection

@section('css')
<style>
    :root{
        --tm-primary: #8A6F3E;
        --tm-dark: #1F2328;
        --tm-border: #D8D2C6;
        --tm-border-soft: #EEE9DF;
        --tm-bg: #F8F6F1;
        --tm-muted: #76716A;
    }

    body{
        background: var(--tm-bg);
    }

    .tm-show-page{
        max-width: 1260px;
        margin-left: 0;
        margin-right: auto;
        padding-bottom: 4rem;
    }

    .tm-show-header,
    .tm-show-body{
        background: #FBFAF6;
        border: 1px solid var(--tm-border);
    }

    .tm-show-header{
        margin-bottom: 1rem;
        padding: 2rem 2.15rem 1.5rem;
    }

    .tm-kicker{
        color: var(--tm-muted);
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .tm-title{
        margin: .28rem 0 0;
        color: var(--tm-dark);
        font-size: clamp(1.85rem, 3vw, 3rem);
        line-height: 1.05;
        font-weight: 700;
        letter-spacing: 0;
    }

    .tm-subtitle{
        margin: .55rem 0 0;
        color: var(--tm-muted);
        font-size: .98rem;
    }

    .tm-auto-header{
        margin-top: 1.15rem;
        color: var(--tm-dark);
        font-size: 1rem;
        line-height: 1.65;
        font-weight: 600;
        text-align: left;
    }

    .tm-auto-header-line{
        margin: 0;
    }

    .tm-auto-header-main{
        font-size: 1.06rem;
        font-weight: 700;
    }

    .tm-auto-header-oref{
        font-weight: 800;
    }

    .tm-actions{
        display: flex;
        gap: .65rem;
        flex-wrap: wrap;
        justify-content: flex-end;
        margin-top: 1rem;
    }

    .tm-btn{
        min-height: 40px;
        padding: 0 .95rem;
        border: 1px solid var(--tm-dark);
        border-radius: 3px;
        background: transparent;
        color: var(--tm-dark);
        display: inline-flex;
        align-items: center;
        font-weight: 700;
        text-decoration: none;
    }

    .tm-btn-primary{
        background: var(--tm-dark);
        color: #fff;
    }

    .tm-show-body{
        padding: 0 2.15rem 1rem;
        background: transparent;
        border: 0;
    }

    .tm-file-content{
        display: grid;
        grid-template-columns: minmax(0, 1fr) 260px;
        gap: 2.5rem;
        align-items: start;
    }

    .tm-file-tabs{
        position: sticky;
        top: 1.25rem;
        padding-left: 1.25rem;
        border-left: 1px solid var(--tm-border);
    }

    .tm-tabs-label{
        margin: 0 0 .85rem;
        color: var(--tm-muted);
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .tm-file-tabs button{
        display: block;
        width: 100%;
        padding: .78rem 0 .78rem .95rem;
        border: 0;
        border-left: 2px solid transparent;
        background: transparent;
        color: var(--tm-muted);
        font-size: .9rem;
        font-weight: 700;
        line-height: 1.25;
        text-align: left;
        transform: translateX(-1px);
        transition: border-color .15s ease, color .15s ease, background-color .15s ease;
    }

    .tm-file-tabs button:hover,
    .tm-file-tabs button.is-active{
        border-left-color: var(--tm-primary);
        background: rgba(138,111,62,.06);
        color: var(--tm-dark);
    }

    .tm-section{
        margin-bottom: 1.25rem;
        padding: 2.35rem 2.45rem 2.15rem;
        background: #fff;
        border: 1px solid rgba(216,210,198,.72);
        border-radius: 8px;
        box-shadow: 0 18px 45px rgba(24,31,43,.07);
    }

    .tm-section,
    .tm-section:not(.is-active),
    .tm-section.is-active{
        display: grid;
        grid-template-columns: 108px minmax(0, 1fr);
        column-gap: 2rem;
    }

    .tm-section::before,
    .tm-section.is-active::before{
        content: attr(data-section-number);
        grid-row: 1 / span 2;
        color: #f04b19;
        font-size: 2.55rem;
        line-height: 1;
        font-weight: 500;
        letter-spacing: 0;
    }

    .tm-section.is-collapsed .tm-doc-grid,
    .tm-section.is-collapsed .tm-use-info,
    .tm-section.is-collapsed > .tm-doc-field,
    .tm-section.is-collapsed .tm-design-image{
        display: none;
    }

    .tm-file-tabs button{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .85rem;
    }

    .tm-collapse-symbol{
        flex: 0 0 auto;
        color: #06264a;
        font-size: 1.05rem;
        font-weight: 800;
        line-height: 1;
    }

    .tm-section-title{
        margin: 0 0 1.75rem;
        padding: .1rem 0 0 2rem;
        border-left: 2px solid #1f6eb7;
        color: #06264a;
        font-size: 1.45rem;
        font-weight: 700;
        letter-spacing: .02em;
        text-transform: uppercase;
    }

    .tm-use-info{
        grid-column: 1 / -1;
        margin-top: 2rem;
        padding: 1.35rem 1.5rem;
        background: #f7f8fb;
        border: 1px solid rgba(216,210,198,.58);
        border-radius: 6px;
    }

    .tm-use-title{
        margin: 0 0 1rem;
        color: var(--tm-dark);
        font-size: .82rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .tm-doc-grid{
        grid-column: 1 / -1;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1.35rem 0;
    }

    .tm-doc-field.full{
        grid-column: 1 / -1;
    }

    .tm-doc-label{
        display: block;
        margin-bottom: .5rem;
        color: var(--tm-muted);
        font-size: .92rem;
        font-weight: 700;
        letter-spacing: 0;
        text-transform: none;
    }

    .tm-doc-value{
        margin: 0;
        color: #06264a;
        font-size: 1.15rem;
        line-height: 1.6;
        font-weight: 600;
        white-space: pre-line;
    }

    .tm-doc-field{
        min-height: 80px;
        padding: .15rem 1.4rem .8rem;
        border-left: 1px solid rgba(216,210,198,.6);
    }

    .tm-doc-field:nth-child(3n + 1){
        border-left: 0;
        padding-left: 0;
    }

    .tm-design-image{
        grid-column: 1 / -1;
        width: 100%;
        max-width: 360px;
        max-height: 340px;
        object-fit: contain;
        border: 1px solid var(--tm-border);
        background: rgba(255,255,255,.42);
        padding: 1rem;
    }

    @media (max-width: 991.98px){
        .tm-show-header,
        .tm-show-body{
            padding-left: 1.25rem;
            padding-right: 1.25rem;
        }

        .tm-actions{
            justify-content: flex-start;
        }

        .tm-doc-grid{
            grid-template-columns: 1fr;
        }

        .tm-section,
        .tm-section:not(.is-active),
        .tm-section.is-active{
            display: block;
            padding: 1.45rem 1.25rem 1.35rem;
        }

        .tm-section::before,
        .tm-section.is-active::before{
            display: block;
            margin-bottom: .75rem;
        }

        .tm-section-title{
            padding-left: 1rem;
        }

        .tm-doc-field,
        .tm-doc-field:nth-child(3n + 1){
            border-left: 0;
            padding-left: 0;
            padding-right: 0;
        }

        .tm-file-content{
            display: block;
        }

        .tm-file-tabs{
            position: static;
            display: flex;
            gap: 0;
            margin: 0 -1.25rem 2.25rem;
            padding-left: 1.25rem;
            padding-right: 1.25rem;
            border-left: 0;
            border-top: 1px solid var(--tm-border);
            border-bottom: 1px solid var(--tm-border);
            background: #F7F4ED;
            overflow-x: auto;
        }

        .tm-tabs-label{
            display: none;
        }

        .tm-file-tabs button{
            display: inline-flex;
            align-items: center;
            width: auto;
            min-height: 48px;
            padding: 0 .95rem;
            border-left: 0;
            border-right: 1px solid var(--tm-border-soft);
            white-space: nowrap;
            transform: none;
            font-size: .78rem;
            letter-spacing: .05em;
            text-transform: uppercase;
        }

        .tm-file-tabs button:hover,
        .tm-file-tabs button.is-active{
            background: #FBFAF6;
            color: var(--tm-dark);
        }
    }
</style>
@endsection

@section('content')
@php
    $filledValue = function ($value) {
        return filled($value) ? $value : null;
    };

    $formatDate = function ($value) {
        return filled($value) ? \Carbon\Carbon::parse($value)->format('m d Y') : null;
    };

    $field = function ($label, $value, $full = false, $always = false) {
        return [
            'label' => $label,
            'value' => filled($value) ? $value : ($always ? '—' : null),
            'full' => $full,
            'always' => $always,
        ];
    };

    $sections = [
        'profile' => [
            'title' => '01 REFERENCE NUMBERS',
            'items' => [
                $field(__('messages.our_ref'), $trademark->our_ref, false, true),
                $field(__('messages.client_ref'), $trademark->client_ref, false, true),
                /*
                $field(__('messages.opposition_no'), $trademark->opposition_no),
                $field(__('messages.filing_date'), $formatDate($trademark->filing_date_opposition)),
                $field(__('messages.litigation_no'), $trademark->litigation_no),
                $field(__('messages.filing_date'), $formatDate($trademark->filing_date_litigation)),
                */
            ],
        ],
        'basic-info' => [
            'title' => '02 GENERAL INFORMATION',
            'use_info' => $formatDate($trademark->first_date),
            'items' => [
                $field(__('messages.application_no'), $trademark->application_no, false, true),
                $field(__('messages.registration_no'), $trademark->registration_no, false, true),
                $field(__('messages.filing_date'), $formatDate($trademark->filing_date_general), false, true),
                $field(__('messages.registration_date'), $formatDate($trademark->registration_date), false, true),
                $field(__('messages.expiration_date'), $formatDate($trademark->expiration_date), false, true),
                $field(__('messages.status'), $trademark->status, false, true),
                $field('Country', $trademark->country ?: 'MEXICO', false, true),
                $field('Origin', $trademark->origin ?: '-', false, true),
            ],
        ],
        'trademark-section' => [
            'title' => '03 TRADEMARK INFORMATION',
            'has_design' => filled($trademark->design),
            'items' => [
                $field('Trademark', $trademark->trademark),
                $field('Type of Application', $trademark->type_application),
                $field('Type of Mark', $trademark->type_mark),
                $field('Description of the Mark', $trademark->description_trademark, true),
                $field('Disclaimer / Elements not Protected', $trademark->disclaimer, true),
                $field('Transliteration', $trademark->transliteration_trademark, true),
                $field('Translation', $trademark->translation, true),
            ],
        ],
        'accounts' => [
            'title' => '04 GOODS / SERVICES',
            'items' => [
                $field(__('messages.class'), $trademark->class),
                $field('Original Description', $trademark->description_good, true),
                $field(__('messages.translation'), $trademark->translation_good, true),
            ],
        ],
        'notifications' => [
            'title' => '05 PRIORITY INFORMATION',
            'items' => [
                $field('Priority Country', $trademark->country_office),
                $field(__('messages.priority_date'), $formatDate($trademark->priority_date)),
                $field(__('messages.priority_no'), $trademark->priority_no),
            ],
        ],
        'international-registration' => [
            'title' => '06 INTERNATIONAL REGISTRATION',
            'items' => [
                $field("Int'l Reg. No.", $trademark->int_registration_no),
                $field("Int'l Registration Date", $formatDate($trademark->int_registration_date)),
                $field('Contracting State or Organization', $trademark->contracting_organization),
                $field('Designated Countries', $trademark->designated_countries, true),
            ],
        ],
        'sessions' => [
            'title' => '07 CLIENT',
            'items' => [
                $field(__('messages.client'), optional($trademark->Client)->company_name),
                $field(__('messages.contact'), optional($trademark->ContactClient)->name),
                $field(__('messages.address'), optional($trademark->AddressContact)->address, true),
                $field(__('messages.billing_address'), optional($trademark->AddressContact)->billing_address, true),
            ],
        ],
        'holder' => [
            'title' => '08 OWNER',
            'items' => [
                $field(__('messages.holder'), optional($trademark->Holder)->company_name),
                $field(__('messages.address'), optional($trademark->AddressHolder)->address, true),
                $field(__('messages.industrial_address'), $trademark->industrial_address, true),
            ],
        ],
        'password' => [
            'title' => '09 IMPORTANT DATES',
            'items' => [
                $field(__('messages.declarations_use') . ' - ' . __('messages.last'), $formatDate($trademark->last_declaration)),
                $field(__('messages.renewals') . ' - ' . __('messages.last'), $formatDate($trademark->last_renewal)),
                $field(__('messages.declarations_use') . ' - ' . __('messages.next'), $formatDate($trademark->next_declaration)),
                $field(__('messages.renewals') . ' - ' . __('messages.next'), $formatDate($trademark->next_renewal)),
            ],
        ],
        'proceedings' => [
            'title' => '10 PROCEEDINGS',
            'items' => [
                $field(__('messages.opposition_no'), $trademark->opposition_no),
                $field(__('messages.filing_date'), $formatDate($trademark->filing_date_opposition)),
                $field(__('messages.litigation_no'), $trademark->litigation_no),
                $field(__('messages.filing_date'), $formatDate($trademark->filing_date_litigation)),
            ],
        ],
        'notes' => [
            'title' => '11 NOTES',
            'items' => [
            $field(__('messages.note'), $trademark->notes, true),
            ],
        ],
    ];

    $visibleSections = collect($sections)
        ->map(function ($section, $id) {
            $section['id'] = $id;
            $section['items'] = collect($section['items'])->filter(fn ($item) => filled($item['value']));
            return $section;
        })
        ->filter(fn ($section) => $section['items']->isNotEmpty() || !empty($section['has_design']));

    $firstSectionId = optional($visibleSections->first())['id'];

    $headerCountry = $filledValue($trademark->country);
    $headerRegistration = filled($trademark->registration_no)
        ? 'Reg. No. ' . $trademark->registration_no
        : (filled($trademark->application_no) ? 'Appl. No. ' . $trademark->application_no : null);
    $headerCountryRegistration = collect([$headerCountry, $headerRegistration])->filter()->implode(' | ');
    $headerClass = filled($trademark->class) ? 'Clase ' . $trademark->class : null;
    $headerMainParts = array_filter([$headerCountryRegistration, $trademark->trademark, $headerClass]);
@endphp

<div class="container-fluid mt-3 tm-show-page">
    <div class="tm-show-header">
        <div class="row g-3">
            <div class="col-lg-9">
                <div class="tm-kicker">View mode</div>
                <h1 class="tm-title">{{ $trademark->trademark ?: __('messages.trademark') }}</h1>
                <p class="tm-subtitle">Read-only legal trademark file.</p>

                <div class="tm-auto-header" aria-label="Automatic file header">
                    @if(count($headerMainParts))
                        <p class="tm-auto-header-line tm-auto-header-main">{{ implode(' — ', $headerMainParts) }}</p>
                    @endif

                    @if(filled($trademark->int_registration_no))
                        <p class="tm-auto-header-line">INT'L REG. {{ $trademark->int_registration_no }}</p>
                    @endif

                    @if(filled($trademark->our_ref) || filled($trademark->client_ref))
                        <p class="tm-auto-header-line">
                            @if(filled($trademark->our_ref))
                                <span class="tm-auto-header-oref">O/Ref. {{ $trademark->our_ref }}</span>
                            @endif
                            @if(filled($trademark->our_ref) && filled($trademark->client_ref))
                                <span> — </span>
                            @endif
                            @if(filled($trademark->client_ref))
                                <span>C/Ref. {{ $trademark->client_ref }}</span>
                            @endif
                        </p>
                    @endif

                    @if(filled(optional($trademark->Client)->company_name))
                        <p class="tm-auto-header-line">Client: {{ optional($trademark->Client)->company_name }}</p>
                    @endif

                    @if(filled(optional($trademark->Holder)->company_name))
                        <p class="tm-auto-header-line">Owner: {{ optional($trademark->Holder)->company_name }}</p>
                    @endif
                </div>
            </div>

            <div class="col-lg-3">
                <div class="tm-actions">
                    <a class="tm-btn" href="{{ route('index.trademarks') }}">{{ __('messages.back') }}</a>
                    <a class="tm-btn tm-btn-primary" href="{{ route('edit.trademarks', $trademark->id) }}">Edit</a>
                </div>
            </div>
        </div>
    </div>

    <div class="tm-show-body">
        <div class="tm-file-content">
            <div class="tm-file-main">
                @foreach($visibleSections as $section)
                    <section class="tm-section {{ $section['id'] === $firstSectionId ? 'is-active' : '' }}" id="{{ $section['id'] }}">
                        <h2 class="tm-section-title">{{ $section['title'] }}</h2>

                        @if($section['id'] === 'trademark-section')
                            <div class="tm-doc-grid">
                                @foreach($section['items'] as $item)
                                    <div class="tm-doc-field {{ $item['full'] ? 'full' : '' }}">
                                        <span class="tm-doc-label">{{ $item['label'] }}</span>
                                        <p class="tm-doc-value">{{ $item['value'] }}</p>
                                    </div>

                                    @if($loop->first && !empty($section['has_design']))
                                        <div class="tm-doc-field full">
                                            <span class="tm-doc-label">Representation / Logo</span>
                                            <img class="tm-design-image" src="{{ asset('design/'.$trademark->design) }}" alt="Trademark design">
                                        </div>
                                    @endif
                                @endforeach

                                @if($section['items']->isEmpty() && !empty($section['has_design']))
                                    <div class="tm-doc-field full">
                                        <span class="tm-doc-label">Representation / Logo</span>
                                        <img class="tm-design-image" src="{{ asset('design/'.$trademark->design) }}" alt="Trademark design">
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="tm-doc-grid">
                                @foreach($section['items'] as $item)
                                    <div class="tm-doc-field {{ $item['full'] ? 'full' : '' }}">
                                        <span class="tm-doc-label">{{ $item['label'] }}</span>
                                        <p class="tm-doc-value">{{ $item['value'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if($section['id'] === 'basic-info' && filled($section['use_info'] ?? null))
                            <div class="tm-use-info">
                                <h3 class="tm-use-title">Use Information</h3>
                                <div class="tm-doc-grid">
                                    <div class="tm-doc-field">
                                        <span class="tm-doc-label">{{ __('messages.first_date') }}</span>
                                        <p class="tm-doc-value">{{ $section['use_info'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </section>
                @endforeach
            </div>

            <nav class="tm-file-tabs" aria-label="Trademark file navigation">
                <p class="tm-tabs-label">Sections</p>
                @foreach($visibleSections as $section)
                    <button class="{{ $section['id'] === $firstSectionId ? 'is-active' : '' }}" type="button" data-tab-target="{{ $section['id'] }}">
                        {{ $section['title'] }}
                    </button>
                @endforeach
            </nav>
        </div>
    </div>
</div>
@endsection

@section('js_custom')
<script>
(function () {
    const tabButtons = Array.from(document.querySelectorAll('.tm-file-tabs button[data-tab-target]'));
    const sections = Array.from(document.querySelectorAll('.tm-section'));

    tabButtons.forEach((button, index) => {
        const section = document.getElementById(button.dataset.tabTarget);
        if (section) {
            section.dataset.sectionNumber = String(index + 1).padStart(2, '0');
            const title = section.querySelector('.tm-section-title');
            if (title) {
                title.textContent = title.textContent.replace(/^\s*\d{2}\s+/, '');
            }
        }
    });

    function syncCollapseButton(button) {
        const section = document.getElementById(button.dataset.tabTarget);
        if (!section) return;

        let symbol = button.querySelector('.tm-collapse-symbol');
        if (!symbol) {
            symbol = document.createElement('span');
            symbol.className = 'tm-collapse-symbol';
            button.appendChild(symbol);
        }

        const isCollapsed = section.classList.contains('is-collapsed');
        symbol.textContent = isCollapsed ? '+' : '-';
        button.classList.toggle('is-collapsed', isCollapsed);
        button.setAttribute('aria-expanded', String(!isCollapsed));
    }

    tabButtons.forEach(button => {
        button.classList.remove('is-active');
        syncCollapseButton(button);

        button.addEventListener('click', function () {
            const section = document.getElementById(this.dataset.tabTarget);
            if (!section) return;

            section.classList.toggle('is-collapsed');
            syncCollapseButton(this);

            if (window.history) {
                window.history.replaceState(null, '', '#' + section.id);
            }
        });
    });

    const initialSection = window.location.hash ? document.getElementById(window.location.hash.replace('#', '')) : null;
    initialSection?.scrollIntoView({ block: 'start' });
})();
</script>
@endsection
