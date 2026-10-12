@php
    // New files use the requested placeholders; saved files use persisted values.
    $isNewFile = $isNewFile ?? false;
    $fileTitle = $isNewFile ? 'Trademark' : ($trademark->trademark ?: 'Trademark');
    $rawStatus = $isNewFile ? '' : trim((string) $trademark->status);
    $isRegistered = \App\Support\TrademarkStatus::key($rawStatus) === 'registered';
    $hasRegistration = !$isNewFile && filled($trademark->registration_no)
        && ($isRegistered || $rawStatus === '');
    $fileNumber = $isNewFile ? 'Application No.' : ($hasRegistration
        ? 'Registration No. ' . $trademark->registration_no
        : 'Application No.' . (filled($trademark->application_no) ? ' ' . $trademark->application_no : ''));
    $fileClass = 'Class' . (!$isNewFile && filled($trademark->class) ? ' ' . $trademark->class : '');
    $fileOwner = $isNewFile ? 'Owner' : optional($trademark->Holder)->company_name;
    $fileClient = $isNewFile ? 'Client' : optional($trademark->Client)->company_name;
    $fileRefs = $isNewFile ? 'O/Ref. – C/Ref.' : collect([
        filled($trademark->our_ref) ? 'O/Ref. ' . $trademark->our_ref : null,
        filled($trademark->client_ref) ? 'C/Ref. ' . $trademark->client_ref : null,
    ])->filter()->implode(' – ');
    $fileStatus = \App\Support\TrademarkStatus::label($rawStatus);
@endphp
<header class="tm-header tm-record-header">
    <div>
        <div class="tm-title-line">
            <h1 class="tm-title">{{ $fileTitle }}</h1>
            @if($fileStatus !== '')
                <span class="tm-status-pill {{ $isRegistered ? 'is-registered' : '' }}">{{ $fileStatus }}</span>
            @endif
        </div>
        <div class="tm-header-meta">
            <strong>{{ $fileNumber }} – {{ $fileClass }}</strong>
            @if(filled($fileOwner))<span>{{ $fileOwner }}</span>@endif
            @if(filled($fileClient))<span>{{ $fileClient }}</span>@endif
            @if(filled($fileRefs))<span class="tm-header-muted">{{ $fileRefs }}</span>@endif
        </div>
    </div>
</header>
