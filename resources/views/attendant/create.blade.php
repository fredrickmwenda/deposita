@extends('layouts.app')
@section('content')
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0 font-size-18">Create Attendant</h4>
				</div>
			</div>
		</div>                      
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<form action="{{ route('attendant.store') }}" method="POST">
							@csrf
							<div class="mb-3">
								<label for="name" class="form-label">Attendant Name</label>
								<input type="text" name="name" class="form-control" required>
							</div>
							<div class="mb-3">
								<label for="status" class="form-label">Status</label>
								<select name="status" class="form-control" required>
									<option value="active">Active</option>
									<option value="inactive">Inactive</option>
								</select>
							</div>
							<button type="submit" class="btn btn-primary">Create</button>
						</form>
					</div>
				</div>


			</div>
		</div>
</div>
</div>
@endsection



