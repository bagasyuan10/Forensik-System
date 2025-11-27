<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Import semua model yang dipakai
use App\Models\Kasus;
use App\Models\Korban;
use App\Models\Pelaku;
use App\Models\Bukti;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            // ------- TOTAL SUMMARY -------
            'totalKasus'   => Kasus::count(),
            'totalKorban'  => Korban::count(),
            'totalPelaku'  => Pelaku::count(),
            'totalBukti'   => Bukti::count(),

            // ------- CHART: Jenis Kejahatan -------
            'labelJenis'   => Kasus::select('jenis')->distinct()->pluck('jenis'),
            'jumlahJenis'  => Kasus::select('jenis')->selectRaw('COUNT(*) as total')
                                    ->groupBy('jenis')
                                    ->pluck('total'),

            // ------- CHART: Status Kasus -------
            'labelStatus'   => Kasus::select('status')->distinct()->pluck('status'),
            'jumlahStatus'  => Kasus::select('status')->selectRaw('COUNT(*) as total')
                                      ->groupBy('status')
                                      ->pluck('total'),

            // ------- CHART: Kasus per Tahun -------
            'tahunLabel'   => Kasus::selectRaw('YEAR(created_at) as tahun')
                                    ->distinct()
                                    ->pluck('tahun'),

            'tahunJumlah'  => Kasus::selectRaw('YEAR(created_at) as tahun, COUNT(*) as total')
                                    ->groupBy('tahun')
                                    ->pluck('total'),

            // ------- CHART: Kategori Bukti -------
            'buktiLabel'   => Bukti::select('kategori')->distinct()->pluck('kategori'),
            'buktiJumlah'  => Bukti::select('kategori')->selectRaw('COUNT(*) as total')
                                         ->groupBy('kategori')
                                         ->pluck('total'),
        ]);
    }
}