@extends('layouts.layout')

@section('content')

{{-- CDN SweetAlert2 (Wajib untuk pop-up lucu) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- CDN Animate.css (Untuk animasi masuk) --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    /* === 1. ATMOSPHERE & BACKGROUND === */
    :root {
        --glass-bg: rgba(30, 41, 59, 0.7);
        --glass-border: rgba(255, 255, 255, 0.08);
        --neon-cyan: #06b6d4;
        --neon-purple: #8b5cf6;
    }

    /* === 2. TYPOGRAPHY === */
    .page-title {
        background: linear-gradient(135deg, #fff 0%, #94a3b8 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 900;
        letter-spacing: -1px;
        text-shadow: 0 10px 30px rgba(255, 255, 255, 0.1);
    }

    /* === 3. GLASS CARDS (The "Cool" Factor) === */
    .custom-card {
        background: var(--glass-bg);
        backdrop-filter: blur(12px); /* Efek blur di belakang kartu */
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .custom-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px -5px rgba(0, 0, 0, 0.3);
        border-color: rgba(255, 255, 255, 0.2);
    }
    
    .card-header-dark {
        background: rgba(0, 0, 0, 0.2);
        border-bottom: 1px solid var(--glass-border);
        padding: 20px 24px;
        font-weight: 700;
        color: #e2e8f0;
        display: flex;
        align-items: center;
        gap: 12px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        font-size: 0.85rem;
    }

    /* === 4. STAT CARDS === */
    .stat-card {
        background: linear-gradient(145deg, rgba(30, 41, 59, 0.9), rgba(30, 41, 59, 0.4));
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        padding: 24px;
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); /* Bouncy effect */
    }

    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        border-color: rgba(255,255,255,0.2);
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.5);
    }

    /* Glowing Borders Top */
    .border-top-cyan { border-top: 4px solid #06b6d4; box-shadow: 0 -10px 20px -5px rgba(6, 182, 212, 0.3); }
    .border-top-purple { border-top: 4px solid #8b5cf6; box-shadow: 0 -10px 20px -5px rgba(139, 92, 246, 0.3); }
    .border-top-orange { border-top: 4px solid #f97316; box-shadow: 0 -10px 20px -5px rgba(249, 115, 22, 0.3); }
    .border-top-green { border-top: 4px solid #10b981; box-shadow: 0 -10px 20px -5px rgba(16, 185, 129, 0.3); }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 16px;
        box-shadow: inset 0 0 20px rgba(255,255,255,0.05);
    }

    /* Colors with Glow */
    .bg-cyan-soft { background: rgba(6, 182, 212, 0.15); color: #22d3ee; box-shadow: 0 0 15px rgba(6, 182, 212, 0.2); }
    .bg-purple-soft { background: rgba(139, 92, 246, 0.15); color: #c084fc; box-shadow: 0 0 15px rgba(139, 92, 246, 0.2); }
    .bg-orange-soft { background: rgba(249, 115, 22, 0.15); color: #fb923c; box-shadow: 0 0 15px rgba(249, 115, 22, 0.2); }
    .bg-green-soft { background: rgba(16, 185, 129, 0.15); color: #34d399; box-shadow: 0 0 15px rgba(16, 185, 129, 0.2); }

    /* === 5. UTILS & ANIMATION === */
    .chart-container {
        position: relative;
        height: 250px;
        width: 100%;
    }
    
    /* Animasi Staggered untuk Load Halaman */
    .animate-delay-1 { animation-delay: 0.1s; }
    .animate-delay-2 { animation-delay: 0.2s; }
    .animate-delay-3 { animation-delay: 0.3s; }
    .animate-delay-4 { animation-delay: 0.4s; }
</style>

<div class="container-fluid py-4">
    
    {{-- ===== HEADER ===== --}}
    <div class="mb-5 animate__animated animate__fadeInDown">
        <h2 class="page-title mb-1">Dashboard Overview</h2>
        <p class="text-secondary m-0 d-flex align-items-center gap-2">
            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-10 rounded-pill px-3">
                <i class="ph-fill ph-circle-notch animate-spin me-1"></i> Live Data
            </span>
            Ringkasan statistik forensik digital.
        </p>
    </div>

    {{-- ===== ROW 1: STAT CARDS ===== --}}
    <div class="row g-4 mb-5">
        {{-- Card 1 --}}
        <div class="col-md-3 animate__animated animate__fadeInUp animate-delay-1">
            <div class="stat-card border-top-cyan">
                <div class="d-flex justify-content-between align-items-start position-relative z-1">
                    <div>
                        <div class="stat-icon bg-cyan-soft">
                            <i class="ph-duotone ph-briefcase"></i>
                        </div>
                        <h2 class="fw-bold text-white mb-0 display-6">{{ $totalKasus }}</h2>
                        <span class="text-secondary fw-medium small text-uppercase ls-1">Total Kasus</span>
                    </div>
                </div>
                {{-- Decorative Icon Background --}}
                <i class="ph-duotone ph-briefcase position-absolute opacity-10" style="font-size: 140px; right: -30px; bottom: -40px; color: #22d3ee; transform: rotate(-15deg);"></i>
            </div>
        </div>

        {{-- Card 2 --}}
        <div class="col-md-3 animate__animated animate__fadeInUp animate-delay-2">
            <div class="stat-card border-top-purple">
                <div class="d-flex justify-content-between align-items-start position-relative z-1">
                    <div>
                        <div class="stat-icon bg-purple-soft">
                            <i class="ph-duotone ph-users"></i>
                        </div>
                        <h2 class="fw-bold text-white mb-0 display-6">{{ $totalKorban }}</h2>
                        <span class="text-secondary fw-medium small text-uppercase ls-1">Total Korban</span>
                    </div>
                </div>
                <i class="ph-duotone ph-users position-absolute opacity-10" style="font-size: 140px; right: -30px; bottom: -40px; color: #c084fc; transform: rotate(-15deg);"></i>
            </div>
        </div>

        {{-- Card 3 --}}
        <div class="col-md-3 animate__animated animate__fadeInUp animate-delay-3">
            <div class="stat-card border-top-orange">
                <div class="d-flex justify-content-between align-items-start position-relative z-1">
                    <div>
                        <div class="stat-icon bg-orange-soft">
                            <i class="ph-duotone ph-fingerprint"></i>
                        </div>
                        <h2 class="fw-bold text-white mb-0 display-6">{{ $totalPelaku }}</h2>
                        <span class="text-secondary fw-medium small text-uppercase ls-1">Total Pelaku</span>
                    </div>
                </div>
                <i class="ph-duotone ph-fingerprint position-absolute opacity-10" style="font-size: 140px; right: -30px; bottom: -40px; color: #fb923c; transform: rotate(-15deg);"></i>
            </div>
        </div>

        {{-- Card 4 --}}
        <div class="col-md-3 animate__animated animate__fadeInUp animate-delay-4">
            <div class="stat-card border-top-green">
                <div class="d-flex justify-content-between align-items-start position-relative z-1">
                    <div>
                        <div class="stat-icon bg-green-soft">
                            <i class="ph-duotone ph-package"></i>
                        </div>
                        <h2 class="fw-bold text-white mb-0 display-6">{{ $totalBukti }}</h2>
                        <span class="text-secondary fw-medium small text-uppercase ls-1">Barang Bukti</span>
                    </div>
                </div>
                <i class="ph-duotone ph-package position-absolute opacity-10" style="font-size: 140px; right: -30px; bottom: -40px; color: #34d399; transform: rotate(-15deg);"></i>
            </div>
        </div>
    </div>


    {{-- ===== ROW 2: CHARTS ===== --}}
    <div class="row g-4 mb-4">
        
        {{-- Chart Jenis Kasus (Doughnut) --}}
        <div class="col-md-6 col-lg-5 animate__animated animate__zoomIn animate-delay-2">
            <div class="custom-card h-100">
                <div class="card-header-dark">
                    <i class="ph-duotone ph-chart-pie-slice text-info fs-5"></i>
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
        <div class="col-md-6 col-lg-7 animate__animated animate__zoomIn animate-delay-3">
            <div class="custom-card h-100">
                <div class="card-header-dark">
                    <i class="ph-duotone ph-chart-bar text-primary fs-5"></i>
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
    
    {{-- ===== ROW 3: TREND & GALERI BUKTI ===== --}}
    <div class="row g-4">

        {{-- Chart Tren Tahunan --}}
        <div class="col-md-12 col-lg-8 animate__animated animate__fadeInUp animate-delay-4">
            <div class="custom-card h-100">
                <div class="card-header-dark">
                    <i class="ph-duotone ph-trend-up text-warning fs-5"></i>
                    <span>Tren Kasus Per Tahun</span>
                </div>
                <div class="card-body p-4">
                    <div class="chart-container">
                        <canvas id="chartTahun"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Galeri Bukti Terbaru --}}
        <div class="col-md-12 col-lg-4 animate__animated animate__fadeInUp animate-delay-4">
            <div class="custom-card h-100">
                <div class="card-header-dark d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ph-duotone ph-images text-success fs-5"></i>
                        <span>Bukti Masuk Terbaru</span>
                    </div>
                    <a href="{{ route('bukti.index') }}" class="btn btn-sm btn-outline-success border-0 bg-success bg-opacity-10 text-success fw-bold" style="font-size: 0.75rem;">View All</a>
                </div>

                <div class="card-body p-3">
                    @if(isset($buktiTerbaru) && $buktiTerbaru->count() > 0)
                        <div class="d-flex flex-column gap-3">
                            @foreach($buktiTerbaru as $b)
                                <div class="d-flex align-items-center gap-3 p-2 rounded hover-bg-light transition-base" 
                                     style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); cursor: pointer;"
                                     onclick="showEvidenceDetail('{{ $b->nama_bukti }}', '{{ $b->foto ? asset('storage/' . $b->foto) : '' }}')">
                                    
                                    {{-- Thumbnail --}}
                                    <div style="width: 50px; height: 50px; flex-shrink: 0; overflow: hidden; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1);">
                                        @if($b->foto)
                                            <img src="{{ asset('storage/' . $b->foto) }}" class="w-100 h-100" style="object-fit: cover; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
                                        @else
                                            <div class="w-100 h-100 bg-dark d-flex align-items-center justify-content-center text-secondary">
                                                <i class="ph-bold ph-image"></i>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Info --}}
                                    <div class="overflow-hidden flex-grow-1">
                                        <div class="text-white fw-bold text-truncate" style="font-size: 0.9rem;">
                                            {{ $b->nama_bukti }}
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-1">
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20" style="font-size: 0.65rem;">
                                                {{ $b->jenis_bukti ?? 'Umum' }}
                                            </span>
                                            <span class="text-secondary small" style="font-size: 0.7rem;">
                                                <i class="ph-bold ph-clock me-1"></i>{{ $b->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5 text-secondary">
                            <i class="ph-duotone ph-coffee" style="font-size: 40px; opacity: 0.5;"></i>
                            <p class="mt-2 mb-0 small">Belum ada aktivitas terbaru.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== CHART.JS & SWEETALERT LOGIC ===== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // --- 1. POP UP LUCU (SweetAlert2) ---
    
    // Fungsi Toast Kecil di Pojok Kanan
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
        background: '#1e293b',
        color: '#fff',
        iconColor: '#34d399',
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        },
        customClass: {
            popup: 'colored-toast'
        }
    });

    // Cek Session PHP dan Tampilkan Pop Up
    @if (session('success') || session('verified'))
        Swal.fire({
            title: 'Berhasil!',
            text: "{{ session('success') ?? 'Data berhasil diverifikasi.' }}",
            icon: 'success',
            background: '#1e293b', // Dark background
            color: '#fff',
            confirmButtonColor: '#10b981',
            confirmButtonText: 'Keren!',
            showClass: {
                popup: 'animate__animated animate__bounceIn'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        });
    @else
        // Pesan Welcome Back (Opsional)
        Toast.fire({
            icon: 'info',
            title: 'Welcome Back!',
            text: 'Dashboard siap digunakan.'
        });
    @endif

    // Fungsi Pop Up Detail Bukti (Dipanggil saat klik list bukti)
    function showEvidenceDetail(title, imageUrl) {
        if(!imageUrl) return;
        
        Swal.fire({
            title: title,
            imageUrl: imageUrl,
            imageHeight: 300,
            imageAlt: 'Gambar Bukti',
            background: '#1e293b',
            color: '#fff',
            showConfirmButton: false,
            showCloseButton: true,
            backdrop: 'rgba(0, 0, 0, 0.8)',
            showClass: { popup: 'animate__animated animate__zoomIn' }
        });
    }

    // --- 2. CHART CONFIGURATION (DARK MODE) ---
    Chart.defaults.color = '#94a3b8'; 
    Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.05)'; 
    Chart.defaults.font.family = "'Segoe UI', sans-serif";

    /* === Chart Jenis Kasus (Doughnut) === */
    new Chart(document.getElementById('chartJenis'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($labelJenis) !!},
            datasets: [{
                data: {!! json_encode($jumlahJenis) !!},
                backgroundColor: ['#06b6d4', '#8b5cf6', '#3b82f6', '#f43f5e', '#10b981', '#f59e0b'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
            },
            cutout: '75%', 
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });

    /* === Chart Status (Bar Horizontal) === */
    new Chart(document.getElementById('chartStatus'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($labelStatus) !!},
            datasets: [{
                label: 'Jumlah Kasus',
                data: {!! json_encode($jumlahStatus) !!},
                backgroundColor: '#3b82f6',
                borderRadius: 8,
                barThickness: 25,
            }]
        },
        options: {
            indexAxis: 'y', 
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true, grid: { borderDash: [2, 4] } },
                y: { grid: { display: false } }
            }
        }
    });

    /* === Chart Tren Tahunan (Glowing Line) === */
    var ctxTahun = document.getElementById('chartTahun').getContext('2d');
    var gradientTahun = ctxTahun.createLinearGradient(0, 0, 0, 300);
    gradientTahun.addColorStop(0, 'rgba(249, 115, 22, 0.4)'); 
    gradientTahun.addColorStop(1, 'rgba(249, 115, 22, 0.0)');

    new Chart(ctxTahun, {
        type: 'line',
        data: {
            labels: {!! json_encode($tahunLabel) !!},
            datasets: [{
                label: 'Total Kasus',
                data: {!! json_encode($tahunJumlah) !!},
                borderColor: '#f97316', 
                backgroundColor: gradientTahun,
                borderWidth: 3,
                pointBackgroundColor: '#1e293b',
                pointBorderColor: '#f97316',
                pointHoverBackgroundColor: '#f97316',
                pointHoverBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 8, // Efek membesar saat hover
                fill: true,
                tension: 0.4 
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: { legend: { display: false }, tooltip: {
                backgroundColor: 'rgba(30, 41, 59, 0.9)',
                titleColor: '#fff',
                bodyColor: '#cbd5e1',
                borderColor: 'rgba(255,255,255,0.1)',
                borderWidth: 1,
                padding: 10,
                displayColors: false
            }},
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                x: { grid: { display: false } }
            }
        }
    });
</script>

@endsection