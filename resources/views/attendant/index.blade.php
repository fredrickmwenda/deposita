@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">CSV List </h4>



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
                                <h4 class="card-title">Total Attendants : {{ $attendants->count() }}</h4>
                                <!-- <div class="search-box me-2 mb-2 d-inline-block">
                                    <div class="position-relative">
                                        <input type="text" class="form-control" placeholder="Search...">
                                        <i class="bx bx-search-alt search-icon"></i>
                                    </div>
                                </div> -->
                            </div>
                            <div class="col-sm-8">
                                <div class="text-sm-end">
                                    <a href="{{route('attendant.create')}}" type="button" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i class="mdi mdi-plus me-1"></i>Create New Attendant</a>
                                </div>
                            </div><!-- end col-->
                        </div>
 

                        <div class="table-responsive">                             
                          <table class="table align-middle table-nowrap table-check"  id="s-datatable">
                              <thead class="table-light">
                                  <tr>

                                      <th class="align-middle">ID</th>
                                      <th class="align-middle">Attendant Name </th>
                                      <th class="align-middle">Attendant Number </th>
                                      <th class="align-middle">Action </th>
                                  </tr>
                              </thead>
                              <tbody>
                                @foreach($attendants as $key => $attendant)
                                  <tr>
                                      <td>{{ $attendant->id }}</td>
            
                                      <td>
                                          {{ $attendant->name}}
                                      </td>
                                       <td>
                                           {{ $attendant->Card_number}}
                                        </td>


                                      <td>
                                          <div class="d-flex gap-3">
                                             
                                              <a href="{{ route('attendant.edit', $attendant->id) }}" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>

                                              

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
<!-- Modal -->

<!-- end modal -->
@endsection




