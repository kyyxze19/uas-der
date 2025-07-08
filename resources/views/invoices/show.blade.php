@extends('master')

@section('judul')
  Detail Invoice
@endsection

@section('subjudul')
  {{ $invoice->invoice_number }}
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pb-0">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-bold mb-0">Detail Invoice</h5>
            <div class="d-flex gap-2">
              <a href="{{ route('invoices.download-pdf', $invoice) }}" class="btn btn-outline-primary">
                <i class="ti ti-download me-2"></i>Download PDF
              </a>
              <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-primary">
                <i class="ti ti-edit me-2"></i>Edit
              </a>
              <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-2"></i>Kembali
              </a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <!-- Invoice Header -->
          <div class="row mb-5">
            <div class="col-md-6">
              <div class="mb-4">
                <h4 class="fw-bold text-primary">PT Prima Rama Jaya</h4>
                <p class="text-muted mb-0">
                  Jl. Contoh No. 123<br>
                  Jakarta Pusat, 10110<br>
                  Phone: (021) 1234-5678<br>
                  Email: info@primaramajaya.com
                </p>
              </div>
            </div>
            <div class="col-md-6 text-end">
              <div class="mb-4">
                <h3 class="fw-bold">INVOICE</h3>
                <p class="mb-1"><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
                <p class="mb-1"><strong>Tanggal:</strong> {{ $invoice->formatted_invoice_date }}</p>
                <p class="mb-1"><strong>Jatuh Tempo:</strong> {{ $invoice->formatted_due_date }}</p>
                <span class="badge {{ $invoice->status_badge }} fs-6">{{ ucfirst($invoice->status) }}</span>
              </div>
            </div>
          </div>

          <!-- Client Info -->
          <div class="row mb-5">
            <div class="col-md-6">
              <div class="card bg-light">
                <div class="card-body">
                  <h6 class="fw-semibold mb-3">Tagihan Kepada:</h6>
                  <p class="mb-1"><strong>{{ $invoice->client_name }}</strong></p>
                  <p class="mb-1">{{ $invoice->client_email }}</p>
                  <p class="mb-0">{!! nl2br(e($invoice->client_address)) !!}</p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card bg-light">
                <div class="card-body">
                  <h6 class="fw-semibold mb-3">Detail Proyek:</h6>
                  <p class="mb-1"><strong>{{ $invoice->proyek->nama_proyek ?? 'N/A' }}</strong></p>
                  <p class="mb-1">{{ $invoice->proyek->deskripsi ?? 'N/A' }}</p>
                  <p class="mb-0">
                    <span class="badge bg-info">{{ ucfirst($invoice->proyek->status ?? 'N/A') }}</span>
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Invoice Items -->
          <div class="mb-5">
            <h6 class="fw-semibold mb-3">Detail Item:</h6>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead class="table-dark">
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
                      <td>{{ $item->quantity }}</td>
                      <td>Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                      <td>Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>

          <!-- Summary -->
          <div class="row">
            <div class="col-md-6 offset-md-6">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <span>Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</span>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span>Pajak ({{ $invoice->tax_rate }}%):</span>
                    <span>Rp {{ number_format($invoice->tax_amount, 0, ',', '.') }}</span>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span>Diskon:</span>
                    <span>Rp {{ number_format($invoice->discount_amount, 0, ',', '.') }}</span>
                  </div>
                  <hr>
                  <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total:</span>
                    <span class="text-primary">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Notes -->
          @if($invoice->notes)
            <div class="mt-4">
              <h6 class="fw-semibold mb-3">Catatan:</h6>
              <div class="alert alert-info">
                {{ $invoice->notes }}
              </div>
            </div>
          @endif

          <!-- Status Update -->
          <div class="mt-5">
            <h6 class="fw-semibold mb-3">Update Status:</h6>
            <form action="{{ route('invoices.update-status', $invoice) }}" method="POST" class="d-inline">
              @csrf
              @method('PATCH')
              <div class="row align-items-end">
                <div class="col-md-3">
                  <select name="status" class="form-select" required>
                    <option value="draft" {{ $invoice->status == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="sent" {{ $invoice->status == 'sent' ? 'selected' : '' }}>Sent</option>
                    <option value="paid" {{ $invoice->status == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="overdue" {{ $invoice->status == 'overdue' ? 'selected' : '' }}>Overdue</option>
                    <option value="cancelled" {{ $invoice->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
              </div>
            </form>
          </div>

          <!-- Payment Info -->
          @if($invoice->status == 'paid' && $invoice->paid_at)
            <div class="mt-4">
              <div class="alert alert-success">
                <i class="ti ti-check-circle me-2"></i>
                <strong>Invoice telah dibayar pada:</strong> {{ $invoice->paid_at->format('d F Y H:i') }}
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
