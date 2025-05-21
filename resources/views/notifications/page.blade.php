@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Notifications</h2>
    <div class="mb-3">
        <form method="POST" action="{{ route('notifications.markAllRead') }}">
            @csrf
            <button type="submit" class="btn btn-primary btn-sm">Mark All as Read</button>
        </form>
    </div>
    <ul class="list-group">
        @forelse(Auth::user()->notifications as $notification)
            <li class="list-group-item d-flex justify-content-between align-items-center @if($notification->read_at == null) list-group-item-warning @endif">
                <div>
                    <strong>{{ $notification->data['message'] }}</strong><br>
                    <small>{{ $notification->data['user_name'] }} ({{ $notification->data['user_email'] }})</small>
                </div>
                @if($notification->read_at == null)
                <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">Mark as Read</button>
                </form>
                @else
                <span class="badge bg-secondary">Read</span>
                @endif
            </li>
        @empty
            <li class="list-group-item">No notifications found.</li>
        @endforelse
    </ul>
</div>
@endsection
