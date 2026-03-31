<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ str_pad($data->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.6;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background: #fff;
        }
        .invoice-header {
            display: table;
            width: 100%;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #3498db;
        }
        .invoice-header-left {
            display: table-cell;
            width: 50%;
            vertical-align: middle;
        }
        .invoice-header-right {
            display: table-cell;
            width: 50%;
            text-align: right;
            vertical-align: middle;
        }
        .invoice-logo {
            max-height: 60px;
            margin-bottom: 10px;
        }
        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .invoice-info {
            font-size: 11px;
            color: #666;
        }
        .invoice-info strong {
            color: #333;
        }
        .billing-section {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .billing-left, .billing-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding: 15px;
        }
        .billing-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #3498db;
        }
        .billing-label {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 13px;
            text-transform: uppercase;
        }
        .billing-details {
            color: #555;
            line-height: 1.8;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table thead {
            background-color: #3498db;
            color: #fff;
        }
        table thead th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }
        table tbody td {
            padding: 10px 12px;
            border-bottom: 1px solid #e0e0e0;
        }
        table tbody tr:last-child td {
            border-bottom: none;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .summary-table {
            width: 300px;
            margin-left: auto;
            margin-top: 20px;
        }
        .summary-table td {
            padding: 8px;
            border-bottom: 1px solid #e0e0e0;
        }
        .summary-table td:first-child {
            text-align: left;
            font-weight: bold;
        }
        .summary-table td:last-child {
            text-align: right;
        }
        .summary-table tr:last-child {
            background-color: #f8f9fa;
            font-weight: bold;
            font-size: 14px;
        }
        .summary-table tr:last-child td {
            border-top: 2px solid #3498db;
            border-bottom: 2px solid #3498db;
        }
        .ticket-details-table {
            margin-top: 30px;
        }
        .ticket-details-table thead {
            background-color: #2c3e50;
        }
        .footer-info {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
        }
        .footer-info p {
            margin-bottom: 8px;
            color: #666;
        }
        .footer-info strong {
            color: #333;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            background-color: #3498db;
            color: #fff;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Invoice Header -->
        <div class="invoice-header">
            <div class="invoice-header-left">
                @if($settings && $settings->company_name)
                    <div style="font-size: 18px; font-weight: bold; color: #2c3e50; margin-bottom: 10px;">{{ $settings->company_name }}</div>
                @endif
                @if($settings && $settings->company_logo && file_exists(public_path('storage/uploads/images/' . $settings->company_logo)))
                    <img src="{{ public_path('storage/uploads/images/' . $settings->company_logo) }}" alt="Logo" class="invoice-logo">
                @endif
            </div>
            <div class="invoice-header-right">
                <div class="invoice-title">INVOICE</div>
                <div class="invoice-info">
                    <strong>Order ID:</strong> #{{ str_pad($data->id, 6, '0', STR_PAD_LEFT) }}<br>
                    <strong>Issue Date:</strong> {{ $data->payment_date ? date('d M Y', strtotime($data->payment_date)) : date('d M Y') }}
                </div>
            </div>
        </div>

        <!-- Billing Information -->
        <div class="billing-section">
            <div class="billing-left">
                <div class="billing-box">
                    <div class="billing-label">Invoice To</div>
                    <div class="billing-details">
                        {{ $data->shipping_name ?? 'N/A' }}<br>
                        @if($data->shipping_address1){{ $data->shipping_address1 }}<br>@endif
                        @if($data->shipping_address2){{ $data->shipping_address2 }}<br>@endif
                        @if($data->shipping_city){{ $data->shipping_city }}{{ $data->shipping_pincode ? ', ' . $data->shipping_pincode : '' }}<br>@endif
                        @if($data->country_name){{ $data->country_name }}@endif
                    </div>
                </div>
            </div>
            <div class="billing-right">
                <div class="billing-box">
                    <div class="billing-label">Payment Method</div>
                    <div class="billing-details">
                        Credit / Debit Card<br>
                        @if($data->payment_card_number)
                        XXXX-XXXX-XXXX-{{ substr($data->payment_card_number, -4) }}
                        @else
                        N/A
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <table>
            <thead>
                <tr>
                    <th>Event</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>{{ $data->event_name }}</strong></td>
                    <td class="text-center">{{ $count }}</td>
                    <td class="text-right">{{ number_format(@$ticket->ticket_amount, 2) . ' ' . @$data->currency_name }}</td>
                    <td class="text-right"><strong>{{ number_format($data->payment_amount, 2) . ' ' . $data->currency_name }}</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Summary Table -->
        <table class="summary-table">
            <tbody>
                <tr>
                    <td>Subtotal:</td>
                    <td>{{ number_format($data->payment_amount, 2) . ' ' . $data->currency_name }}</td>
                </tr>
                <tr>
                    <td>Total Amount:</td>
                    <td><strong>{{ number_format($data->payment_amount, 2) . ' ' . $data->currency_name }}</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Ticket Details -->
        <div style="margin-top: 40px;">
            <h3 style="color: #2c3e50; margin-bottom: 15px; font-size: 16px; border-bottom: 2px solid #3498db; padding-bottom: 8px;">Ticket Details</h3>
            <table class="ticket-details-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ticket Serial</th>
                        <th>Seat Number</th>
                        <th>Event Date</th>
                        <th>Event Timing</th>
                        <th>Seating Type</th>
                        <th>Seat Row</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_list as $list)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $list->ticket_serial_number ?? 'N/A' }}</strong></td>
                        <td>{{ $list->seat_number_prefix ?? 'N/A' }}</td>
                        <td>{{ $list->event_date ? date('d M Y', strtotime($list->event_date)) : 'N/A' }}</td>
                        <td>
                            @if($list->from_time && $list->to_time)
                                {{ date('h:i A', strtotime($list->from_time)) }} - {{ date('h:i A', strtotime($list->to_time)) }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $list->seating_type_name ?? 'N/A' }}</td>
                        <td>{{ $list->seat_row ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer Information -->
        <div class="footer-info">
            <p><strong>Payment ID:</strong> {{ $data->payment_id ?? 'N/A' }}</p>
            <p><strong>Order ID:</strong> #{{ str_pad($data->id, 6, '0', STR_PAD_LEFT) }}</p>
            <p><strong>Booking Status:</strong> {{ $data->status_name }}</p>
            <p style="margin-top: 20px; text-align: center; color: #999; font-size: 10px;">
                Thank you for your purchase!
            </p>
        </div>
    </div>
</body>
</html>
