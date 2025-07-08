@extends('master')

@sectio                <div class="mb-3">
                  <label class="form-label fw-semibold">Proyek <span class="text-danger">*</span></label>
                  <select name="id_proyek" class="form-select @error('id_proyek') is-invalid @enderror" required>
                    <option value="">Pilih Proyek</option>
                    @foreach($proyeks as $proyek)
                      <option value="{{ $proyek->id_proyek }}" {{ old('id_proyek') == $proyek->id_proyek ? 'selected' : '' }}>
                        {{ $proyek->nama_proyek }}
                      </option>
                    @endforeach
                  </select>
                  @error('id_proyek')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>Buat Invoice Baru
@endsection

@section('subjudul')
  Tambah Invoice Proyek
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pb-0">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-bold mb-0">Buat Invoice Baru</h5>
            <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary">
              <i class="ti ti-arrow-left me-2"></i>Kembali
            </a>
          </div>
        </div>
        <div class="card-body">
          <form action="{{ route('invoices.store') }}" method="POST" id="invoiceForm">
            @csrf
            
            <div class="row">
              <!-- Left Column -->
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label fw-semibold">Proyek <span class="text-danger">*</span></label>
                  <select name="proyek_id" class="form-select @error('proyek_id') is-invalid @enderror" required>
                    <option value="">Pilih Proyek</option>
                    @foreach($proyeks as $proyek)
                      <option value="{{ $proyek->id_proyek }}" {{ old('proyek_id') == $proyek->id_proyek ? 'selected' : '' }}>
                        {{ $proyek->nama_proyek }}
                      </option>
                    @endforeach
                  </select>
                  @error('proyek_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label class="form-label fw-semibold">Nama Client <span class="text-danger">*</span></label>
                  <input type="text" name="client_name" class="form-control @error('client_name') is-invalid @enderror" 
                         value="{{ old('client_name') }}" required>
                  @error('client_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label class="form-label fw-semibold">Email Client <span class="text-danger">*</span></label>
                  <input type="email" name="client_email" class="form-control @error('client_email') is-invalid @enderror" 
                         value="{{ old('client_email') }}" required>
                  @error('client_email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label class="form-label fw-semibold">Alamat Client <span class="text-danger">*</span></label>
                  <textarea name="client_address" class="form-control @error('client_address') is-invalid @enderror" 
                            rows="3" required>{{ old('client_address') }}</textarea>
                  @error('client_address')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <!-- Right Column -->
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label fw-semibold">Tanggal Invoice <span class="text-danger">*</span></label>
                  <input type="date" name="invoice_date" class="form-control @error('invoice_date') is-invalid @enderror" 
                         value="{{ old('invoice_date', date('Y-m-d')) }}" required>
                  @error('invoice_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label class="form-label fw-semibold">Jatuh Tempo <span class="text-danger">*</span></label>
                  <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror" 
                         value="{{ old('due_date', date('Y-m-d', strtotime('+30 days'))) }}" required>
                  @error('due_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label class="form-label fw-semibold">Pajak (%)</label>
                  <input type="number" name="tax_rate" class="form-control @error('tax_rate') is-invalid @enderror" 
                         value="{{ old('tax_rate', 0) }}" min="0" max="100" step="0.01">
                  @error('tax_rate')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label class="form-label fw-semibold">Diskon (Rp)</label>
                  <input type="number" name="discount_amount" class="form-control @error('discount_amount') is-invalid @enderror" 
                         value="{{ old('discount_amount', 0) }}" min="0" step="0.01">
                  @error('discount_amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-semibold">Catatan</label>
              <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" 
                        rows="3" placeholder="Catatan tambahan untuk invoice...">{{ old('notes') }}</textarea>
              @error('notes')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Invoice Items -->
            <div class="mb-4">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-semibold">Item Invoice</h6>
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="addItem()">
                  <i class="ti ti-plus me-2"></i>Tambah Item
                </button>
              </div>

              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead class="table-light">
                    <tr>
                      <th width="40%">Deskripsi</th>
                      <th width="15%">Qty</th>
                      <th width="20%">Harga Unit</th>
                      <th width="20%">Total</th>
                      <th width="5%">Aksi</th>
                    </tr>
                  </thead>
                  <tbody id="itemsTable">
                    <!-- Items will be added here -->
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Summary -->
            <div class="row">
              <div class="col-md-6 offset-md-6">
                <div class="card bg-light">
                  <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                      <span>Subtotal:</span>
                      <span id="subtotal">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                      <span>Pajak:</span>
                      <span id="taxAmount">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                      <span>Diskon:</span>
                      <span id="discountAmount">Rp 0</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                      <span>Total:</span>
                      <span id="totalAmount">Rp 0</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="mt-4">
              <button type="submit" class="btn btn-primary me-2">
                <i class="ti ti-device-floppy me-2"></i>Simpan Invoice
              </button>
              <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary">
                <i class="ti ti-x me-2"></i>Batal
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script>
  let itemCount = 0;

  function addItem() {
    const tbody = document.getElementById('itemsTable');
    const row = document.createElement('tr');
    
    row.innerHTML = `
      <td>
        <input type="text" name="items[${itemCount}][description]" class="form-control" placeholder="Deskripsi item..." required>
      </td>
      <td>
        <input type="number" name="items[${itemCount}][quantity]" class="form-control quantity" min="1" value="1" required onchange="calculateItemTotal(this)">
      </td>
      <td>
        <input type="number" name="items[${itemCount}][unit_price]" class="form-control unit-price" min="0" step="0.01" required onchange="calculateItemTotal(this)">
      </td>
      <td>
        <span class="item-total">Rp 0</span>
      </td>
      <td>
        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeItem(this)">
          <i class="ti ti-trash"></i>
        </button>
      </td>
    `;
    
    tbody.appendChild(row);
    itemCount++;
  }

  function removeItem(button) {
    button.closest('tr').remove();
    calculateSummary();
  }

  function calculateItemTotal(input) {
    const row = input.closest('tr');
    const quantity = row.querySelector('.quantity').value || 0;
    const unitPrice = row.querySelector('.unit-price').value || 0;
    const total = quantity * unitPrice;
    
    row.querySelector('.item-total').textContent = `Rp ${formatNumber(total)}`;
    calculateSummary();
  }

  function calculateSummary() {
    let subtotal = 0;
    
    document.querySelectorAll('#itemsTable tr').forEach(row => {
      const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
      const unitPrice = parseFloat(row.querySelector('.unit-price').value) || 0;
      subtotal += quantity * unitPrice;
    });
    
    const taxRate = parseFloat(document.querySelector('input[name="tax_rate"]').value) || 0;
    const discountAmount = parseFloat(document.querySelector('input[name="discount_amount"]').value) || 0;
    
    const taxAmount = subtotal * (taxRate / 100);
    const total = subtotal + taxAmount - discountAmount;
    
    document.getElementById('subtotal').textContent = `Rp ${formatNumber(subtotal)}`;
    document.getElementById('taxAmount').textContent = `Rp ${formatNumber(taxAmount)}`;
    document.getElementById('discountAmount').textContent = `Rp ${formatNumber(discountAmount)}`;
    document.getElementById('totalAmount').textContent = `Rp ${formatNumber(total)}`;
  }

  function formatNumber(num) {
    return new Intl.NumberFormat('id-ID').format(num);
  }

  // Event listeners
  document.addEventListener('DOMContentLoaded', function() {
    addItem(); // Add first item
    
    // Listen for changes in tax rate and discount
    document.querySelector('input[name="tax_rate"]').addEventListener('input', calculateSummary);
    document.querySelector('input[name="discount_amount"]').addEventListener('input', calculateSummary);
  });

  // Form validation
  document.getElementById('invoiceForm').addEventListener('submit', function(e) {
    const items = document.querySelectorAll('#itemsTable tr');
    if (items.length === 0) {
      e.preventDefault();
      alert('Minimal tambahkan 1 item invoice!');
      return false;
    }
    
    let hasValidItem = false;
    items.forEach(row => {
      const description = row.querySelector('input[name*="[description]"]').value;
      const quantity = row.querySelector('input[name*="[quantity]"]').value;
      const unitPrice = row.querySelector('input[name*="[unit_price]"]').value;
      
      if (description && quantity && unitPrice) {
        hasValidItem = true;
      }
    });
    
    if (!hasValidItem) {
      e.preventDefault();
      alert('Pastikan semua item memiliki deskripsi, qty, dan harga yang valid!');
      return false;
    }
  });
</script>
@endsection
