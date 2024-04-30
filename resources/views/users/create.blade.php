@extends('layouts.app')

@push('css')
	<link href="{{asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0 font-size-18">Create User</h4>

					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="{{route('users.index')}}">Users</a></li>
							<li class="breadcrumb-item active">Create User</li>
						</ol>
					</div>

				</div>
			</div>
		</div>                      
		<div class="row">
			<div class="col-12">
				<div class="card">
					<!-- display errors -->
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

						<h4 class="card-title">User Details</h4>
						<!-- <p class="card-title-desc">Fill all information below</p> -->
						<!-- novalidate -->
						<form class="needs-validation" method="POST" action="{{route('users.store')}}" novalidate>
							@csrf

							<div class="form-group row mb-4">
								<label for="user_name">Name</label>
								<input id="user_name" name="name" type="text" class="form-control"  required>
							</div>

							<div class="form-group row mb-4">
								<label for="school_phone">Phone</label>
								<input id="school_phone" name="phone" type="text" class="form-control" >
							</div>

							<div class="form-group row mb-4">
								<label for="school_email">Email</label>
								<input id="school_email" name="email" type="email" class="form-control"  required>
							</div>

							<div class="form-group row mb-4">
								<label for="grant_role">Grant</label>
								<select class="form-control" name="grant_role">
									<!-- <option> Grant Role </option> -->
									<option value="read_only"> Read Only </option>
									<option value="modify"> Modify </option>
									<option value="full_control"> Full Control </option>
								</select>
							</div>


							<div class="form-group row mb-4">
								<label for="password">Password</label>
								<input id="password" name="password" type="password" class="form-control"  required>
							</div>

							<div class="form-group row mb-4">
								<label for="password_confirmation">Confirm Password</label>
								<input id="password_confirmation" name="password_confirmation" type="password" class="form-control"  required>
							</div>
							<div class="d-flex flex-wrap gap-2">
								<button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
								<button type="button" class="btn btn-secondary waves-effect waves-light">Cancel</button>
							</div>
						</form>

					</div>
				</div>


			</div>
		</div>
</div>
</div>
@endsection

@push('js')
        <!-- select 2 plugin -->
        <script src="{{ asset('assets/libs/select2/js/select2.min.js')}}"></script>

		<script>
		    $(".select2").select2();
		</script>

@endpush

