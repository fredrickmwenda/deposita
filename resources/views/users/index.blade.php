@extends('layouts.app')
@push('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Users List</h4>

                    <!-- <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Users</a></li>
                            <li class="breadcrumb-item active">Users List</li>
                        </ol>
                    </div> -->

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4">
                            <h4 class="card-title">Total Users: {{$users->count()}}</h4>
                                <!-- <div class="search-box me-2 mb-2 d-inline-block">
                                    <div class="position-relative">
                                        <input type="text" class="form-control" placeholder="Search...">
                                        <i class="bx bx-search-alt search-icon"></i>
                                    </div>
                                </div> -->
                            </div>
                            <div class="col-sm-8">
                                <div class="text-sm-end">
                                    <a href="{{ route('users.create') }}" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i class="mdi mdi-plus me-1"></i> Add New User</a>
                                </div>
                            </div><!-- end col-->
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-check" id="s-datatable">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 20px;" class="align-middle">
                                            <div class="form-check font-size-16">
                                                <input class="form-check-input" type="checkbox" id="checkAll">
                                                <label class="form-check-label" for="checkAll"></label>
                                            </div>
                                        </th>
                                        <th class="align-middle">ID</th>
                                        <th class="align-middle">Name</th>
                                        <th class="align-middle">Email</th>
                                        <th class="align-middle">Phone</th>
                                        <th class="align-middle">Grant</th>
                                        <th class="align-middle">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach ($users as $key => $user)
                                        <td>
                                            <div class="form-check font-size-16">
                                                <input class="form-check-input" type="checkbox" id="orderidcheck01">
                                                <label class="form-check-label" for="orderidcheck01"></label>
                                            </div>
                                        </td>
                                        <!-- <td><a href="javascript: void(0);" class="text-body fw-bold">#SK2540</a> </td> -->
                                        <td>{{ $key+1 }}</td>
                                        <td>
                                            @if ($user->profile_picture)
                                            <img src="{{asset('assets/images/profile/'.$user->profile_picture) }}" alt="" class="avatar-xs rounded-circle me-2" height="10px" width="10px">
                                            @else
                                            <img src="{{ asset('assets/images/users/avatar-2.jpg') }}" alt="" class="avatar-xs rounded-circle me-2" height="10px" width="10px">
                                            @endif
                                            <a href="javascript: void(0);" class="text-body fw-bold">{{ $user->name }}</a>       
                                        </td>
                                        <td>
                                            <a href="mailto:{{ $user->email }}" class="text-body fw-bold">{{ $user->email }}</a>
                                        </td>
                                        <td>
                                            <a href="tel:{{ $user->phone }}" class="text-body fw-bold">{{ $user->phone }}</a>
                                        </td>
                                        <td>
                                            {{ $user->grant_role }}
                                        </td>

                                        <td>
                                            <div class="d-flex gap-3">
                                                <a href="{{ route('users.edit',$user->id) }}" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                <a href="javascript:void(0);" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach


                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div> 
</div>


@endsection
@push('js')
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
@endpush