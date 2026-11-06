@extends('layouts.app')
@section('template_title', $kind === 'task' ? 'New Task' : 'New Event')
@section('content')
<div class="card account-panel">
    <div class="card-header"><h1>{{ $kind === 'task' ? 'New Task' : 'New Event' }}</h1></div>
    <div class="card-body">
        @if(session('activity_saved'))<p role="status">{{ $kind === 'task' ? 'Task saved.' : 'Event saved.' }}</p>@endif
        <form action="{{ route($kind === 'task' ? 'tasks.store' : 'events.store') }}" method="POST">
            @csrf
            <label for="activity-title">Title</label><input class="form-control" id="activity-title" name="title" value="{{ old('title') }}" maxlength="255" required>
            @error('title')<p role="alert">{{ $message }}</p>@enderror
            <label for="activity-description">Description</label><textarea class="form-control" id="activity-description" name="description" rows="4">{{ old('description') }}</textarea>
            <label for="activity-start">{{ $kind === 'task' ? 'Due date and time' : 'Start date and time' }}</label><input class="form-control" id="activity-start" name="starts_at" type="datetime-local" value="{{ old('starts_at') }}" @required($kind === 'event')>
            @error('starts_at')<p role="alert">{{ $message }}</p>@enderror
            @if($kind === 'event')
            <label for="activity-end">End date and time</label><input class="form-control" id="activity-end" name="ends_at" type="datetime-local" value="{{ old('ends_at') }}">
            @error('ends_at')<p role="alert">{{ $message }}</p>@enderror
            @endif
            <button class="btn btn-primary mt-3" type="submit">Save</button>
        </form>
    </div>
</div>
@endsection
