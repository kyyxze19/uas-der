@extends('master')

@section('judul')
  admin
@endsection

@section('subjudul')
@endsection

@section('content')
  <!-- Header Section -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h2 class="fw-bold text-dark mb-1">Dashboard Manajemen Proyek</h2>
          <p class="text-muted mb-0">Selamat datang di sistem manajemen proyek PT Prima Rama Jaya</p>
        </div>
        <div class="d-flex align-items-center">
          <div class="bg-primary-subtle rounded-3 p-3">
            <i class="ti ti-chart-bar fs-4 text-primary"></i>
          </div>
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
              <h6 class="text-success mb-1 fw-semibold">Proyek Selesai</h6>
              <h3 class="fw-bold text-success mb-0">{{ $chartData['selesai'] }}</h3>
              <small class="text-muted">Bulan ini</small>
            </div>
            <div class="bg-success rounded-circle p-3">
              <i class="ti ti-check fs-4 text-white"></i>
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
              <h6 class="text-warning mb-1 fw-semibold">Proyek Berjalan</h6>
              <h3 class="fw-bold text-warning mb-0">{{ $chartData['berjalan'] }}</h3>
              <small class="text-muted">Sedang aktif</small>
            </div>
            <div class="bg-warning rounded-circle p-3">
              <i class="ti ti-clock fs-4 text-white"></i>
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
              <h6 class="text-danger mb-1 fw-semibold">Belum Selesai</h6>
              <h3 class="fw-bold text-danger mb-0">{{ $chartData['belum_selesai'] }}</h3>
              <small class="text-muted">Perlu perhatian</small>
            </div>
            <div class="bg-danger rounded-circle p-3">
              <i class="ti ti-alert-triangle fs-4 text-white"></i>
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
              <h6 class="text-info mb-1 fw-semibold">Total Proyek</h6>
              <h3 class="fw-bold text-info mb-0">{{ $chartData['selesai'] + $chartData['berjalan'] + $chartData['belum_selesai'] }}</h3>
              <small class="text-muted">Bulan ini</small>
            </div>
            <div class="bg-info rounded-circle p-3">
              <i class="ti ti-briefcase fs-4 text-white"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Charts Section -->
  <div class="row mb-4">
    <!-- Main Chart -->
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pb-0">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h5 class="card-title fw-bold mb-1">Analisis Status Proyek</h5>
              <p class="text-muted mb-0 fs-3">Distribusi proyek berdasarkan status bulan {{ date('F Y') }}</p>
            </div>
            <div class="dropdown">
              <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="ti ti-dots-vertical fs-4"></i>
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#"><i class="ti ti-download me-2"></i>Export Data</a></li>
                <li><a class="dropdown-item" href="#"><i class="ti ti-refresh me-2"></i>Refresh</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div style="height: 350px;">
            <canvas id="chartSummary"></canvas>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Progress Cards -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-white border-0 pb-0">
          <h5 class="card-title fw-bold mb-1">Progress Overview</h5>
          <p class="text-muted mb-0 fs-3">Status detail proyek</p>
        </div>
        <div class="card-body">
          <!-- Proyek Selesai Progress -->
          <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="fw-semibold text-success">Proyek Selesai</span>
              <span class="badge bg-success-subtle text-success">{{ $chartData['selesai'] }} Proyek</span>
            </div>
            <div class="progress" style="height: 8px;">
              @php
                $totalProyek = $chartData['selesai'] + $chartData['berjalan'] + $chartData['belum_selesai'];
                $persentaseSelesai = $totalProyek > 0 ? ($chartData['selesai'] / $totalProyek) * 100 : 0;
              @endphp
              <div class="progress-bar bg-success" role="progressbar" 
                   style="width: {{ number_format($persentaseSelesai, 1) }}%"
                   aria-valuenow="{{ $chartData['selesai'] }}" 
                   aria-valuemin="0" 
                   aria-valuemax="{{ $totalProyek }}">
                {{ number_format($persentaseSelesai, 1) }}%
              </div>
            </div>
          </div>
          
          <!-- Proyek Berjalan Progress -->
          <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="fw-semibold text-warning">Proyek Berjalan</span>
              <span class="badge bg-warning-subtle text-warning">{{ $chartData['berjalan'] }} Proyek</span>
            </div>
            <div class="progress" style="height: 8px;">
              @php
                $persentaseBerjalan = $totalProyek > 0 ? ($chartData['berjalan'] / $totalProyek) * 100 : 0;
              @endphp
              <div class="progress-bar bg-warning" role="progressbar" 
                   style="width: {{ number_format($persentaseBerjalan, 1) }}%"
                   aria-valuenow="{{ $chartData['berjalan'] }}" 
                   aria-valuemin="0" 
                   aria-valuemax="{{ $totalProyek }}">
                {{ number_format($persentaseBerjalan, 1) }}%
              </div>
            </div>
          </div>
          
          <!-- Proyek Belum Selesai Progress -->
          <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="fw-semibold text-danger">Belum Selesai</span>
              <span class="badge bg-danger-subtle text-danger">{{ $chartData['belum_selesai'] }} Proyek</span>
            </div>
            <div class="progress" style="height: 8px;">
              @php
                $persentaseBelumSelesai = $totalProyek > 0 ? ($chartData['belum_selesai'] / $totalProyek) * 100 : 0;
              @endphp
              <div class="progress-bar bg-danger" role="progressbar" 
                   style="width: {{ number_format($persentaseBelumSelesai, 1) }}%"
                   aria-valuenow="{{ $chartData['belum_selesai'] }}" 
                   aria-valuemin="0" 
                   aria-valuemax="{{ $totalProyek }}">
                {{ number_format($persentaseBelumSelesai, 1) }}%
              </div>
            </div>
          </div>
          
          <!-- Quick Actions -->
          <div class="mt-4">
            <h6 class="fw-semibold mb-3">Quick Actions</h6>
            <div class="d-grid gap-2">
              <a href="/kelola-proyek" class="btn btn-primary btn-sm">
                <i class="ti ti-plus me-2"></i>Tambah Proyek Baru
              </a>
              <a href="/proyek" class="btn btn-outline-primary btn-sm">
                <i class="ti ti-list me-2"></i>Lihat Semua Proyek
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Individual Charts -->
  <div class="row mb-4">
    <div class="col-12">
      <h5 class="fw-bold mb-3">Detail Status Proyek</h5>
    </div>
      <div class="col-lg-4 mb-3">
      <div class="card shadow-sm border-start border-success border-4">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="card-title text-success fw-bold mb-0">Proyek Selesai</h6>
            <div class="bg-success-subtle rounded-3 p-2">
              <i class="ti ti-check fs-5 text-success"></i>
            </div>
          </div>
          <div style="height: 200px;">
            <canvas id="chartSelesai"></canvas>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-lg-4 mb-3">
      <div class="card shadow-sm border-start border-warning border-4">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="card-title text-warning fw-bold mb-0">Proyek Berjalan</h6>
            <div class="bg-warning-subtle rounded-3 p-2">
              <i class="ti ti-clock fs-5 text-warning"></i>
            </div>
          </div>
          <div style="height: 200px;">
            <canvas id="chartBerjalan"></canvas>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-lg-4 mb-3">
      <div class="card shadow-sm border-start border-danger border-4">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="card-title text-danger fw-bold mb-0">Belum Selesai</h6>
            <div class="bg-danger-subtle rounded-3 p-2">
              <i class="ti ti-alert-triangle fs-5 text-danger"></i>
            </div>
          </div>
          <div style="height: 200px;">
            <canvas id="chartBelumSelesai"></canvas>
          </div>
        </div>      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Data dari Laravel
  const chartData = @json($chartData);
  
  // Konfigurasi warna
  const colors = {
    selesai: '#28a745',
    berjalan: '#ffc107', 
    belumSelesai: '#dc3545'
  };
  
  // Chart Proyek Selesai
  const ctxSelesai = document.getElementById('chartSelesai').getContext('2d');
  new Chart(ctxSelesai, {
    type: 'bar',
    data: {
      labels: ['Selesai'],
      datasets: [{
        label: 'Jumlah Proyek',
        data: [chartData.selesai],
        backgroundColor: [colors.selesai],
        borderColor: [colors.selesai],
        borderWidth: 2,
        borderRadius: 8,
        borderSkipped: false,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1
          }
        },
        x: {
          display: false
        }
      }
    }
  });
  
  // Chart Proyek Berjalan
  const ctxBerjalan = document.getElementById('chartBerjalan').getContext('2d');
  new Chart(ctxBerjalan, {
    type: 'bar',
    data: {
      labels: ['Berjalan'],
      datasets: [{
        label: 'Jumlah Proyek',
        data: [chartData.berjalan],
        backgroundColor: [colors.berjalan],
        borderColor: [colors.berjalan],
        borderWidth: 2,
        borderRadius: 8,
        borderSkipped: false,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1
          }
        },
        x: {
          display: false
        }
      }
    }
  });
  
  // Chart Proyek Belum Selesai
  const ctxBelumSelesai = document.getElementById('chartBelumSelesai').getContext('2d');
  new Chart(ctxBelumSelesai, {
    type: 'bar',
    data: {
      labels: ['Belum Selesai'],
      datasets: [{
        label: 'Jumlah Proyek',
        data: [chartData.belum_selesai],
        backgroundColor: [colors.belumSelesai],
        borderColor: [colors.belumSelesai],
        borderWidth: 2,
        borderRadius: 8,
        borderSkipped: false,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1
          }
        },
        x: {
          display: false
        }
      }
    }
  });
  
  // Chart Summary (Bar Chart)
  const ctxSummary = document.getElementById('chartSummary').getContext('2d');
  new Chart(ctxSummary, {
    type: 'bar',
    data: {
      labels: ['Proyek Selesai', 'Proyek Berjalan', 'Proyek Belum Selesai'],
      datasets: [{
        label: 'Jumlah Proyek',
        data: [chartData.selesai, chartData.berjalan, chartData.belum_selesai],
        backgroundColor: [colors.selesai, colors.berjalan, colors.belumSelesai],
        borderColor: [colors.selesai, colors.berjalan, colors.belumSelesai],
        borderWidth: 2,
        borderRadius: 8,
        borderSkipped: false,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        },
        title: {
          display: true,
          text: 'Statistik Proyek Bulan ' + new Date().toLocaleString('id-ID', { month: 'long', year: 'numeric' }),
          font: {
            size: 16,
            weight: 'bold'
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1
          }
        }
      }
    }
  });
</script>
@endsection