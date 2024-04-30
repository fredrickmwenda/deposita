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
                    <h4 class="mb-sm-0 font-size-18">Periodic Cashier Report</h4>
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
                        <div class="row">
                            <div class="col-lg-12">
                                <form method="get" action="{{ route('reports.periodic') }}">
                                    <div class="row mb-4">
                                        <div class="col-lg-3">
                                            <div class="form-group row">
                                                <div class="">
                                                {{ __('Date:') }}
                                                </div>
                                                <div class="col-lg-10">
                                                <input type="date" class="form-control" name="from_date" value="{{ $fromDate }}" >                          
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group row">
                                                <div class="">
                                                {{ __('To Date:') }}
                                                </div>
                                                <div class="col-lg-10">
                                                <input type="date" class="form-control" name="to_date" value="{{ $toDate }}" >                          
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group row">
                                                <div class="">
                                                {{ __('Attendant:') }}
                                                </div>

                                                <div class="col-lg-10">
                                                    <select class="form-control" name="attendant" id="attendant">
                                                        <option value="">Select Attendant</option>
                                                        @foreach($attendants as $attendant)
                                                        <option value="{{$attendant->id}}">{{$attendant->Card_name}} </option>
                                                        @endforeach
                                                    </select>                                               
                                                </div>
                                            </div>
                                        </div>
                                        <!--field to enter the ro name-->
            
                                        <div class="col-lg-3">
                                        <div class="form-group row">
                                            <div class="input-group mt-3">
                                                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i>Filter</button>
                                                <a href="{{ route('reports.periodic') }}" class="btn btn-danger ml-2"><i class="fas fa-sync-alt"></i>Clear</a>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        


                        <div class="table-responsive">
                        <div id="attendantNameDiv" style="display: none;">{{$attendant_jina}}</div>


                          <table class="table align-middle table-nowrap table-check" id="periodic-form"> 
                              <thead class="table-light">
                                  <tr>
                                      <th class="align-middle">ID</th>
                                      <!-- <th class="align-middle"> Attendant Name </th> -->
                                      <th class="align-middle">Date</th>
                                      <th class="align-middle">Shift </th>
                                      <th class="align-middle">Total Drop</th>
                                      <th class="align-middle">Expected</th>
                                      <th class="align-middle">Short/Gain</th>
                                      <th class="align-middle">Recovery</th>
                                      <th class="align-middle">Comment</th>
                                  </tr>
                              </thead>
                              <tbody>
                              @if ($transactions->count() > 0)
                              @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->id }}</td>
                                    <!-- <td>{{ $transaction->attendant->Card_name }}</td> -->
                                    <td>{{ $transaction->date }}</td>
                                    <td>{{ $transaction->shift }}</td>
                                    <td>{{number_format(floatval($transaction->total) + floatval($transaction->coins) + floatval($transaction->cash) + floatval($transaction->recoveries->sum('recovery_amount'))) }}</td>
                                    <!-- <td>{{number_format(floatval($transaction->total) + floatval($transaction->coins()->sum('coin_amount')) + floatval($transaction->recoveries->sum('recovery_amount'))) }}</td> -->
                                    <td>{{ number_format((float)$transaction->expected) }}</td>
                                    <td style="background-color: {{ $transaction->difference < 0 ? 'red' : 'green' }}; color: white;">    
                                        @if ($transaction->difference < 0)
                                            {{ number_format(($transaction->difference)) }}
                                        @elseif ($transaction->difference == 0)
                                            0
                                        @else
                                            @php
                                                $difference = floatval($transaction->difference);
                                            @endphp

                                            @if(is_float($difference))
                                                {{ number_format($difference) }}
                                            @endif
                                            <!-- {{ number_format($transaction->difference) }} -->
                                        @endif
                                    </td>
                                    <td> 
                                        <a href="{{ route('showRecoveries', ['transaction_id' => $transaction->id]) }}" class="fw-bold">{{number_format(floatval($transaction->recoveries->sum('recovery_amount')))}}</a> 
                                        
                                    </td>
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
                                @endforeach
                               

                                @endif


                              </tbody>
                              @if ($transactions->count() > 0)
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <!-- <td></td> -->
                                        <td></td>                                 
                                        <td  class="text-end"><strong>Deposita Total</strong></td>
                                        <td><b>{{number_format($total_drop)}}</b> </td>
                                        <td><b>{{number_format($total_expected)}}</b></td>
                                        <td style="background-color: {{ $total_difference < 0 ? 'red' : 'green' }}; color: white;">                                              
                                                @if ($total_difference < 0)
                                                {{ number_format($total_difference) }}
                                                @elseif ($total_difference == 0)
                                                    0
                                                @else
                                                    {{ number_format($total_difference) }}
                                                @endif
                                        </td>
                                        <td></td>  
                                        <td></td>
                                    </tr>
                                    <tr>
                                    <!-- <td></td> -->
                                    <td></td>
                                    <td></td>   
                                    <td  class="text-end"><strong>Cash Total</strong></td>
                                    <td>{{ number_format($total_cash)}}</td>
                                    <td></td>
                                    <td></td>  
                                    <td></td>
                                    <td></td>
                                    </tr>
                                    <tr>
                                    <td></td>
                                    <td></td>
                                     
                                    <td  class="text-end"><strong>Coin Total</strong></td>
                                    <td>{{ number_format($total_coins)}}</td>
                                    <td></td>
                                    <td></td>  
                                    <td></td>
                                    <td></td>
                                    </tr>
                                    <tr>
                                    <td></td>
                                    <td></td>
                                                                         
                                    <td  class="text-end"><strong>Grand Total</strong></td>
                                    <td><b>{{ number_format($total_coins + $total_drop)}}</b></td>
                                    <td></td>
                                    <td></td>  
                                    <td></td>
                                    <td></td>
                                    </tr>
                                </tfoot>
                            @endif
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
<script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
<script>
$(document).ready(function() {
    var attendantName = document.getElementById('attendantNameDiv').textContent;
    $("#periodic-form").DataTable({
        dom: 'Bfrtip',
        
        buttons: [
             
            {
                extend: "csv",
                title: "Periodic Cashier Report For " + " " + attendantName ,
                customize: function(doc) {
                    // Split the CSV data into lines
                    var lines = doc.split('\n');
                    console.log(lines);

                 

                    // Insert a new row above the header with the attendant's name
                    lines.splice(0, 0, `Periodic Report for ${attendantName}`);

                    // Get the header row to identify column names
                    var headers = lines[0].split(',');
                    var shortGainIndex = headers.indexOf("\"Short/Gain\"");

                    // Get the header row to identify column names
                    var headers = lines[0].split(',');
                    // console.log('headers are', headers);

                    // Find the index of the "Short/Gain" column
                    var shortGainIndex = headers.indexOf("\"Short/Gain\"");
                    

                    // Iterate over the lines starting from the second line (skipping the header)
                    for (var i = 1; i < lines.length; i++) {
                        var line = lines[i];
                        console.log('values are', line);

                        // Use regular expressions to match and capture the seventh value
                        var match = /,"(.*?)"\s*,\s*$/.exec(line);
                        if (match) {
                            var seventhValue = match[1];

                            // Format the seventh value
                            var color = parseInt(seventhValue.replace(/,/g, '')) < 0 ? 'red' : 'green';
                            var formattedSeventhValue = `<span style="background-color:${color};">${seventhValue}</span>`;

                            // Replace the original seventh value with the formatted value
                            line = line.replace(match[1], formattedSeventhValue);
                            lines[i] = line;
                        }

                    }
                    // console.log(lines);

                    // Join the lines back together
                    doc = lines.join('\n');
                    console.log('docis', doc);
                    // Create a Blob containing the CSV content
                    var blob = new Blob([doc], { type: 'text/csv' });

                    // Create a download link for the Blob
                    var url = window.URL.createObjectURL(blob);
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = "Periodic Cashier Report For " + " " +attendantName ;

                    // // Trigger a click event to initiate the download
                    a.click();

                    // // Clean up the URL and DOM elements
                    // window.URL.revokeObjectURL(url);
                }
            },
            {
                extend: "excel",
                
                title: "Periodic Cashier Report For " + " " + attendantName,
                customize: function (xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    var data = sheet.getElementsByTagName('sheetData')[0];
                    
                    // Create a new row for the title
                    var titleRow = document.createElement('row');
                    var cell = document.createElement('c');
                    var v = document.createElement('v');
                    cell.setAttribute('s', '2');  // You may need to adjust the style index (s) as per your Excel styles
                    v.textContent = "Periodic Cashier Report For " + " " + attendantName;
                    cell.appendChild(v);
                    titleRow.appendChild(cell);
                    
                    // Insert the title row at the beginning of the sheet data
                    data.insertBefore(titleRow, data.firstChild);
                    
                    // Adjust the "r" attribute of the original title row
                    var rows = data.getElementsByTagName('row');
                    for (var i = 0; i < rows.length; i++) {
                        var r = rows[i].getAttribute('r');
                        rows[i].setAttribute('r', String(parseInt(r) + 1));
                    }
                }
            },

            {
                extend: "pdf",
                title: "Periodic Cashier Report For " + " " +attendantName,
                customize: function(doc) {
                    var footerRows = $('#periodic-form tfoot tr').clone().toArray();
                    var footerValues = footerRows.map((row, index) => {
                    // Create an array of objects for cell content and style
                        var cells = Array.from(row.children).map((cell, cellIndex) => {
                            var cellText = cell.textContent || '';
                            var style = 'tableBodyOdd';

                            if (index === 0 && cellIndex === 5 && cellText) {
                                var sixthColumnValue = cellText.trim();
                                style = `background-color: ${parseInt(sixthColumnValue.replace(/,/g, '')) < 0 ? 'red' : 'green'}; color: white;`;
                            }

                            return { text: cellText, style: style };
                        });

                        return cells;
                    });


                    var tabl = doc.content[1].table;
                    console.log('doc is', doc);
                        // Update the PDF title with a space between "For" and attendantName
                    var titleText = doc.content[0].text;
                    titleText[0] = "Periodic Cashier Report For " + " " + attendantName;
                    
                    for (var i = 1; i < tabl.body.length; i++) {
                        var row = tabl.body[i];
                        var value = parseInt(row[row.length - 3].text);
                        var color = value < 0 ? 'red' : 'green';
                        row[row.length - 3].fillColor = color;
                        row[row.length - 3].color = 'white';
                    }

                    tabl.body.push.apply(tabl.body, footerValues);
                }
            },
            {
                extend: "print",
                customize: function (win) {
                    var table = $(win.document.body).find('table');
                    var footerRows = table.find('tfoot tr').clone();

                    // Create a new row for the title
                    var titleRow = $("<tr>").append($("<th>").attr('colspan', footerRows.find('td').length).text("Periodic Cashier Report For " + attendantName));

                    // Add the title row to the table
                    table.find('thead').prepend(titleRow);

                    // Add the footer rows after the title row
                    titleRow.after(footerRows);

                    // Add background colors to cells in the last but one column
                    table.find('td:nth-last-child(2)').css('background-color', function (index) {
                        return parseInt($(this).text().replace(/,/g, '')) < 0 ? 'red' : 'green';
                    });
                }
            }

        ],
        //GET 20 ITEMS PER PAGE
        "pageLength": 20,
        responsive: true,
    });
});

  
</script>
@endpush



