@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Drop List For {{$attendant}} </h4>
                    <div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="{{route('reports.periodic')}}">Cashier Periodic</a></li>
						</ol>
					</div>



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
                                <h4 class="card-title">Total Recoveries: {{ $recoveries->count() }}</h4>
                                <!-- <div class="search-box me-2 mb-2 d-inline-block">
                                    <div class="position-relative">
                                        <input type="text" class="form-control" placeholder="Search...">
                                        <i class="bx bx-search-alt search-icon"></i>
                                    </div>
                                </div> -->
                            </div>
  
                        </div>
   

                        <div class="table-responsive">                             
                          <table class="table align-middle table-nowrap table-check"  id="s-datatable">
                              <thead class="table-light">
                                  <tr>
                                      <th class="align-middle">Date Time </th>
                                      <th class="align-middle">Attendant Name</th>
                                      <th class="align-middle">Amount </th>
                                     
                                  </tr>
                              </thead>
                              <tbody>
                                @foreach ($recoveries as $dataStorage)
                                <tr>
                                    <td>{{ $dataStorage->created_at }}</td>
                                    <td>{{ $dataStorage->transaction->Attendant->Card_name}}</td>
                                    <td>{{ $dataStorage->recovery_amount }}</td>
                        
                                </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td><h3><strong>Total Recoveries</strong></h3></td>
                                    <td><strong>{{ $totalSum }}</strong></td>
                                </tr>
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




