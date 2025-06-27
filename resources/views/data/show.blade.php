@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18"> Shift Data </h4>
                    <div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="{{route('storage.list')}}">Shift List</a></li>
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
                                <h4 class="card-title">Total Data : {{ $dataStorages->count() }}</h4>

                            </div>
  
                        </div>
   

                        <div class="table-responsive">                             
                          <table class="table align-middle table-nowrap table-check"  id="s-datatable">
                              <thead class="table-light">
                                  <tr>

                                      <th class="align-middle">ID</th>
                                      <th class="align-middle">Date Time </th>
                                      <th class="align-middle">Attendant Name</th>
                                      <th class="align-middle">Card Name </th>
                                      <th class="align-middle">Sequence </th>
                                      <th class="align-middle"> Total </th>
                                     
                                  </tr>
                              </thead>
                              <tbody>
                                @foreach ($dataStorages as $dataStorage)
                                <tr>
                                    <td>{{ $dataStorage->id }}</td>
                                    <td>{{ $dataStorage->created_at }}</td>
                                    <td>{{ $dataStorage->attendant_name }}</td>
                                    <td>{{ $dataStorage->Card_number }}</td>
                                    
                                    <td>{{ $dataStorage->Sequence }}</td>
                                    <td>{{ $dataStorage->Total }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><h3><strong>Total Drop</strong></h3></td>
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




