@extends('layouts.app')
@push('css')

<style>
.dropdown {
  position: relative;
}

.dropdown-content {
  position: absolute;
  left: 0;
  top: 100%;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  display: none;
}

.dropdown:hover .dropdown-content {
  display: block;
}

/* Add these new styles */
.table th {
    font-size: 10px !important;
}

.table tr td {
    font-size: 10px !important;
}
</style>
<!-- <link href="{{ asset('assets/libs/datatables.net/css/jquery.dataTables.min.css') }}" rel="stylesheet"> -->
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">


@endpush
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Cashier Report</h4>
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
                                <form method="get" action="{{ route('reports.transactions') }}">
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
                                            {{ __('Shift:') }}
                                            </div>

                                            <div class="col-lg-10">
                                                <select class="form-control"  name="shift">
                                                    <option > Select Shift</option>
                                                    <option value="day" {{ $shift == 'day' ? 'selected' : '' }}>Day</option>
                                                    <option value="night" {{ $shift == 'night' ? 'selected' : '' }}>Night</option>
                                                </select>
                                            
                                            </div>
                                        </div>
                                        </div>
                                        <!--field to enter the ro name-->
            
                                        <div class="col-lg-3">
                                        <div class="form-group row">
                                            <div class="input-group mt-3">
                                                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i>Filter</button>
                                                <a href="{{ route('reports.transactions') }}" class="btn btn-danger ml-2"><i class="fas fa-sync-alt"></i>Clear</a>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        


                        <div class="table-responsive">
   


                        <table class="table align-middle table-nowrap table-check" id="transact-form"> 
                            <thead class="table-light">
                                <tr>
                                
                                <th class="align-middle">Date</th>
                                <th class="align-middle">Attendant </th>
                                <th class="align-middle">Total Drop</th>
                                <th class="align-middle">Cash</th>
                                <th class="align-middle">Coins</th>
                                <th class="align-middle">Recovery</th>
                                <th class="align-middle">Expected</th>
                                <th class="align-middle">Short/Gain</th>
                                <th class="align-middle">Comment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                <tr>
                                    
                                    <td>{{ $transaction->date }}</td>
                                    <td>{{ $transaction->attendant->Card_name }}</td>
                                    <td>{{number_format(floatval($transaction->total) + floatval($transaction->coins) + floatval($transaction->cash) + floatval($transaction->recoveries->sum('recovery_amount'))) }}</td>
                                    <td>{{number_format(floatval($transaction->cash) ) }}</td>
                                    <td>{{number_format( floatval($transaction->coins) ) }}</td>
                                    <td>{{number_format( floatval($transaction->recoveries->sum('recovery_amount')) ) }}</td>
                                    <!-- <td>{{number_format(floatval($transaction->total) + floatval($transaction->coins()->sum('coin_amount')) + floatval($transaction->recoveries->sum('recovery_amount'))) }}</td> -->
                                    <td>{{ number_format((float)$transaction->expected) }}</td>
                                    <td style="background-color: {{ $transaction->difference < 0 ? 'red' : 'green' }}; color: white;">    
                                        @php
                                            $difference = floatval($transaction->difference);
                                        @endphp

                                        @if ($difference < 0)
                                            {{ number_format($difference) }}
                                        @elseif ($difference == 0)
                                            0
                                        @else
                                            {{ number_format($difference) }}
                                        @endif
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
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>                              
                                    <td  class="text-end"><strong>Deposita Total</strong></td>
                                    <td><b>{{number_format($total_drop)}}</b> </td>
                                    <td><b>{{number_format($total_expected)}}</b></td>
                                    <td></td> 
                                    <td></td>
                                    <td style="background-color: {{ $total_difference < 0 ? 'red' : 'green' }}; color: white;">    
                                        <b>
                                            @if ($total_difference < 0)
                                            {{ number_format($total_difference) }}
                                            @elseif ($total_difference == 0)
                                                0
                                            @else
                                                {{ number_format($total_difference) }}
                                            @endif
                                        </b>
                                    </td>
                                    <!-- <td><b>({{number_format($total_difference)}})</b></td> -->
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="text-end"><strong>Cash Total</strong></td>
                                    <td>{{ number_format($total_cash)}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="text-end"><strong>Coin Total</strong></td>
                                    <td>{{ number_format($total_coins)}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                    <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="text-end"><strong>Recovery Total</strong></td>
                                    <td>{{ number_format($total_recovery)}}</td>
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
                                </tr>
                            </tfoot>
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
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#transact-form").DataTable({
            dom: 'Bfrtip',
            buttons: [ 
                {
                    extend: 'csv',
                    title: 'Cashier Report',
                    customize: function(csv) {
                        var footerData = [];
                        var footerRows = $('#transact-form tfoot tr');
                        footerRows.each(function() {
                        var rowData = [];
                        $(this).find('td').each(function() {
                            rowData.push($(this).text().trim().replace(/\s+/g, ' '));
                        });
                        footerData.push(rowData);
                        });

                        var uniqueFooterData = Array.from(new Set(footerData.map(JSON.stringify)), JSON.parse);

                        // Custom footer rows
                        var customFooterRows = [
                        ['', '', 'Deposita Total', '{{number_format($total_drop)}}', '{{number_format($total_expected)}}', '( {{number_format($total_difference)}} )', ''],
                        ['', '', 'Cash Total', '{{ number_format($total_cash)}}', '', '', ''],
                        ['', '', 'Coin Total', '{{ number_format($total_coins)}}', '', '', ''],
                        ['', '', 'Grand Total', '{{ number_format($total_coins + $total_drop)}}', '', '', '']
                        ];
                        customFooterRows.forEach(function(rowData) {
                        if (!uniqueFooterData.some(existingRow => existingRow.join() === rowData.join())) {
                            uniqueFooterData.push(rowData);
                        }
                        });

                        // Remove the last row if it contains 'Deposita Total'
                        var lastRow = uniqueFooterData[uniqueFooterData.length - 1];
                        if (lastRow && lastRow[2] === 'Deposita Total') {
                        uniqueFooterData.pop();
                        }
                        console.log(uniqueFooterData);
                        // // Append the footerCSV string to the end of the main CSV string
                        var footerCSV = uniqueFooterData.map(row => {
                            return row.map(cell => {
                                if (/[\d,]+/.test(cell)) {
                                // If the cell contains commas, wrap it in double quotes
                                return '"' + cell + '"';
                                } else {
                                return cell;
                                }
                            }).join(',');
                            }).join('\n');
                        // // Append footerCSV to the main CSV string
                        csv += '\n' + footerCSV;
                        // // Return the modified CSV string
                        return csv;


                    }
                },
                {
                    extend: "excel",
                    title: "Cashier Report",
                },
                
                
                {
                    extend: "pdf",
                    title: "Cashier Report",
                    customize: function(doc) {
                        var footerRows = $('#transact-form tfoot tr').clone().toArray();
                        var footerValues = footerRows.map((row, index) => {
                            return [    { text: row.children[0].textContent || '', style: index === 0 ? 'tableBodyEven' : 'tableBodyOdd' },
                                { text: row.children[1].textContent || '', style: 'tableBodyEven' },
                                { text: row.children[2].textContent || '', style: 'tableBodyEven' },
                                { text: row.children[3].textContent || '', style: 'tableBodyEven' },
                                { text: row.children[4].textContent || '', style: 'tableBodyEven' },
                                { text: row.children[5].textContent || '', style: 'tableBodyEven' },
                                { text: row.children[6].textContent || '', style: 'tableBodyEven' }
                            ];
                        });
                        var tabl = doc.content[1].table;
                        
                        for (var i = 1; i < tabl.body.length; i++) {
                            var row = tabl.body[i];
                            var value = parseInt(row[row.length - 2].text);
                            var color = value < 0 ? 'red' : 'green';
                            row[row.length - 2].fillColor = color;
                            row[row.length - 2].color = 'white';
                        }

                        tabl.body.push.apply(tabl.body, footerValues);
                        
                    }
                    
                },
                {
                    extend: "print",
                    title: "Cashier Report",
                    customize: function(win) {
                        // Append footer rows to table
                        var footerRows = $('#transact-form tfoot tr').clone();
                        $(win.document.body).find('table').append(footerRows);
                        $(win.document.body).find('table td:nth-last-child(2)').css('background-color', function(index) {
                            return parseInt($(this).text().replace(/,/g, '')) < 0 ? 'red' : 'green';
                        });
                        
                    }           
                },
            ],
            //GET 20 ITEMS PER PAGE
            "pageLength": 20,
            responsive: true,               
        });
    });     
</script>


@endpush



