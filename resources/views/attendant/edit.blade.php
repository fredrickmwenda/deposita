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
					<div class="card-body">
						<form action="{{ route('attendant.update', $attendant->id) }}" method="POST">
							@csrf
							@method('PUT')
							<div class="mb-3">
								<label for="name" class="form-label">Attendant Name</label>
								<input type="text" name="name" class="form-control" value="{{ $attendant->name }}" required>
							</div>
							<div class="mb-3">
								<label for="status" class="form-label">Status</label>
								<select name="status" class="form-control" required>
									<option value="active" @if($attendant->status == 'active') selected @endif>Active</option>
									<option value="inactive" @if($attendant->status == 'inactive') selected @endif>Inactive</option>
								</select>
							</div>
							<button type="submit" class="btn btn-primary">Update</button>
							<a href="{{ route('attendant.index') }}" class="btn btn-secondary">Cancel</a>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection



