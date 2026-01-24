<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Analytics Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4f46e5;
            color: white;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .stats {
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Analytics Report</h1>
        <p>Generated: {{ now()->format('d M Y, H:i') }}</p>
        <p>User: {{ $user->name }}</p>
    </div>

    <div class="stats">
        <h2>Summary ({{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} -
            {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }})
        </h2>
        <p>Total Revenue: {{ number_format($totalRevenue) }}</p>
        <p>Total Transactions: {{ $transactions->count() }}</p>
        <p>Successful Transactions: {{ $successCount }}</p>
        <p>Average Order: {{ $successCount > 0 ? number_format($totalRevenue / $successCount) : 0 }}</p>
    </div>

    <h2>Transactions</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Order Code</th>
                <th>Product</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $t)
                <tr>
                    <td>{{ $t->created_at->format('d/m/Y') }}</td>
                    <td>{{ $t->order_code }}</td>
                    <td>{{ $t->product->name ?? 'N/A' }}</td>
                    <td>{{ number_format($t->amount) }} {{ $t->currency }}</td>
                    <td>{{ ucfirst($t->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>