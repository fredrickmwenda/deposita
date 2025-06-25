@extends('layouts.app')
@section('content')
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0 font-size-18">Edit Attendant</h4>
				</div>
			</div>
		</div>                      
		<div class="row">
			<div class="col-12">
				<div class="card">
					@if ($errors->any())
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
					<div class="card-body">

						<!-- <h4 class="card-title">Data Storage</h4> -->

                        <form action="{{ route('attendant.update', $attendant->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group row mb-4">
                                <label for="card_name">Attendant Name</label>
                                <input type="text" name="Card_name" class="form-control" value="{{ $attendant->name ?? $attendant->Card_name }}">
                            </div>
                            <div class="form-group row mb-4">
                                <label for="card_number">Card Number</label>
                                <input type="text" name="Card_number" class="form-control" value="{{ optional($attendant->assignments()->latest('assigned_from')->first())->card->number ?? $attendant->Card_number }}">
                                <small class="form-text text-muted">Changing the card number will reassign this attendant to a new card and preserve history.</small>
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('attendant.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>

					</div>
				</div>


			</div>
		</div>
</div>
</div>
@endsection



