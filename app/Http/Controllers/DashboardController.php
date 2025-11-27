<?php

namespace App\Http\Controllers;

use App\Models\Kasus;
use App\Models\Korban;
use App\Models\Pelaku;
use App\Models\Bukti;
use App\Models\Tindakan;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalKasus'   => Kasus::count(),
            'totalKorban'  => Korban::count(),
            'totalPelaku'  => Pelaku::count(),
            'totalBukti'   => Bukti::count(),
            'totalTindakan'=> Tindakan::count(),

            // Chart berdasarkan jenis kasus
            'labelJenis'   => Kasus::select('jenis_kasus')->distinct()->pluck('jenis_kasus'),
            'jumlahJenis'  => Kasus::selectRaw('jenis_kasus, COUNT(*) as total')
                                   ->groupBy('jenis_kasus')
                                   ->pluck('total'),

            // Chart berdasarkan status
            'labelStatus'  => Kasus::select('status')->distinct()->pluck('status'),
            'jumlahStatus' => Kasus::selectRaw('status, COUNT(*) as total')
                                   ->groupBy('status')
                                   ->pluck('total'),

            // Chart per tahun
            'tahunLabel'   => Kasus::selectRaw('YEAR(created_at) as tahun')->distinct()->pluck('tahun'),
            'tahunJumlah'  => Kasus::selectRaw('YEAR(created_at) as tahun, COUNT(*) as total')
                                   ->groupBy('tahun')
                                   ->pluck('total'),

            // Chart kategori bukti
            'buktiLabel'   => Bukti::select('kategori')->distinct()->pluck('kategori'),
            'buktiJumlah'  => Bukti::selectRaw('kategori, COUNT(*) as total')
                                   ->groupBy('kategori')
                                   ->pluck('total'),
        ]);
    }
}