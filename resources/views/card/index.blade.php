@extends('layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Cards</h4>
                    <a href="{{ route('card.create') }}" class="btn btn-success">Create Card</a>
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
                                    @if(Auth::user()->grant_role === 'full_control')
                                    <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cards as $card)
                                <tr>
                                    <td>{{ $card->id }}</td>
                                    <td>{{ $card->number }}</td>
                                    @if(Auth::user()->grant_role === 'full_control')
                                    <td>
                                        <a href="{{ route('card.edit', $card->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('card.destroy', $card->id) }}" method="POST" style="display:inline-block;">
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
