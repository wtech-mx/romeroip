@extends('layouts.app')

@section('template_title')
    {{ $trademark->trademark ?: __('messages.trademark') }}
@endsection

@section('css')
<style>
    :root{
        --tm-surface: #f4f6f8;
        --tm-panel: #ffffff;
        --tm-panel-soft: #fafafa;
        --tm-ink: #20242a;
        --tm-muted: #626a73;
        --tm-line: #cfd5dd;
        --tm-line-dark: #1f2933;
        --tm-accent: #2f6f5e;
        --tm-accent-soft: #dff2e6;
    }

    body{ background: var(--tm-surface); }

    .tm-show-page{
        max-width: 1320px;
        margin: 0 auto;
        padding-bottom: 4rem;
    }

    .tm-file-shell{
        background: var(--tm-panel);
        border: 1px solid var(--tm-line);
        border-radius: 8px;
        padding: 1.7rem;
    }

    .tm-header{
        background: var(--tm-panel-soft);
        border: 1px solid var(--tm-line);
        border-radius: 8px;
        padding: 1.25rem 1.35rem;
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 1rem;
        align-items: start;
    }

    .tm-title-line{
        display: flex;
        flex-wrap: wrap;
        gap: .7rem;
        align-items: center;
        margin-bottom: .45rem;
    }

    .tm-title{
        margin: 0;
        color: var(--tm-ink);
        font-size: clamp(2rem, 4vw, 3rem);
        line-height: 1;
        font-weight: 800;
        letter-spacing: 0;
        text-transform: uppercase;
    }

    .tm-status-pill{
        background: var(--tm-accent-soft);
        color: var(--tm-accent);
        border-radius: 999px;
        padding: .25rem .75rem;
        font-size: .82rem;
        font-weight: 700;
    }

    .tm-header-meta{
        display: grid;
        gap: .22rem;
        color: var(--tm-ink);
        font-size: 1rem;
    }

    .tm-header-muted{ color: var(--tm-muted); }

    .tm-actions{
        display: flex;
        gap: .55rem;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .tm-btn{
        min-height: 38px;
        border: 1px solid var(--tm-line-dark);
        border-radius: 4px;
        padding: 0 .95rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: var(--tm-line-dark);
        background: transparent;
        text-decoration: none;
        font-weight: 700;
    }

    .tm-btn-primary{
        background: var(--tm-line-dark);
        color: #fff;
    }

    .tm-btn:hover{
        border-color: var(--tm-accent);
        color: var(--tm-accent);
        background: #fff;
    }

    .tm-section{ margin-top: 2rem; }

    .tm-section-heading{
        margin: 0 0 1rem;
        color: #111827;
        font-size: 1.02rem;
        font-weight: 800;
        letter-spacing: 0;
        text-transform: uppercase;
    }

    .tm-section-heading span{
        font-weight: 500;
        padding-right: .45rem;
    }

    .tm-field-grid{
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem 1.6rem;
    }

    .tm-field-grid.is-single{ grid-template-columns: 1fr; }

    .tm-field{
        min-height: 42px;
        border: 1px solid var(--tm-line-dark);
        background: #fff;
        display: grid;
        grid-template-columns: minmax(142px, 38%) minmax(0, 1fr);
        align-items: stretch;
    }

    .tm-field.is-full{ grid-column: 1 / -1; }
    .tm-field.is-tall{ min-height: 112px; }
    .tm-field.is-logo{ min-height: 172px; }

    .tm-label{
        margin: 0;
        padding: .48rem .65rem;
        border-right: 1px solid var(--tm-line-dark);
        color: #151a20;
        font-size: .94rem;
        font-weight: 600;
        line-height: 1.25;
        text-align: right;
        display: flex;
        align-items: flex-start;
        justify-content: flex-end;
    }

    .tm-value{
        margin: 0;
        min-width: 0;
        color: var(--tm-ink);
        padding: .45rem .65rem;
        font-size: .95rem;
        line-height: 1.45;
        white-space: pre-line;
        overflow-wrap: anywhere;
    }

    .tm-logo-box{
        width: 100%;
        padding: .7rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .tm-design-image{
        width: 100%;
        max-width: 260px;
        max-height: 150px;
        object-fit: contain;
        border: 1px solid var(--tm-line);
        background: #fff;
        padding: .5rem;
    }

    @media (max-width: 991.98px){
        .tm-file-shell{ padding: 1rem; }
        .tm-header{ grid-template-columns: 1fr; }
        .tm-actions{ justify-content: flex-start; }
        .tm-field-grid{
            grid-template-columns: 1fr;
            gap: .85rem;
        }
    }

    @media (max-width: 575.98px){
        .tm-field{ grid-template-columns: 1fr; }
        .tm-label{
            border-right: 0;
            border-bottom: 1px solid var(--tm-line-dark);
            justify-content: flex-start;
            text-align: left;
        }
    }
</style>
@endsection

@section('content')
@php
    $formatDate = function ($value) {
        if (!filled($value)) {
            return null;
        }

        try {
            return \Carbon\Carbon::parse($value)->format('M/d/Y');
        } catch (\Throwable $e) {
            return $value;
        }
    };

    $field = function ($label, $value, $full = false, $tall = false, $logo = false) {
        return [
            'label' => $label,
            'value' => filled($value) ? $value : null,
            'full' => $full,
            'tall' => $tall,
            'logo' => $logo,
        ];
    };

    $sections = [
        [
            'title' => 'References',
            'items' => [
                $field(__('messages.our_ref'), $trademark->our_ref),
                $field(__('messages.client_ref'), $trademark->client_ref),
            ],
        ],
        [
            'title' => 'General',
            'items' => [
                $field(__('messages.application_no'), $trademark->application_no),
                $field("Int'l Registration No.", $trademark->int_registration_no),
                $field(__('messages.registration_no'), $trademark->registration_no),
                $field("Int'l Registration Date", $formatDate($trademark->int_registration_date)),
                $field(__('messages.filing_date'), $formatDate($trademark->filing_date_general)),
                $field('Contracting Party', $trademark->contracting_organization),
                $field(__('messages.registration_date'), $formatDate($trademark->registration_date)),
                $field('Designated Countries', $trademark->designated_countries),
                $field(__('messages.expiration_date'), $formatDate($trademark->expiration_date)),
                $field(__('messages.priority_no'), $trademark->priority_no),
                $field(__('messages.first_date'), $formatDate($trademark->first_date)),
                $field(__('messages.priority_date'), $formatDate($trademark->priority_date)),
                $field(__('messages.status'), \App\Support\TrademarkStatus::label($trademark->status)),
                $field('Country Office', $trademark->country_office),
                $field('Country', strcasecmp((string) $trademark->country, 'mexico') === 0 ? 'Mexico' : $trademark->country),
                $field('Origin', \App\Support\TrademarkOrigin::label($trademark->origin)),
            ],
        ],
        [
            'title' => 'Trademark',
            'items' => [
                $field('Trademark', $trademark->trademark),
                $field('Representation / Logo', $trademark->design, false, false, true),
                $field('Type of Application', $trademark->type_application),
                $field('Type of Mark', $trademark->type_mark),
                $field('Description of the Mark', $trademark->description_trademark, false, true),
                $field(__('messages.translation'), $trademark->translation, false, true),
                $field(__('messages.transliteration'), $trademark->transliteration_trademark, false, true),
                $field('Disclaimer', $trademark->disclaimer, false, true),
            ],
        ],
        [
            'title' => 'Goods / Services',
            'single' => true,
            'items' => [
                $field(__('messages.class'), $trademark->class),
                $field(__('messages.description'), $trademark->description_good, true, true),
                $field(__('messages.translation'), $trademark->translation_good, true, true),
            ],
        ],
        [
            'title' => 'Owner',
            'items' => [
                $field(__('messages.holder'), optional($trademark->Holder)->company_name),
                $field(__('messages.industrial_address'), $trademark->industrial_address, false, true),
                $field(__('messages.address'), optional($trademark->AddressHolder)->address, false, true),
            ],
        ],
        [
            'title' => 'Client',
            'items' => [
                $field(__('messages.client'), optional($trademark->Client)->company_name),
                $field('Invoice Recipient', optional($trademark->Client)->company_name),
                $field(__('messages.contact'), optional($trademark->ContactClient)->name),
                $field(__('messages.email'), optional($trademark->ContactClient)->email),
                $field(__('messages.address'), optional($trademark->AddressContact)->address, false, true),
                $field(__('messages.billing_address'), optional($trademark->AddressContact)->billing_address, false, true),
            ],
        ],
        [
            'title' => 'Dates and Deadlines',
            'items' => [
                $field(__('messages.publication_date'), $formatDate($trademark->publication_date)),
                $field('Opposition Date', $formatDate($trademark->filing_date_opposition)),
                $field(__('messages.opposition_no'), $trademark->opposition_no),
                $field('Office Action Date', $formatDate($trademark->filing_date_litigation)),
                $field(__('messages.litigation_no'), $trademark->litigation_no),
                $field(__('messages.declarations_use') . ' - ' . __('messages.last'), $formatDate($trademark->last_declaration)),
                $field(__('messages.declarations_use') . ' - ' . __('messages.next'), $formatDate($trademark->next_declaration)),
                $field(__('messages.renewals') . ' - ' . __('messages.last'), $formatDate($trademark->last_renewal)),
                $field(__('messages.renewals') . ' - ' . __('messages.next'), $formatDate($trademark->next_renewal)),
            ],
        ],
        [
            'title' => 'Notes',
            'single' => true,
            'items' => [
                $field(__('messages.note'), $trademark->notes, true, true),
            ],
        ],
    ];

    $visibleSections = collect($sections)
        ->map(function ($section, $index) {
            $section['number'] = $index + 1;
            $section['items'] = collect($section['items']);
            if ($section['title'] !== 'General') {
                $section['items'] = $section['items']->filter(fn ($item) => filled($item['value']));
            }
            return $section;
        })
        ->filter(fn ($section) => $section['items']->isNotEmpty())
        ->values();

@endphp

<div class="container-fluid mt-3 tm-show-page tm-compact-file">
    <div class="tm-actions tm-page-actions" aria-label="File actions">
        <a class="tm-btn" href="{{ route('index.trademarks') }}">{{ __('messages.back') }}</a>
        <a class="tm-btn tm-btn-primary" href="{{ route('edit.trademarks', $trademark->id) }}">Edit</a>
    </div>
    <div class="tm-file-shell">
        @include('trademark._header', ['isNewFile' => false])

        @foreach($visibleSections as $sectionIndex => $section)
            <section class="tm-section" id="{{ \Illuminate\Support\Str::slug($section['title']) }}">
                <h2 class="tm-section-heading">
                    <span>{{ str_pad($section['number'], 2, '0', STR_PAD_LEFT) }} |</span> {{ $section['title'] }}
                </h2>

                <div class="tm-field-grid {{ !empty($section['single']) ? 'is-single' : '' }}">
                    @foreach($section['items'] as $item)
                        <div class="tm-field {{ $item['full'] ? 'is-full' : '' }} {{ $item['tall'] ? 'is-tall' : '' }} {{ $item['logo'] ? 'is-logo' : '' }}">
                            <span class="tm-label">{{ $item['label'] }}</span>

                            @if($item['logo'])
                                <div class="tm-logo-box">
                                    <img class="tm-design-image" src="{{ asset('design/'.$item['value']) }}" alt="Trademark design">
                                </div>
                            @else
                                <p class="tm-value {{ $section['title'] === 'General' && in_array($item['label'], [__('messages.registration_date'), __('messages.expiration_date')], true) ? 'tm-emphasized' : '' }}">{{ $item['value'] ?? '—' }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>
</div>
@endsection
