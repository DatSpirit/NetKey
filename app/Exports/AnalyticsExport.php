<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AnalyticsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return [
            'Date',
            'Order Code',
            'Product',
            'Amount',
            'Currency',
            'Status',
            'Customer Email',
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->created_at->format('Y-m-d H:i:s'),
            $transaction->order_code,
            $transaction->product->name ?? 'N/A',
            $transaction->amount,
            $transaction->currency,
            $transaction->status,
            $transaction->assigned_to_email,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}