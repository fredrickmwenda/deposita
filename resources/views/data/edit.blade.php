@extends('layouts.app')
@section('content')
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0 font-size-18">Edit Drop List</h4>
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

						<h4 class="card-title">Editing Drop List for Attendant: {{ $csv->Attendant->Card_name }}</h4>

                        <form action="{{ route('storage.update', $csv->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
							<div class="row">
								<div class="col-md-6 col-sm-6">
								    <div class="mb-3">
									    <label for="DateTime">DateTime</label>
										<input type="datetime-local" class="form-control" id="DateTime" name="DateTime" value="{{ \Carbon\Carbon::createFromFormat('d/m/Y H:i', $csv->DateTime)->format('Y-m-d\TH:i') }}">
									</div>
								</div>

								<div class="col-md-6 col-sm-6">
								    <label for="shift">Shift</label>
								    <select class="form-control select2" name="shift" id="shift" required disabled>
									    <option value="{{ $csv->shift }}" selected>{{ $csv->shift == 0 ? 'Day Shift' : 'Night Shift' }}</option>
									</select>
								</div>

							</div>

							<div class="row">
								<div class="col-md-6 col-sm-6">
								    <div class="mb-3">
									    <label for="CardNumber">Card Number</label>
										@php
									       $cardNumber = str_replace(' ', '', $csv->Card_number);
									    @endphp
                                        <input type="number" class="form-control" id="Card_number" name="Card_number" value="{{ $cardNumber }}" readonly>
                                        <!-- <input type="number" class="form-control" id="Card_number" name="Card_number" value="{{ $csv->Card_number }}" readonly> -->
									</div>
								</div>

								<div class="col-md-6 col-sm-6">
								    <div class="mb-3">
									    <label for="Total">Total</label>
                                        <input type="number" class="form-control" id="Total" name="Total" value="{{ $csv->Total }}" required readonly>
									</div>
								</div>

							</div>
                             


                            <!-- <div class="form-group row mb-4">
                                <label for="sequence">Sequence</label>
                                <input type="number" class="form-control" id="sequence" name="Sequence" value="{{ $csv->Sequence }}">
                            </div>

                            <div class="form-group row mb-4">
                                <label for="Total">Total</label>
                                <input type="number" class="form-control" id="Total" name="Total" value="{{ $csv->Total }}">
                            </div>

                            <div class="form-group row mb-4">
                                <label for="DateTime">Date Time</label>
                                <input type="datetime-local" class="form-control" id="DateTime" name="DateTime" value="{{ $csv->DateTime }}">
                            </div> -->

							<div class="d-flex flex-wrap gap-2 mt-2">
								<button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
								<a href="{{ route('storage.index')}}" type="button" class="btn btn-secondary waves-effect waves-light">Cancel</a>
							</div>


						</form>

					</div>
				</div>


			</div>
		</div>
</div>
</div>
@endsection



