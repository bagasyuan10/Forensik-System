@extends('layouts.layout')

@section('content')
<div class="container-fluid">

    <h3 class="mb-4 fw-bold">Dashboard ForensicSys</h3>

    {{-- === ROW 1: CARDS === --}}
    <div class="row g-3">

        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <h1 class="display-6">{{ $totalKasus }}</h1>
                <p class="text-muted">Total Kasus</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <h1 class="display-6">{{ $totalKorban }}</h1>
                <p class="text-muted">Total Korban</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <h1 class="display-6">{{ $totalPelaku }}</h1>
                <p class="text-muted">Total Pelaku</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <h1 class="display-6">{{ $totalBukti }}</h1>
                <p class="text-muted">Barang Bukti</p>
            </div>
        </div>
    </div>

    {{-- === ROW 2: CHARTS === --}}
    <div class="row mt-4 g-3">

        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h6 class="fw-bold">Kasus Berdasarkan Jenis</h6>
                <canvas id="chartJenis"></canvas>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h6 class="fw-bold">Status Investigasi</h6>
                <canvas id="chartStatus"></canvas>
            </div>
        </div>

    </div>

    {{-- === ROW 3: CHARTS === --}}
    <div class="row mt-4 g-3">

        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h6 class="fw-bold">Kasus Per Tahun</h6>
                <canvas id="chartTahun"></canvas>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h6 class="fw-bold">Kategori Barang Bukti</h6>
                <canvas id="chartBukti"></canvas>
            </div>
        </div>

    </div>

</div>


{{-- === CHART.JS === --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('chartJenis'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($labelJenis) !!},
        datasets: [{
            data: {!! json_encode($jumlahJenis) !!},
        }]
    }
});

new Chart(document.getElementById('chartStatus'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($labelStatus) !!},
        datasets: [{
            data: {!! json_encode($jumlahStatus) !!},
        }]
    },
    options: {
        indexAxis: 'y'
    }
});

new Chart(document.getElementById('chartTahun'), {
    type: 'line',
    data: {
        labels: {!! json_encode($tahunLabel) !!},
        datasets: [{
            data: {!! json_encode($tahunJumlah) !!},
            fill: false,
            tension: 0.3
        }]
    }
});

new Chart(document.getElementById('chartBukti'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($buktiLabel) !!},
        datasets: [{
            data: {!! json_encode($buktiJumlah) !!}
        }]
    }
});
</script>

@endsection