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
                            <h4 class="card-title mb-4">Deposita Statistics </h4>
                            <div class="ms-auto">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link " href="javascript:void(0);">Year</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="javascript:void(0);">Week</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="javascript:void(0);">Month</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="javascript:void(0);">Day</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div data-colors="[&quot;--bs-primary&quot;, &quot;--bs-success&quot;, &quot;--bs-warning&quot;, &quot;--bs-info&quot;]" dir="ltr" id="chart" style="min-height: 365px;">

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Best Performing Attendants</h4>

                        <div>
                            @foreach($topThreePerformers as $CardName => $performance)
                            <div class="bg-light p-3 d-flex">
                                <img src="assets/images/users/avatar-2.jpg" alt="" class="avatar-sm rounded me-3">
                                <div class="flex-grow-1">
                                    <!-- Attendant name -->
                                    <h5 class="font-size-15 mb-2"><a href="#" class="text-body">{{ $CardName }}</a></h5>
                                    <!-- Performance -->
                                    <p class="mb-0 text-muted"><i class="bx bx-bulb text-body align-middle"></i> Performance: {{ $performance }}%</p>
                                </div>
                            </div>
                            @endforeach



                            <a href="{{ route('attendant.performance') }}" class="mt-2">View All </a>

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
<script>
    // Your ApexCharts initialization and data rendering code goes here
    // Example:
    var chartData = {
        !!json_encode($graphData) !!
    };

    // Initialize ApexCharts
    var options = {
        chart: {
            type: 'line',
            height: 350,
        },
        series: [{
                name: 'Cashier Rates',
                data: Object.values(chartData.transactionData.month), // Use Object.values to get an array of values
            },
            {
                name: 'Recovery Rate',
                data: Object.values(chartData.recoveryData.month), // Use Object.values to get an array of values
            },
        ],
        xaxis: {
            type: 'category',
            categories: Object.keys(chartData.transactionData.month),
        },
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>


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


// Manually toggle dropdown when "Select Year" button is clicked
document.getElementById("yearDropdown").addEventListener("click", function(event) {
    event.preventDefault();
    document.getElementById("yearDropdownMenu").classList.toggle("show");
});

</script>

@endpush