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
                    <!-- <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Reports</a></li>
                            <li class="breadcrumb-item active">Schedule Report</li>
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
                                <h4 class="card-title">Cashier Record for {{$transaction->attendant->Card_name}} on {{$transaction->created_at}} {{ $transaction->shift }}</h4>
                            </div>

                        </div>
                        

                        <div class="table-responsive">                             
                          <table class="table align-middle table-nowrap table-check" id="shift-datatable">
                              <thead class="table-light">
                                  <tr>
                                        <!-- <th style="width: 20px;" class="align-middle">
                                            <div class="form-check font-size-16">
                                                <input class="form-check-input" type="checkbox" id="checkAll">
                                                <label class="form-check-label" for="checkAll"></label>
                                            </div>
                                        </th> -->
                                      
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
                                      <!-- <th class="align-middle">Action </th> -->
                                      <!-- <th class="align-middle">Created At</th> -->
                                  </tr>
                              </thead>
                              <tbody>
                                
                                <tr>
                                    <!-- <td>
                                        <div class="form-check font-size-16">
                                            <input class="form-check-input" type="checkbox" id="orderidcheck{{$transaction->id}}">
                                            <label class="form-check-label" for="orderidcheck{{$transaction->id}}"></label>
                                        </div>
                                    </td> -->
                                    
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

                                    <!-- <td>
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                Action <i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            @if (Auth::user()->grant_role === 'full_control' || Auth::user()->grant_role === 'modify')
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#add-recovery-modal" data-transaction-id="{{ $transaction->id }}"  data-attendant-date="{{$transaction->date}}" data-attendant-name="{{ $transaction->attendant->Card_name }}">Add Recovery</button>
                                                <a class="dropdown-item" href="{{ route('transaction.edit', $transaction->id) }}" class="text-danger">Edit </a>
                                                <a class="dropdown-item" href="{{ route('transaction.delete', $transaction->id) }}" class="text-danger">Delete </a>
                                            </div>
                                            @endif
                                        </div>
                                    </td>                                 -->
                                                                
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

  
<!-- <div class="modal fade stick-up" id="multiple_records_modal" tabindex="-1" role="dialog" aria-labelledby="addNewModal"
    aria-hidden="true">
    <div class="modal-dialog">       
        <form  id="multiple_records_form">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deleting Multiple Drops</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p> Are you sure, you wanna delete these records</p>
                </div>
                <div class="modal-footer">
                    
                    <button id="records_delete_form_button" class="btn btn-primary  btn-cons">Mass Delete</button>
                    <button type="button" class="btn btn-cons" data-bs-dismiss="modal">Close</button>
                </div>


            </div>
        </form>

    </div>
    
</div> -->
    

<!-- <div class="modal fade" id="add-coin-modal" tabindex="-1" role="dialog" aria-labelledby="add-coin-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-coin-modal-label">Add Coin</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Attendant: <span id="attendant-name"></span></p>
                <p>Date: <span id="attendant-date"></span></p>

                <form method="POST" action="">
                    @csrf
                    <div class="form-group">
                        <label for="recovery-amount">coin Amount:</label>
                        <input type="number" name="coin_amount" id="coin-amount" class="form-control">
                    </div>
                    
                    <button type="submit" class="btn btn-primary mt-2">Add Coin</button>
                </form>
            </div>
        </div>
    </div>
</div> -->

<!-- <div class="modal fade" id="add-recovery-modal" tabindex="-1" role="dialog" aria-labelledby="add-recovery-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-recovery-modal-label">Add Recovery</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Attendant: <span id="recovery_attendant-name"></span></p>
                <p>Date: <span id="recovery_attendant-date"></span></p>
                <form method="POST" action="">
                    @csrf
                    <div class="form-group">
                        <label for="recovery-amount">Recovery Amount:</label>
                        <input type="number" name="recovery_amount" id="recovery-amount" class="form-control" required>
                    </div>
                   
                    <div class="form-group mt-3">
                        <label for="coin">Comment</label>
                        <textarea class="form-control" name="comment" id="comment" cols="10" rows="3"></textarea>									
                    </div>
								
                    
                    <button type="submit" class="btn btn-primary mt-2">Add Recovery</button>
                </form>
            </div>
        </div>
    </div>
</div> -->



@endsection

@push('js')
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script>
$(document).ready(function() {
    $("#shift-datatable").DataTable({
        "pageLength": 25,
        //ORDER BY ID DESC
        responsive: true,
    });

    $('#shift-datatable tbody').on('change', 'input[type="checkbox"][class="form-check-input"]', function () {
        $(this).closest('tr').toggleClass('selected');
        if ($('input[type="checkbox"][class="form-check-input"]:checked').length > 0) {
            $('#del_records_button').show();
        } else {
            $('#del_records_button').hide();
        }
    });

    $('#del_records_button').click(function () {
        $('#multiple_records_modal').modal('show')
    });

    $('#records_delete_form_button').click(function (e) {

        e.preventDefault()

        var ids = [];

        $('input[type="checkbox"][class="form-check-input"]:checked').each(function() {
            ids.push($(this).attr('id').replace('orderidcheck', ''));
        });

        console.log('ids');
        console.log(ids);

        postReplyToast = toastr.info("Processing your request.", );

        $.ajax({
            url: "{{route('records.mass-delete')}}",
            method: "POST",
            data: {
                'ids': ids,
                "_token": "{{ csrf_token() }}",
            },
        }).done(function (data) {
            console.log(data);
            if (data.success) {
                postReplyToast = toastr.success(data.message, { timeOut: 10000 });
                // ticketsTable.rows('.selected').remove().draw();
                $('input[type="checkbox"][class="form-check-input"]:checked').prop('checked', false);
                $('#del_records_button').hide();
                //remove the modal
                $('#multiple_records_modal').remove();
                // reload the page
                location.reload();
            } 
            else {
                postReplyToast = toastr.error(data.error.message + " " + data.error.details);
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            postReplyToast = toastr.error('Error: ' + errorThrown);
        });
    });
    
    $('.dropdown-item[data-bs-target="#add-coin-modal"]').click(function() {
        var transactionId = $(this).data('transaction-id');
        var attendantName = $(this).data('attendant-name');
        var attendantDate = $(this).data('attendant-date');
        $('#attendant-name').text(attendantName);
        $('#attendant-date').text(attendantDate);
        $('#add-coin-modal form').attr('action', '/add-coin/' + transactionId);
    });

  $('.dropdown-item[data-bs-target="#add-recovery-modal"]').click(function() {
    var transactionId = $(this).data('transaction-id');
    var attendantName = $(this).data('attendant-name');
    var attendantDate = $(this).data('attendant-date');
    // console.log(attendantName);
    $('#recovery_attendant-name').text(attendantName);
    $('#recovery_attendant-date').text(attendantDate);
    $('#add-recovery-modal form').attr('action', '/add-recovery/' + transactionId);
  });



    
});
</script>

<script>
$(document).ready(function() {
    $("#drop-datatable").DataTable({
        "pageLength": 25,
        "order": [[0, "desc"]], // use the same sorting order as the database query
        responsive: true,
    });
});
</script>
@endpush



