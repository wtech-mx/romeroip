@php
    // New files use the requested placeholders; saved files use persisted values.
    $isNewFile = $isNewFile ?? false;
    $fileTitle = $isNewFile ? 'Trademark' : ($trademark->trademark ?: 'Trademark');
    $rawStatus = $isNewFile ? '' : trim((string) $trademark->status);
    $isRegistered = \App\Support\TrademarkStatus::key($rawStatus) === 'registered';
    $hasRegistration = !$isNewFile && filled($trademark->registration_no)
        && $isRegistered;
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
<header class="tm-header tm-record-header" data-trademark-header>
    <div>
        <div class="tm-title-line">
            <h1 class="tm-title" data-header="title">{{ $fileTitle }}</h1>
            <span data-header="status" class="tm-status-pill {{ in_array(strtolower($fileStatus), ['registered', 'pending', 'abandoned'], true) ? 'is-' . strtolower($fileStatus) : '' }}" @if($fileStatus === '') hidden @endif>{{ $fileStatus }}</span>
        </div>
        <div class="tm-header-meta">
            <strong data-header="number">{{ $fileNumber }} – {{ $fileClass }}</strong>
            <span data-header="owner">{{ $fileOwner ?: 'Owner' }}</span>
            <span data-header="client">{{ $fileClient ?: 'Client' }}</span>
            <span class="tm-header-muted" data-header="refs">{{ $fileRefs ?: 'O/Ref. – C/Ref.' }}</span>
        </div>
    </div>
</header>
