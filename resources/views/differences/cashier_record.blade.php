@extends('layouts.app')
@push('css')
<style>
.dropdown-item {
  white-space: normal !important;
} 


</style>
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Cashier Record List</h4>
   
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
                                <h4 class="card-title">Cashier Record for {{$transaction->attendant->Card_name}} on {{$transaction->created_at}} {{ $transaction->shift }}</h4>
                            </div>

                        </div>
                        

                        <div class="table-responsive">                             
                          <table class="table align-middle table-nowrap table-check" id="cashier-dif-datatable">
                              <thead class="table-light">
                                  <tr>
                                     
                                      
                                      <th class="align-middle">Date</th>
                                      <th class="align-middle">Shift</th>
                                      <th class="align-middle">Attendant</th>
                                      <th class="align-middle">Drop</th>
                                      <th class="align-middle">Cash</th>
                                      <th class="align-middle"> Coin</th>                                   
                                      <th class="align-middle">Recovery</th>
                                      <th class="align-middle">Expected</th>
                                      <th class="align-middle">Difference</th>
                                      <th class="align-middle"> Comment </th>

                                  </tr>
                              </thead>
                              <tbody>
                                
                                <tr>
                                    
                                    
                                    <td>{{ $transaction->date }}</td>
                                    <td>{{ $transaction->shift }}</td>  
                                    <td>
                                    <a href="{{ route('showAttendantDrops', ['attendantId' => $transaction->attendant_id]) }}" class="fw-bold">{{ $transaction->attendant->Card_name }}</a></td>
                                    <td>{{ number_format($transaction->total) }} </td>
                                    <td>{{ number_format(floatval($transaction->cash)) }} </td>

                                    <td>{{ number_format($transaction->coins)}}</td>
                                    <td>{{ number_format($transaction->recoveries()->sum('recovery_amount')) }}</td> 
                                    <td>{{ number_format($transaction->expected) }}</td>
                                    <td>{{ number_format((float)$transaction->difference, 0, '.', ',') }}</td>
                                    <td>
                                        @if (!is_null($transaction->comment))
                                            @php
                                                $words = preg_split('/\s+/', $transaction->comment);
                                                if (is_array($words)) {
                                                    $words = array_slice($words, 0, 4);
                                                    $shortenedComment = implode(' ', $words);
                                                    if (!empty(trim($shortenedComment))) {
                                                        echo $shortenedComment . '...';
                                                    } else {
                                                        echo $transaction->comment;
                                                    }
                                                } else {
                                                    echo $transaction->comment;
                                                }
                                            @endphp
                                        @endif
                                    </td>                                                               
                                                                
                                </tr>
                                

                              </tbody>
                          </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>

  




@endsection

@push('js')
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script>
$(document).ready(function() {
    $("#cashier-dif-datatable").DataTable({
        "pageLength": 25,
        //ORDER BY ID DESC
        responsive: true,
    });

    $('#cashier-dif-datatable tbody').on('change', 'input[type="checkbox"][class="form-check-input"]', function () {
        $(this).closest('tr').toggleClass('selected');
        if ($('input[type="checkbox"][class="form-check-input"]:checked').length > 0) {
            $('#del_records_button').show();
        } else {
            $('#del_records_button').hide();
        }
    });

 
    
  



    
});
</script>


@endpush



