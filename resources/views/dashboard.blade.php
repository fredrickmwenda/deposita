@extends('layouts.app')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/libs/apexcharts/apexcharts.min.css') }}">
@endpush

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>

        </div>
        <!-- end page title -->
        <div class="row">

            <div class="col-xl-12">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Users</p>
                                        <h4 class="mb-0">{{$users}}</h4>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                            <span class="avatar-title">
                                                <i class="bx bx-copy-alt font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Attendants</p>
                                        <h4 class="mb-0">{{$attendantsi}}</h4>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center ">
                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                <i class="bx bx-archive-in font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <p class="text-muted fw-medium">Total Drops</p>
                                        <h4 class="mb-0">{{$drops}}</h4>
                                    </div>

                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <!-- First row: Short/Gain text and Select Year dropdown -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted fw-medium">Short/Gain</p>

                                    </div>
                                    <div class="pb-3">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle" href="#" role="button" id="yearDropdown" aria-expanded="false">
                                                Select Year
                                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="yearDropdown" id="yearDropdownMenu"></div>
                                        </div>
                                    </div>


                                </div>

                                <!-- Second row: Short/Gain data and avatar -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <!-- Short/Gain data -->
                                    <div>
                                        <h4 class="mb-0" id="shorting">

                                        </h4>

                                    </div>

                                    <!-- Avatar -->
                                    <div class="flex-shrink-0 align-self-center ml-3">
                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
                <!-- end row -->


            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-sm-flex flex-wrap">
                            <h4 class="card-title mb-4">Short/Gain Statistics</h4>
                            <div class="ms-auto d-flex align-items-center">
                                <select id="yearSelect" class="form-select form-select-sm me-2" style="width: 100px;">
                                </select>
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link" data-period="year" href="javascript:void(0);">Year</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-period="week" href="javascript:void(0);">Week</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" data-period="month" href="javascript:void(0);">Month</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-period="day" href="javascript:void(0);">Day</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="shortGainChart" style="min-height: 465px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-sm-flex flex-wrap justify-content-between align-items-center mb-3">
                            <h4 class="card-title mb-sm-0">Attendant Performance</h4>
                            <div class="mt-sm-0 mt-2">
                                <a href="{{ route('attendant.performance') }}" class="btn btn-primary btn-sm">View Details</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-centered">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 10%">Rank</th>
                                        <th scope="col" style="width: 40%">Attendant</th>
                                        <th scope="col" style="width: 30%">Short/Gain</th>
                                        <th scope="col" style="width: 20%">Share</th>
                                    </tr>
                                </thead>
                                <tbody id="attendantPerformanceTable">
                                    <tr>
                                        <td colspan="4" class="text-center">Loading data...</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="table-light">
                                        <th colspan="2">Total</th>
                                        <th id="totalShortGain">0</th>
                                        <th>100%</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@push('js')
<script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/performance-charts.js') }}"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Get the current year
    var currentYear = new Date().getFullYear();

    // Call filterAndGetData for the current year
    filterAndGetData(currentYear);

    // Generate dropdown items for years from 2023 to 2050
    var dropdownMenu = document.getElementById("yearDropdownMenu");
    for (var year = 2023; year <= 2050; year++) {
        var dropdownItem = document.createElement("a");
        dropdownItem.classList.add("dropdown-item");
        dropdownItem.href = "#";
        dropdownItem.textContent = year;
        dropdownItem.addEventListener("click", function(event) {
            event.preventDefault();
            var selectedYear = parseInt(event.target.textContent);
            // Call a function to handle filtering and getting short/gain for the selected year
            filterAndGetData(selectedYear);
        });
        dropdownMenu.appendChild(dropdownItem);
    }

    // Function to handle filtering and getting short/gain for the selected year
    function filterAndGetData(selectedYear) {
             // Update dropdown toggle text
    document.getElementById("yearDropdown").innerHTML = selectedYear + 
        ' <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>';

        // Hide the dropdown menu
    document.getElementById("yearDropdownMenu").classList.remove("show");
        // Make an AJAX request to the server to fetch short/gain data for the selected year
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Update the UI with the short/gain data for the selected year
                    var data = JSON.parse(xhr.responseText);
                    // Update the UI with the short/gain data
                    var shortGainContainer = document.querySelector("[id='shorting']");
                    shortGainContainer.innerHTML = `<a href="{{ route('attendants.difference', ['year' => '']) }}${selectedYear}">${data.shortGain.toLocaleString()}</a>`;
                } else {
                    // Handle error
                    console.error('Error fetching data');
                }
            }
        };
        xhr.open("GET", "/getShortGainData?year=" + selectedYear, true);
        xhr.send();
    }
});
document.getElementById("yearDropdown").addEventListener("click", function(event) {
    event.preventDefault();
    document.getElementById("yearDropdownMenu").classList.toggle("show");
});

</script>
@endpush