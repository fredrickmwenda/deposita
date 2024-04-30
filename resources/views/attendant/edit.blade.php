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
                            <div class="form-group row mb-4">
                                <label for="card_name">Attendant Name</label>
                                <input type="text" name="Card_name" class="form-control" value="{{ $attendant->Card_name }}">								
                            </div>

							<div class="form-group row mb-4">
                                <label for="card_number">Attendant Number</label>
                                <input type="text" name="Card_number" class="form-control" value="{{ $attendant->Card_number }}">								
                            </div>

							<div class="d-flex flex-wrap gap-2">
								<button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
							</div>


						</form>

					</div>
				</div>


			</div>
		</div>
</div>
</div>
@endsection



