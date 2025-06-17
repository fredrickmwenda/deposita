<?php

namespace App\Http\Controllers;

use App\Models\transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;
use App\Helpers\DatesValidator;
use App\Models\Attendant;
use App\Models\Coin;
use App\Models\Recovery;
use Barryvdh\DomPDF\Facade\Pdf;

class ShiftsReportController extends Controller
{
    public function ShiftsReport(Request $request)
    {
        //dd($request->all());
        $fromDate = $request->input('from_date') ?? '';
        $shift = $request->input('shift') ?? '';

        if (!empty($fromDate)) {
            
            if (!empty($shift) && $shift !== 'Select Shift') {
                //include recovery here too
                $transactions = transaction::select('*')->when($request->from_date, function ($query) use ($request) {
                    return $query->whereDate('date', $request->from_date);
                })->when(isset($request->shift) && $request->shift !== 'Select Shift', function ($query) use ($request) {
                    return $query->where('shift', $request->shift);
                })->orderBy('id', 'desc');
                $transactionsi = transaction::with(['recoveries', 'attendant'])->select('*')->when($request->from_date, function ($query) use ($request) {
                    return $query->whereDate('date', $request->from_date);
                })->when(isset($request->shift) && $request->shift !== 'Select Shift', function ($query) use ($request) {
                    return $query->where('shift', $request->shift);
                })->withSum('recoveries', 'recovery_amount')->orderBy('id', 'desc');
                $total_coins = $transactions->sum('coins');
                $total_cash = $transactions->sum('cash');
                $total_drop = $transactions->sum('total');
                $total_expected = $transactions->sum('expected');
                $total_difference = $transactions->sum('difference');
                $total_recovery = $transactionsi->withSum('recoveries', 'recovery_amount')->value('recoveries_sum_recovery_amount');
                //dd($total_recovery);
                $total_drop = $transactions->sum('total') + $total_recovery;
                $transactions = $transactions->get();
            } else {
                $transactions = transaction::select('*')->when($request->from_date, function ($query) use ($request) {
                    return $query->whereDate('date', $request->from_date);
                })->orderBy('id', 'desc');
                $transactionsi = transaction::with(['recoveries', 'attendant'])->select('*')->when($request->from_date, function ($query) use ($request) {
                    return $query->whereDate('date', $request->from_date);
                })->withSum('recoveries', 'recovery_amount')->orderBy('id', 'desc');
               

                $total_coins = $transactions->sum('coins');
                $total_cash = $transactions->sum('cash');
                $total_expected = $transactions->sum('expected');
                $total_difference = $transactions->sum('difference');
                $total_recovery = $transactionsi->withSum('recoveries', 'recovery_amount')->value('recoveries_sum_recovery_amount');
                $total_drop = $transactions->sum('total') + $total_recovery;
                $transactions = $transactions->get();
            }
        } else if (empty($fromDate) && !empty($shift) && $shift !== 'Select Shift') {
            $transactions = transaction::select('*')->when(isset($request->shift) && $request->shift !== 'Select Shift', function ($query) use ($request) {
                return $query->where('shift', $request->shift);
            })->orderBy('id', 'desc');
            $transactionsi = transaction::with(['recoveries', 'attendant'])->select('*')->when(isset($request->shift) && $request->shift !== 'Select Shift', function ($query) use ($request) {
                return $query->where('shift', $request->shift);
            })->withSum('recoveries', 'recovery_amount')->orderBy('id', 'desc');
            $total_coins = $transactions->sum('coins');
            $total_cash = $transactions->sum('cash');
            $total_drop = $transactions->sum('total');
            $total_expected = $transactions->sum('expected');
            $total_difference = $transactions->sum('difference');
            $total_recovery = $transactionsi->withSum('recoveries', 'recovery_amount')->value('recoveries_sum_recovery_amount');
            $total_drop = $transactions->sum('total') + $total_recovery;
            $transactions = $transactions->get();
        } else {
            $transactionsi = transaction::get();
            $total_coins = $transactionsi->sum('coins');
           $total_cash = $transactionsi->sum(function($transaction) {
               return is_numeric($transaction->cash) ? $transaction->cash : 0;
            });      
            $total_expected = $transactionsi->sum('expected');
            // $total_difference = $transactionsi->sum(function ($transaction) {
            //     return intval($transaction->difference);
            // });
            $total_difference = $transactionsi->sum(function ($transaction) {
                return floatval($transaction->difference);
            });            
            $recovery = Recovery::sum('recovery_amount');
            $total_recovery = $transactionsi->sum('recovery') + $recovery;
            $total_drop = $transactionsi->sum('total') + $total_recovery;
            $transactions = transaction::orderBy('created_at', 'desc')->take(50)->orderBy('id', 'desc')->get();
            
        }
        return view('report.shifts', compact('transactions', 'total_coins', 'total_drop', 'total_expected', 'total_recovery', 'total_difference', 'fromDate', 'shift', 'total_cash'));
    }

 
    public function ShiftsReportTwo(Request $request)
    {
        $attendants = Attendant::orderBy('Card_name', 'asc')->get();
        $fromDate = $request->input('from_date') ?? '';
        $toDate = $request->input('to_date') ?? '';
        $attendant = $request->input('attendant') ?? '';

        $attendant_name = Attendant::where('id', $attendant)->first();
        $attendant_jina = $attendant_name ? $attendant_name->Card_name : null;

        // Initial totals
        $total_drop = transaction::select('total')->sum('total');
        $total_expected = transaction::select('expected')->sum('expected');
        $total_difference = transaction::select('difference')->sum('difference');
        $total_coins = transaction::select('coins')->sum('coins');
        $total_cash = transaction::select('cash')->sum('cash');
        $recovery = Recovery::sum('recovery_amount');
        $total_recovery = 0;

        if (!empty($fromDate)) {
            $res = DatesValidator::validate($fromDate, $toDate);
            if ($res != 'success') {
                return redirect()->back()->with('error', $res);
            }
            if (empty($attendant)) {
                return redirect()->back()->with('error', 'Please set the Attendant');
            }

            $transactions = transaction::select('*')
                ->when($request->from_date, function ($query) use ($request) {
                    return $query->whereBetween('Date', [$request->from_date, $request->to_date]);
                })
                ->when($request->attendant, function ($query) use ($request) {
                    return $query->where('attendant_id', $request->attendant);
                })
                ->orderBy('id', 'desc')
                ->get();

            $cashier_data = transaction::with(['recoveries', 'attendant'])
                ->select('*')
                ->when($request->from_date, function ($query) use ($request) {
                    return $query->whereBetween('Date', [$request->from_date, $request->to_date]);
                })
                ->when($request->attendant, function ($query) use ($request) {
                    return $query->where('attendant_id', $request->attendant);
                })
                ->withSum('recoveries', 'recovery_amount');
                
            $total_coins = $cashier_data->sum('coins');
            $total_cash = $cashier_data->sum('cash');         
            $total_expected = $cashier_data->sum('expected');
            $total_difference = $cashier_data->sum('difference');
            $total_recovery = $cashier_data->withSum('recoveries', 'recovery_amount')->value('recoveries_sum_recovery_amount');
            $total_drop = $cashier_data->sum('total') + $total_recovery;

        } else if (empty($fromDate) && !empty($attendant)) {
            $transactions = transaction::select('*')
                ->when($request->attendant, function ($query) use ($request) {
                    return $query->where('attendant_id', $request->attendant);
                })
                ->orderBy('id', 'desc')
                ->get();

            $cashier_data = transaction::with(['recoveries', 'attendant'])
                ->select('*')
                ->when($request->attendant, function ($query) use ($request) {
                    return $query->where('attendant_id', $request->attendant);
                })
                ->withSum('recoveries', 'recovery_amount');

            $total_coins = $cashier_data->sum('coins');
            $total_cash = $cashier_data->sum('cash');
            $total_drop = $cashier_data->sum('total');
            $total_expected = $cashier_data->sum('expected');
            $total_difference = $cashier_data->sum('difference');
            $total_recovery = $cashier_data->withSum('recoveries', 'recovery_amount')->value('recoveries_sum_recovery_amount');
            $total_drop = $cashier_data->sum('total') + $total_recovery;
        } else {
            $transactions = collect();
        }

        return view('report.periodic', compact(
            'transactions', 
            'total_drop', 
            'total_expected', 
            'total_difference', 
            'fromDate', 
            'attendants', 
            'toDate', 
            'total_coins', 
            'total_cash', 
            'attendant_jina',
            'total_recovery',
            'recovery'
        ));
    }


    



    public function export(Request $request, $format)
    {
        $transactions = DB::table('cashier_record')
            ->select(
                'cashier_record.date',
                'attendants.Card_name as attendant_name',
                'cashier_record.coins',
                'cashier_record.cash',
                'cashier_record.expected',
                'cashier_record.difference',
                'cashier_record.total',
                'cashier_record.recovery'
            )
            ->join('attendants', 'cashier_record.attendant_id', '=', 'attendants.id')
            ->when($request->from_date, function ($query) use ($request) {
                return  $query->whereDate('cashier_record.date', $request->from_date);
            })->when(isset($request->shift) && $request->shift !== 'Select Shift', function ($query) use ($request) {
                return $query->where('cashier_record.shift', $request->shift);
            })
            ->orderBy('cashier_record.id', 'desc')
            ->get();
        $total_coins = transaction::select('coins')->when($request->from_date,  function ($query) use ($request) {
            return  $query->whereDate('date', $request->from_date);
        })->when(isset($request->shift) && $request->shift !== 'Select Shift', function ($query) use ($request) {
            return $query->where('shift', $request->shift);
        })->sum('coins');

        switch ($format) {
            case 'csv':
                $headers = array(
                    "Content-type" => "text/csv",
                    "Content-Disposition" => "attachment; filename=cashier_record.csv",
                    "Pragma" => "no-cache",
                    "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                    "Expires" => "0"
                );

                $headers = array('Date', 'Attendant', 'Total Drop', 'Expected', 'Short/Gain');
                $callback = function () use ($transactions) {
                    $file = fopen('php://output', 'w');
                    fputcsv($file, ['Date', 'Attendant', 'Total Drop', 'Expected', 'Short/Gain']);

                    foreach ($transactions as $transaction) {
                        $totalDrop = number_format(floatval($transaction->total) + floatval($transaction->coins) + floatval($transaction->recovery), 2);
                        fputcsv($file, [
                            $transaction->date,
                            $transaction->attendant_name,
                            $totalDrop,
                            $transaction->expected,
                            $transaction->difference,
                        ]);
                    }

                    fclose($file);
                };

                return response()->stream($callback, 200, $headers);
                break;
            case 'xls':
                return Excel::download(new TransactionsExport($transactions), 'cashier_record.xls');
                break;
            case 'pdf':
                $pdf = PDF::loadView('report.shifts-pdf', compact('transactions'));
                return $pdf->download('cashier_record.pdf');
                break;
            case 'print':
                return view('report.shifts-print', compact('transactions'));
                break;
            default:
                abort(400, 'Invalid file format.');
                break;
        }
    }
}
