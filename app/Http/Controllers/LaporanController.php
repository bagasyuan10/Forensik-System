<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Kasus;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Laporan::with('kasus')->latest();

        if ($request->has('q')) {
            $query->where('judul_laporan', 'like', '%' . $request->q . '%')
                  ->orWhere('penyusun', 'like', '%' . $request->q . '%');
        }

        $laporan = $query->paginate(10);
        return view('laporan.index', compact('laporan'));
    }

    public function create()
    {
        $kasus = Kasus::all();
        return view('laporan.create', compact('kasus'));
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'kasus_id'        => 'nullable|exists:kasus,id',
            'judul_laporan'   => 'required|string|max:255',
            'isi_laporan'     => 'required|string',
            'tanggal_laporan' => 'nullable|date',
            'penyusun'        => 'nullable|string|max:255',
        ]);

        // 2. Simpan Data
        Laporan::create($request->all());

        // 3. LOGIKA REDIRECT (PENTING)
        // Cek apakah ada input hidden bernama 'is_public' (dari form welcome.blade.php)
        if ($request->has('is_public')) {
            // Jika masyarakat yang input, kembalikan ke halaman depan
            return redirect()->to('/') 
                             ->with('success', 'Terima kasih! Laporan Anda berhasil dikirim dan akan segera kami tindaklanjuti.');
        }

        // Jika Admin yang input dari dashboard, kembalikan ke tabel index
        return redirect()->route('laporan.index')
                         ->with('success', 'Aduan warga berhasil disimpan.');
    }

    public function edit($id)
    {
        $laporan = Laporan::findOrFail($id);
        $kasus = Kasus::all();
        return view('laporan.edit', compact('laporan', 'kasus'));
    }

    public function update(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        $request->validate([
            'kasus_id'        => 'nullable|exists:kasus,id',
            'judul_laporan'   => 'required|string|max:255',
            'isi_laporan'     => 'required|string',
            'tanggal_laporan' => 'nullable|date',
            'penyusun'        => 'nullable|string|max:255',
        ]);

        $laporan->update($request->all());

        return redirect()->route('laporan.index')
                         ->with('success', 'Data aduan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->delete();

        return redirect()->route('laporan.index')
                         ->with('success', 'Laporan berhasil dihapus.');
    }
}