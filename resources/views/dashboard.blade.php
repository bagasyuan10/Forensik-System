@extends('layouts.layout')

@section('content')

{{-- Style Khusus Dashboard --}}
<style>
    /* Typography */
    .page-title {
        background: linear-gradient(to right, #fff, #94a3b8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    /* Cards */
    .custom-card {
        background: #1e293b; /* Slate-800 */
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .card-header-dark {
        background: rgba(0, 0, 0, 0.2);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        padding: 15px 20px;
        font-weight: 700;
        color: #e2e8f0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Stat Cards Styling */
    .stat-card {
        background: #1e293b;
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        padding: 24px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
    }

    /* Accent Borders Top */
    .border-top-cyan { border-top: 4px solid #06b6d4; }
    .border-top-purple { border-top: 4px solid #8b5cf6; }
    .border-top-orange { border-top: 4px solid #f97316; }
    .border-top-green { border-top: 4px solid #10b981; }

    /* Icon Box */
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 16px;
    }

    /* Colors */
    .bg-cyan-soft { background: rgba(6, 182, 212, 0.1); color: #22d3ee; }
    .bg-purple-soft { background: rgba(139, 92, 246, 0.1); color: #c084fc; }
    .bg-orange-soft { background: rgba(249, 115, 22, 0.1); color: #fb923c; }
    .bg-green-soft { background: rgba(16, 185, 129, 0.1); color: #34d399; }

    /* Chart Container */
    .chart-container {
        position: relative;
        height: 250px; /* Tinggi chart konsisten */
        width: 100%;
    }
</style>

<div class="container-fluid py-4">

    {{-- ===== HEADER ===== --}}
    <div class="mb-5">
        <h2 class="page-title mb-1">Dashboard Overview</h2>
        <p class="text-secondary m-0">Ringkasan statistik forensik digital real-time.</p>
    </div>

    {{-- ===== ROW 1: STAT CARDS ===== --}}
    <div class="row g-4 mb-5">

        {{-- Card 1: Kasus --}}
        <div class="col-md-3">
            <div class="stat-card border-top-cyan">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-icon bg-cyan-soft">
                            <i class="ph-duotone ph-briefcase"></i>
                        </div>
                        <h2 class="fw-bold text-white mb-0">{{ $totalKasus }}</h2>
                        <span class="text-secondary small">Total Kasus</span>
                    </div>
                    <i class="ph-duotone ph-briefcase position-absolute opacity-10" style="font-size: 100px; right: -20px; bottom: -20px; color: #22d3ee;"></i>
                </div>
            </div>
        </div>

        {{-- Card 2: Korban --}}
        <div class="col-md-3">
            <div class="stat-card border-top-purple">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-icon bg-purple-soft">
                            <i class="ph-duotone ph-users"></i>
                        </div>
                        <h2 class="fw-bold text-white mb-0">{{ $totalKorban }}</h2>
                        <span class="text-secondary small">Total Korban</span>
                    </div>
                    <i class="ph-duotone ph-users position-absolute opacity-10" style="font-size: 100px; right: -20px; bottom: -20px; color: #c084fc;"></i>
                </div>
            </div>
        </div>

        {{-- Card 3: Pelaku --}}
        <div class="col-md-3">
            <div class="stat-card border-top-orange">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-icon bg-orange-soft">
                            <i class="ph-duotone ph-fingerprint"></i>
                        </div>
                        <h2 class="fw-bold text-white mb-0">{{ $totalPelaku }}</h2>
                        <span class="text-secondary small">Total Pelaku</span>
                    </div>
                    <i class="ph-duotone ph-fingerprint position-absolute opacity-10" style="font-size: 100px; right: -20px; bottom: -20px; color: #fb923c;"></i>
                </div>
            </div>
        </div>

        {{-- Card 4: Bukti --}}
        <div class="col-md-3">
            <div class="stat-card border-top-green">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-icon bg-green-soft">
                            <i class="ph-duotone ph-archive-box"></i>
                        </div>
                        <h2 class="fw-bold text-white mb-0">{{ $totalBukti }}</h2>
                        <span class="text-secondary small">Barang Bukti</span>
                    </div>
                    <i class="ph-duotone ph-archive-box position-absolute opacity-10" style="font-size: 100px; right: -20px; bottom: -20px; color: #34d399;"></i>
                </div>
            </div>
        </div>
    </div>


    {{-- ===== ROW 2: CHARTS ===== --}}
    <div class="row g-4 mb-4">
        
        {{-- Chart Jenis Kasus (Doughnut) --}}
        <div class="col-md-6 col-lg-5">
            <div class="custom-card h-100">
                <div class="card-header-dark">
                    <i class="ph-duotone ph-chart-pie-slice text-info"></i>
                    <span>Distribusi Jenis Kasus</span>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center p-4">
                    <div class="chart-container" style="height: 280px;">
                        <canvas id="chartJenis"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Chart Status Investigasi (Bar Horizontal) --}}
        <div class="col-md-6 col-lg-7">
            <div class="custom-card h-100">
                <div class="card-header-dark">
                    <i class="ph-duotone ph-chart-bar text-primary"></i>
                    <span>Status Investigasi</span>
                </div>
                <div class="card-body p-4">
                    <div class="chart-container" style="height: 280px;">
                        <canvas id="chartStatus"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- ===== ROW 3: CHARTS ===== --}}
    <div class="row g-4">

        {{-- Chart Tren Tahunan (Line) --}}
        <div class="col-md-12 col-lg-8">
            <div class="custom-card h-100">
                <div class="card-header-dark">
                    <i class="ph-duotone ph-trend-up text-warning"></i>
                    <span>Tren Kasus Per Tahun</span>
                </div>
                <div class="card-body p-4">
                    <div class="chart-container">
                        <canvas id="chartTahun"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Chart Kategori Bukti (Vertical Bar) --}}
        <div class="col-md-12 col-lg-4">
            <div class="custom-card h-100">
                <div class="card-header-dark">
                    <i class="ph-duotone ph-files text-success"></i>
                    <span>Kategori Barang Bukti</span>
                </div>
                <div class="card-body p-4">
                    <div class="chart-container">
                        <canvas id="chartBukti"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ===== CHART.JS CONFIGURATION ===== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // --- GLOBAL DARK MODE CONFIG ---
    // Mengatur warna default teks dan grid agar terlihat di background gelap
    Chart.defaults.color = '#94a3b8'; // Text color (Slate-400)
    Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.05)'; // Grid line color
    Chart.defaults.font.family = "'Segoe UI', 'Helvetica', 'Arial', sans-serif";

    /* === 1. Kasus Berdasarkan Jenis (Doughnut) === */
    new Chart(document.getElementById('chartJenis'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($labelJenis) !!},
            datasets: [{
                data: {!! json_encode($jumlahJenis) !!},
                backgroundColor: [
                    '#06b6d4', // Cyan
                    '#8b5cf6', // Violet
                    '#3b82f6', // Blue
                    '#f43f5e', // Rose
                    '#10b981', // Emerald
                    '#f59e0b', // Amber
                ],
                borderWidth: 0, // No border for cleaner look
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'right', labels: { boxWidth: 12 } }
            },
            cutout: '70%', // Donat lebih tipis
        }
    });

    /* === 2. Status Investigasi (Horizontal Bar) === */
    new Chart(document.getElementById('chartStatus'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($labelStatus) !!},
            datasets: [{
                label: 'Jumlah Kasus',
                data: {!! json_encode($jumlahStatus) !!},
                backgroundColor: '#3b82f6',
                borderRadius: 5,
                barThickness: 20,
            }]
        },
        options: {
            indexAxis: 'y', // Horizontal
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true, grid: { borderDash: [2, 4] } },
                y: { grid: { display: false } }
            }
        }
    });

    /* === 3. Kasus Per Tahun (Line Chart) === */
    var ctxTahun = document.getElementById('chartTahun').getContext('2d');
    
    // Gradient fill untuk line chart
    var gradientTahun = ctxTahun.createLinearGradient(0, 0, 0, 300);
    gradientTahun.addColorStop(0, 'rgba(245, 158, 11, 0.5)'); // Amber opacity
    gradientTahun.addColorStop(1, 'rgba(245, 158, 11, 0.0)');

    new Chart(ctxTahun, {
        type: 'line',
        data: {
            labels: {!! json_encode($tahunLabel) !!},
            datasets: [{
                label: 'Total Kasus',
                data: {!! json_encode($tahunJumlah) !!},
                borderColor: '#f59e0b', // Amber
                backgroundColor: gradientTahun,
                borderWidth: 3,
                pointBackgroundColor: '#1e293b',
                pointBorderColor: '#f59e0b',
                pointBorderWidth: 2,
                pointRadius: 5,
                fill: true,
                tension: 0.4 // Smooth curve
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                x: { grid: { display: false } }
            }
        }
    });

    /* === 4. Kategori Barang Bukti (Vertical Bar) === */
    new Chart(document.getElementById('chartBukti'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($buktiLabel) !!},
            datasets: [{
                label: 'Item',
                data: {!! json_encode($buktiJumlah) !!},
                backgroundColor: '#10b981', // Emerald
                borderRadius: 4,
                barThickness: 30,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [2, 4] } },
                x: { grid: { display: false } }
            }
        }
    });
</script>

@endsection