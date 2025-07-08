<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            border-bottom: 2px solid #3498db;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .company-info {
            width: 50%;
            float: left;
        }
        .invoice-info {
            width: 50%;
            float: right;
            text-align: right;
        }
        .invoice-title {
            font-size: 2em;
            font-weight: bold;
            color: #3498db;
            margin-bottom: 10px;
        }
        .clear {
            clear: both;
        }
        .client-info {
            background-color: #f8f9fa;
            padding: 15px;
            margin: 20px 0;
            border-left: 4px solid #3498db;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .items-table th,
        .items-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .items-table th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
        }
        .items-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .text-right {
            text-align: right;
        }
        .total-section {
            width: 300px;
            float: right;
            margin-top: 20px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
        .total-final {
            font-weight: bold;
            font-size: 1.2em;
            color: #3498db;
            border-top: 2px solid #3498db;
            padding-top: 10px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            color: white;
            font-size: 0.8em;
            font-weight: bold;
        }
        .status-paid { background-color: #27ae60; }
        .status-sent { background-color: #3498db; }
        .status-draft { background-color: #95a5a6; }
        .status-overdue { background-color: #e74c3c; }
        .status-cancelled { background-color: #34495e; }
        .notes {
            background-color: #e8f4f8;
            padding: 15px;
            margin: 20px 0;
            border-left: 4px solid #3498db;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 0.9em;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="company-info">
            <h1>PT Prima Rama Jaya</h1>
            <p>
                Jl. Contoh No. 123<br>
                Jakarta Pusat, 10110<br>
                Phone: (021) 1234-5678<br>
                Email: info@primaramajaya.com
            </p>
        </div>
        <div class="invoice-info">
            <div class="invoice-title">INVOICE</div>
            <p>
                <strong>Invoice Number:</strong> {{ $invoice->invoice_number }}<br>
                <strong>Tanggal:</strong> {{ $invoice->formatted_invoice_date }}<br>
                <strong>Jatuh Tempo:</strong> {{ $invoice->formatted_due_date }}<br>
                <span class="status-badge status-{{ $invoice->status }}">{{ strtoupper($invoice->status) }}</span>
            </p>
        </div>
        <div class="clear"></div>
    </div>

    <!-- Client Information -->
    <div class="client-info">
        <h3>Tagihan Kepada:</h3>
        <p>
            <strong>{{ $invoice->client_name }}</strong><br>
            {{ $invoice->client_email }}<br>
            {!! nl2br(e($invoice->client_address)) !!}
        </p>
    </div>

    <!-- Project Information -->
    <div class="client-info">
        <h3>Detail Proyek:</h3>
        <p>
            <strong>{{ $invoice->proyek->nama_proyek ?? 'N/A' }}</strong><br>
            {{ $invoice->proyek->deskripsi ?? 'N/A' }}<br>
            Status: {{ ucfirst($invoice->proyek->status ?? 'N/A') }}
        </p>
    </div>

    <!-- Items Table -->
    <table class="items-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="45%">Deskripsi</th>
                <th width="15%">Qty</th>
                <th width="20%">Harga Unit</th>
                <th width="15%">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->description }}</td>
                <td class="text-right">{{ $item->quantity }}</td>
                <td class="text-right">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Total Section -->
    <div class="total-section">
        <div class="total-row">
            <span>Subtotal:</span>
            <span>Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</span>
        </div>
        <div class="total-row">
            <span>Pajak ({{ $invoice->tax_rate }}%):</span>
            <span>Rp {{ number_format($invoice->tax_amount, 0, ',', '.') }}</span>
        </div>
        <div class="total-row">
            <span>Diskon:</span>
            <span>Rp {{ number_format($invoice->discount_amount, 0, ',', '.') }}</span>
        </div>
        <div class="total-row total-final">
            <span>Total:</span>
            <span>Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="clear"></div>

    <!-- Notes -->
    @if($invoice->notes)
    <div class="notes">
        <h4>Catatan:</h4>
        <p>{{ $invoice->notes }}</p>
    </div>
    @endif

    <!-- Payment Status -->
    @if($invoice->status == 'paid' && $invoice->paid_at)
    <div class="notes">
        <h4>Status Pembayaran:</h4>
        <p><strong>Invoice telah dibayar pada:</strong> {{ $invoice->paid_at->format('d F Y H:i') }}</p>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Terima kasih atas kepercayaan Anda kepada PT Prima Rama Jaya</p>
        <p>Dokumen ini dibuat secara otomatis pada {{ now()->format('d F Y H:i') }}</p>
    </div>
</body>
</html>
