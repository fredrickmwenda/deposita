@extends('layouts.app')
@section('content')
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0 font-size-18">Add Drops</h4>
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

                        <form action="{{ route('storage.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row mb-4">
								<label for="input_type">Shift </label>
                                <select class="form-control select2" name="shift" id="shift">
									<option>Select Shift </option>
                                    <option value="day">Day Shift</option>
                                    <option value="night"> Night Shift </option>
								</select>
							</div>                             
                            <div class="form-group row mb-4">
                                <label for="csv">CSV Data</label>
                                <input type="file" name="csv_file" class="form-control">								
                            </div>

							<div class="d-flex flex-wrap gap-2">
								<button type="submit" class="btn btn-primary waves-effect waves-light">Upload Data</button>
							</div>


						</form>

					</div>
				</div>


			</div>
		</div>
</div>
</div>
@endsection



