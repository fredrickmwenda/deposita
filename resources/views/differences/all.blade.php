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
                    <h4 class="mb-sm-0 font-size-18">Short/Gain List</h4>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-8">
                                <h4 class="card-title">Total Short/Gain Displayed: {{ $totalDifference }} for year {{$selectedYear}}</h4>
                            </div>

                            <!-- end col-->
                        </div>


                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-check" id="shift-datatable">
                                <thead class="table-light">
                                    <tr>

                                        <th class="align-middle">ID</th>
                                        <th class="align-middle">Attendant Name</th>
                                        <th class="align-middle">Short/Gain Total</th>
                                        <!-- <th class="align-middle">Created At</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attendantSumDifference as $attendantId => $sumDifference)
                                    @php
                                    $attendant = $attendants->firstWhere('id', $attendantId);
                                    @endphp
                                    @if ($sumDifference != 0)
                                    <tr>
                                        <td>{{ $attendantId }}</td>
                                        <td>{{ $attendant->Card_name }}</td>
                                        <td>
                                            <a href="{{ route('show.attendant.differences', ['attendantId' => $attendantId]) }}" class="fw-bold">{{ $sumDifference }}</a>
                                        </td>
                                    </tr>
                                    @endif
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
<script>
    $(document).ready(function() {
        $("#shift-datatable").DataTable({
            "pageLength": 25,
            //ORDER BY ID DESC
            responsive: true,
        });







    });
</script>

<!-- <script>
    $(document).ready(function() {
        $("#drop-datatable").DataTable({
            "pageLength": 25,
            "order": [
                [0, "desc"]
            ], // use the same sorting order as the database query
            responsive: true,
        });
    });
</script> -->
@endpush