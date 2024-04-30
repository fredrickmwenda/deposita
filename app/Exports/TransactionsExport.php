<?php
namespace App\Exports;
use App\Models\transaction;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromCollection, WithHeadings
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        // return $this->transactions;
        return $this->transactions->map(function($transaction) {
            return [
                $transaction->date,
                $transaction->attendant_name,
                number_format(floatval($transaction->total) + floatval($transaction->coins) + floatval($transaction->recovery), 2),
                number_format(floatval($transaction->expected), 2),
                number_format(floatval($transaction->difference), 2)
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Date',
            'Attendant',
            'Total',
            'Expected',
            'Short/Gain',
            // add more headers if needed
        ];
    }
}