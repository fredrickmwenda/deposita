@extends('layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Edit Card Assignment</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('card-assignment.update', $assignment->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="attendant_id" class="form-label">Attendant</label>
                                <select name="attendant_id" class="form-control" required>
                                    @foreach($attendants as $attendant)
                                        <option value="{{ $attendant->id }}" @if($assignment->attendant_id == $attendant->id) selected @endif>{{ $attendant->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="card_id" class="form-label">Card Number</label>
                                <select name="card_id" class="form-control" required>
                                    @foreach($cards as $card)
                                        <option value="{{ $card->id }}" @if($assignment->card_id == $card->id) selected @endif>{{ $card->number }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                        <form action="{{ route('card-assignment.destroy', $assignment->id) }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
