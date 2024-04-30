@extends('layouts.app')
@push('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">DROP List </h4>



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
                                <h4 class="card-title">Total Data Displayed: {{ $csvs->count() }}</h4>
                            </div>
                            @if (Auth::user()->grant_role === 'full_control' || Auth::user()->grant_role === 'modify')
                            <div class="col-sm-8">
                                <div class="text-sm-end">
                                    <a href="{{route('storage.create')}}" type="button" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i class="mdi mdi-plus me-1"></i>Add Drop Record</a>
                                </div>
                            </div>
                            @endif
                            <!-- end col-->
                        </div>

                        

                        <div class="row mb-2">
                            <div class="col-lg-12">
                            <form method="GET" action="{{ route('storage.index') }}">
                                <div class="row mb-4">
                                    <div class="col-lg-3">
                                    <div class="form-group row">
                                        <div class="">
                                        {{ __('Date:') }}
                                        </div>
                                        <div class="col-lg-10">
                                        <input type="date" class="form-control" name="from_date" >                          
                                        </div>
                                    </div>
                                    </div>


                                    <div class="col-lg-3">
                                    <div class="form-group row">
                                        <div class="">
                                        {{ __('Shift:') }}
                                        </div>
                                        <div class="col-lg-10">
                                            <select class="form-control" name="shifit">
                                                <option > Select Shift</option>
                                                <option value="0">Day</option>
                                                <option value="1">Night</option>
                                            </select>
                                        
                                        </div>
                                    </div>
                                    </div>
                                    <!--field to enter the ro name-->
        
                                    <div class="col-lg-3">
                                    <div class="form-group row">
                                        <!-- <div class="col-lg-12"> -->
                                        <div class="input-group mt-3">
                                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i>Filter</button>
                                            <a href="{{ route('storage.index') }}" class="btn btn-danger ml-2"><i class="fas fa-sync-alt"></i>Clear</a>
                                        </div>
                                        <!-- </div> -->
                                    </div>
                                    </div>
                                </div>
                            </form>
             
                            </div>
                        </div>

                        @if (Auth::user()->grant_role === 'full_control')
                        <div class="row">
                            <button style="display: none" id="assign_button" class="float-left col-3 btn btn-primary">Delete Multiple Drops</button>
                        </div>
                        @endif

                        <div class="table-responsive">                             
                            <table class="table align-middle table-nowrap table-check"  id="drop-datatable">
                                <thead class="table-light">
                                    <tr>
                                       <th style="width: 20px;" class="align-middle">
                                            <div class="form-check font-size-16">
                                                <input class="form-check-input" type="checkbox" id="checkAll">
                                                <label class="form-check-label" for="checkAll"></label>
                                            </div>
                                        </th>
                                        <th class="align-middle">Date</th>
                                        <th class="align-middle">Shift</th>
                                        <th class="align-middle">Attendant Name</th>
                                        <th class="align-middle">Drop</th>
                                        <th class="align-middle">Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($csvs as $csv)
                                    <tr>
                                        <td>
                                            <div class="form-check font-size-16">
                                                <input class="form-check-input" type="checkbox" id="orderidcheck{{$csv->id}}">
                                                <label class="form-check-label" for="orderidcheck{{$csv->id}}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $csv->DateTime}}
                                        </td>
                                        <td>
                                            @if($csv->shift == 0 )
                                            Day
                                            @else
                                            Night
                                            @endif                                          
                                        </td>
                                        <td>
                                            {{ $csv->Card_name}}
                                        </td>
                                        <td>
                                            {{ number_format($csv->Total) }}
                                        </td>

                                        <td>
                                            <div class="d-flex gap-3"> 
                                                @if (Auth::user()->grant_role === 'full_control' || Auth::user()->grant_role === 'modify')                                          
                                                <a href="{{ route('storage.edit', $csv->id) }}" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                @endif
                                                @if (Auth::user()->grant_role === 'full_control')                      
                                                <a href="{{ route('storage.delete', $csv->id) }}" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a>
                                                @endif
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


    <!-- MODAL STICK UP  -->
    <div class="modal fade stick-up" id="multiple_drops_modal" tabindex="-1" role="dialog" aria-labelledby="addNewModal"
        aria-hidden="true">
        <div class="modal-dialog">       
            <form  id="multiple_drops_form">
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
                        <!-- <button id="mass_assign_form_button" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Assign</button> -->
                        <button id="mass_delete_form_button" class="btn btn-primary  btn-cons">Mass Delete</button>
                        <button type="button" class="btn btn-cons" data-bs-dismiss="modal">Close</button>
                    </div>


                </div>
            </form>

            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- End Modal -->
<!-- Modal -->

<!-- end modal -->
@endsection

@push('js')
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script>
$(document).ready(function() {
    $("#drop-datatable").DataTable({
        "pageLength": 25,
        "order": [[0, "desc"]], // use the same sorting order as the database query
        responsive: true,
    });
    

    $('#drop-datatable tbody').on('change', 'input[type="checkbox"][class="form-check-input"]', function () {
        $(this).closest('tr').toggleClass('selected');
        if ($('input[type="checkbox"][class="form-check-input"]:checked').length > 0) {
            $('#assign_button').show();
        } else {
            $('#assign_button').hide();
        }
    });

    $('#assign_button').click(function () {
        $('#multiple_drops_modal').modal('show')
    });

    $('#mass_delete_form_button').click(function (e) {

        e.preventDefault()

        var ids = [];

        $('input[type="checkbox"][class="form-check-input"]:checked').each(function() {
            ids.push($(this).attr('id').replace('orderidcheck', ''));
        });

        console.log('ids');
        console.log(ids);

        postReplyToast = toastr.info("Processing your request.");

        $.ajax({
            url: "{{route('drops.mass-delete')}}",
            method: "POST",
            data: {
                'ids': ids,
                "_token": "{{ csrf_token() }}",
            },
        }).done(function (data) {
            console.log(data);
            if (data.success) {
                postReplyToast = toastr.success(data.message);
                // ticketsTable.rows('.selected').remove().draw();
                $('input[type="checkbox"][class="form-check-input"]:checked').prop('checked', false);
                $('#assign_button').hide();
                //remove the modal
                $('#multiple_drops_modal').remove();
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
});
</script>
@endpush




