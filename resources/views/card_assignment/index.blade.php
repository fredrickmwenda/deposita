@extends('layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Card Assignments</h4>
                    <a href="{{ route('card-assignment.create') }}" class="btn btn-success">Assign Card</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Card Number</th>
                                    <th>Attendant</th>
                                    <th>Assigned From</th>
                                    <th>Assigned To</th>
                                    <th>Status</th>
                                    @if(Auth::user()->grant_role === 'full_control')
                                    <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assignments as $assignment)
                                <tr>
                                    <td>{{ $assignment->id }}</td>
                                    <td>{{ $assignment->card->number ?? '-' }}</td>
                                    <td>{{ $assignment->attendant->name ?? '-' }}</td>
                                    <td>{{ $assignment->assigned_from }}</td>
                                    <td>{{ $assignment->assigned_to ?? '-' }}</td>
                                    <td>{{ ucfirst($assignment->status) }}</td>
                                    @if(Auth::user()->grant_role === 'full_control')
                                    <td>
                                        <a href="{{ route('card-assignment.edit', $assignment->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('card-assignment.destroy', $assignment->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
