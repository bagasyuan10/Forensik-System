<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kasus;
use App\Models\Korban;
use App\Models\Pelaku;
use App\Models\Bukti;
use App\Models\Tindakan;

class DashboardController extends Controller
{
    public function index()
    {
        // ==========================================
        // 1. STATISTIK UTAMA (KARTU ATAS)
        // ==========================================
        $totalKasus    = Kasus::count();
        $totalKorban   = Korban::count();
        $totalPelaku   = Pelaku::count();
        $totalBukti    = Bukti::count();
        $totalTindakan = Tindakan::count();

        // ==========================================
        // 2. CHART: JENIS KASUS (Doughnut)
        // ==========================================
        $dataJenis = Kasus::select('jenis_kasus', DB::raw('count(*) as total'))
                          ->groupBy('jenis_kasus')
                          ->get();
        
        $labelJenis  = $dataJenis->pluck('jenis_kasus');
        $jumlahJenis = $dataJenis->pluck('total');

        // ==========================================
        // 3. CHART: STATUS KASUS (Pie/Bar)
        // ==========================================
        $rawStatus = Kasus::select('status', DB::raw('count(*) as total'))
                          ->groupBy('status')
                          ->pluck('total', 'status')
                          ->toArray();

        // Format data agar urutannya pas dengan View (Warna Konsisten)
        $labelStatus  = ['Baru', 'Penyidikan', 'Selesai', 'Arsip'];
        $jumlahStatus = [
            $rawStatus['dibuat']     ?? 0,
            $rawStatus['penyidikan'] ?? 0,
            $rawStatus['selesai']    ?? 0,
            $rawStatus['diarsipkan'] ?? 0,
        ];

        // Data Khusus untuk Donut Chart Status
        $statusData = [
            'dibuat'     => $rawStatus['dibuat'] ?? 0,
            'penyidikan' => $rawStatus['penyidikan'] ?? 0,
            'selesai'    => $rawStatus['selesai'] ?? 0,
            'diarsipkan' => $rawStatus['diarsipkan'] ?? 0,
        ];

        // ==========================================
        // 4. CHART: TREN TAHUNAN (Line Chart)
        // ==========================================
        // Menggunakan 'created_at' untuk menghindari error jika kolom 'tanggal_kejadian' kosong
        $dataTahun = Kasus::select(DB::raw("YEAR(created_at) as tahun"), DB::raw('count(*) as total'))
                          ->groupBy('tahun')
                          ->orderBy('tahun', 'asc')
                          ->get();

        $tahunLabel  = $dataTahun->pluck('tahun');
        $tahunJumlah = $dataTahun->pluck('total');

        // ==========================================
        // 5. CHART: KATEGORI BUKTI (Bar)
        // ==========================================
        $dataBukti = Bukti::select('kategori', DB::raw('count(*) as total'))
                          ->groupBy('kategori')
                          ->get();

        $buktiLabel  = $dataBukti->pluck('kategori');
        $buktiJumlah = $dataBukti->pluck('total');

        // ==========================================
        // 6. DATA TERBARU (TABEL & GALERI)
        // ==========================================
        
        // Data Tabel "Aktivitas Kasus Terbaru" (Ambil 5 terakhir)
        $kasusTerbaru = Kasus::latest()->take(5)->get();

        // Data Galeri "Bukti Masuk Terbaru" (Ambil 4 terakhir)
        $buktiTerbaru = Bukti::latest()->take(4)->get();

        // ==========================================
        // 7. KIRIM DATA KE VIEW
        // ==========================================
        return view('dashboard', compact(
            'totalKasus', 'totalKorban', 'totalPelaku', 'totalBukti', 'totalTindakan',
            'labelJenis', 'jumlahJenis',
            'labelStatus', 'jumlahStatus', 'statusData',
            'tahunLabel', 'tahunJumlah',
            'buktiLabel', 'buktiJumlah',
            'kasusTerbaru', 'buktiTerbaru'
        ));
    }
}