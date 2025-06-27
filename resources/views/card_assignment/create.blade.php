@extends('layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Assign Card to Attendant</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('card-assignment.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="attendant_id" class="form-label">Attendant</label>
                                <select name="attendant_id" class="form-control" required>
                                    <option value="">Select Attendant</option>
                                    @foreach($attendants as $attendant)
                                        <option value="{{ $attendant->id }}">{{ $attendant->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="card_id" class="form-label">Card Number</label>
                                <select name="card_id" class="form-control" required>
                                    <option value="">Select Card</option>
                                    @foreach($cards as $card)
                                        <option value="{{ $card->id }}">{{ $card->number }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Assign</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
