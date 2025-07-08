@extends('master')

@section('judul')
  Invoice Management
@endsection

@section('subjudul')
  Kelola Invoice Proyek
@endsection

@section('content')
  <!-- Header Section -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h2 class="fw-bold text-dark mb-1">Invoice Management</h2>
          <p class="text-muted mb-0">Kelola semua invoice proyek PT Prima Rama Jaya</p>
        </div>
        <div>
          <a href="{{ route('invoices.create') }}" class="btn btn-primary">
            <i class="ti ti-plus me-2"></i>Buat Invoice Baru
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Statistics Cards -->
  <div class="row mb-4">
    <div class="col-md-3">
      <div class="card bg-success-subtle border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="text-success mb-1 fw-semibold">Invoice Lunas</h6>
              <h3 class="fw-bold text-success mb-0">{{ $invoices->where('status', 'paid')->count() }}</h3>
              <small class="text-muted">Invoice</small>
            </div>
            <div class="bg-success rounded-circle p-3">
              <i class="ti ti-check fs-4 text-white"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-md-3">
      <div class="card bg-info-subtle border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="text-info mb-1 fw-semibold">Invoice Terkirim</h6>
              <h3 class="fw-bold text-info mb-0">{{ $invoices->where('status', 'sent')->count() }}</h3>
              <small class="text-muted">Invoice</small>
            </div>
            <div class="bg-info rounded-circle p-3">
              <i class="ti ti-send fs-4 text-white"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-md-3">
      <div class="card bg-warning-subtle border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="text-warning mb-1 fw-semibold">Invoice Draft</h6>
              <h3 class="fw-bold text-warning mb-0">{{ $invoices->where('status', 'draft')->count() }}</h3>
              <small class="text-muted">Invoice</small>
            </div>
            <div class="bg-warning rounded-circle p-3">
              <i class="ti ti-edit fs-4 text-white"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-md-3">
      <div class="card bg-danger-subtle border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="text-danger mb-1 fw-semibold">Invoice Overdue</h6>
              <h3 class="fw-bold text-danger mb-0">{{ $invoices->where('status', 'overdue')->count() }}</h3>
              <small class="text-muted">Invoice</small>
            </div>
            <div class="bg-danger rounded-circle p-3">
              <i class="ti ti-alert-triangle fs-4 text-white"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Invoice List -->
  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pb-0">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-bold mb-0">Daftar Invoice</h5>
            <div class="d-flex gap-2">
              <div class="input-group" style="width: 250px;">
                <span class="input-group-text bg-light border-end-0">
                  <i class="ti ti-search fs-4"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Cari invoice...">
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          @if($invoices->count() > 0)
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Invoice Number</th>
                    <th>Proyek</th>
                    <th>Client</th>
                    <th>Tanggal</th>
                    <th>Jatuh Tempo</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($invoices as $invoice)
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <div class="bg-primary-subtle rounded-3 p-2 me-3">
                            <i class="ti ti-file-invoice fs-4 text-primary"></i>
                          </div>
                          <div>
                            <h6 class="mb-0 fw-semibold">{{ $invoice->invoice_number }}</h6>
                            <small class="text-muted">{{ $invoice->created_at->format('d M Y') }}</small>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="fw-medium">{{ $invoice->proyek->nama_proyek ?? 'N/A' }}</span>
                      </td>
                      <td>
                        <div>
                          <span class="fw-medium">{{ $invoice->client_name }}</span>
                          <br>
                          <small class="text-muted">{{ $invoice->client_email }}</small>
                        </div>
                      </td>
                      <td>{{ $invoice->formatted_invoice_date }}</td>
                      <td>
                        <div class="d-flex flex-column">
                          <span>{{ $invoice->formatted_due_date }}</span>
                          @if($invoice->is_overdue)
                            <small class="text-danger">
                              <i class="ti ti-alert-triangle me-1"></i>
                              Terlambat {{ abs($invoice->days_until_due) }} hari
                            </small>
                          @else
                            <small class="text-muted">{{ $invoice->days_until_due }} hari lagi</small>
                          @endif
                        </div>
                      </td>
                      <td>
                        <span class="fw-bold">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</span>
                      </td>
                      <td>
                        <span class="badge {{ $invoice->status_badge }}">
                          {{ ucfirst($invoice->status) }}
                        </span>
                      </td>
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="ti ti-dots-vertical"></i>
                          </button>
                          <ul class="dropdown-menu">
                            <li>
                              <a class="dropdown-item" href="{{ route('invoices.show', $invoice) }}">
                                <i class="ti ti-eye me-2"></i>Lihat
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item" href="{{ route('invoices.edit', $invoice) }}">
                                <i class="ti ti-edit me-2"></i>Edit
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item" href="{{ route('invoices.download-pdf', $invoice) }}">
                                <i class="ti ti-download me-2"></i>Download PDF
                              </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                              <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="dropdown-item text-danger" type="submit" onclick="return confirm('Yakin hapus invoice ini?')">
                                  <i class="ti ti-trash me-2"></i>Hapus
                                </button>
                              </form>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
              {{ $invoices->links() }}
            </div>
          @else
            <div class="text-center py-5">
              <div class="mb-3">
                <i class="ti ti-file-invoice" style="font-size: 4rem; color: #ddd;"></i>
              </div>
              <h5 class="text-muted">Belum ada invoice</h5>
              <p class="text-muted">Buat invoice pertama Anda untuk memulai</p>
              <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-2"></i>Buat Invoice Baru
              </a>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script>
  // Search functionality
  document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[placeholder="Cari invoice..."]');
    const tableRows = document.querySelectorAll('tbody tr');
    
    searchInput.addEventListener('input', function() {
      const searchTerm = this.value.toLowerCase();
      
      tableRows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    });
  });
</script>
@endsection
