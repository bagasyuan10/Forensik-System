<?php

namespace App\Http\Controllers;

use App\Models\Kasus;
use Illuminate\Http\Request;

class KasusController extends Controller
{
    public function index(Request $request)
    {
        // Fitur Search & Filter (Sesuai View Index Anda)
        $query = Kasus::query();

        // 1. Pencarian (Judul, No Kasus, Lokasi)
        if ($request->has('q') && $request->q != '') {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('judul', 'like', "%{$q}%")
                    ->orWhere('nomor_kasus', 'like', "%{$q}%")
                    ->orWhere('lokasi', 'like', "%{$q}%");
            });
        }

        // 2. Filter (Contoh: Dengan Bukti)
        if ($request->has('filter') && $request->filter == 'withBukti') {
            $query->has('bukti'); // Hanya ambil kasus yang punya relasi bukti
        }

        // Ambil data terbaru dulu
        $kasus = $query->latest()->paginate(9)->withQueryString();

        return view('kasus.index', compact('kasus'));
    }

    public function create()
    {
        $jenisKasus = ['Kriminal', 'Cybercrime', 'Kekerasan', 'Narkotika', 'Pencurian', 'Lainnya'];
        return view('kasus.create', compact('jenisKasus'));
    }

    public function store(Request $request)
    {
        // Validasi Input Sesuai Form Create Blade Anda
        $validated = $request->validate([
            'judul_kasus'      => 'required|string|max:255', // Di form name="judul_kasus"
            'nomor_kasus'      => 'required|string|unique:kasus,nomor_kasus',
            'jenis_kasus_id'   => 'required|string', // Di form name="jenis_kasus_id"
            'status'           => 'required|string',
            'tanggal_kejadian' => 'required|date',
            'lokasi_kejadian'  => 'nullable|string', // Di form name="lokasi_kejadian"
            'kronologi'        => 'nullable|string', // Di form name="kronologi"
            'penyidik'         => 'nullable|string',
        ]);

        // Mapping nama input form ke nama kolom database
        Kasus::create([
            'judul'            => $validated['judul_kasus'],
            'nomor_kasus'      => $validated['nomor_kasus'],
            'jenis_kasus'      => $validated['jenis_kasus_id'],
            'status'           => $validated['status'],
            'tanggal_kejadian' => $validated['tanggal_kejadian'],
            'lokasi'           => $validated['lokasi_kejadian'],
            'deskripsi'        => $validated['kronologi'],
            'penyidik'         => $validated['penyidik'],
        ]);

        return redirect()->route('kasus.index')->with('success', 'Kasus berhasil ditambahkan');
    }

    public function show($id)
    {
        $kasus = Kasus::with(['pelaku', 'korban', 'bukti'])->findOrFail($id);
        return view('kasus.show', compact('kasus'));
    }

    public function edit($id)
    {
        $kasus = Kasus::findOrFail($id);
        $jenisKasus = ['Kriminal', 'Cybercrime', 'Kekerasan', 'Narkotika', 'Pencurian', 'Lainnya'];
        return view('kasus.edit', compact('kasus', 'jenisKasus'));
    }

    public function update(Request $request, $id)
    {
        $kasus = Kasus::findOrFail($id);

        $validated = $request->validate([
            'judul_kasus'      => 'required|string|max:255',
            'nomor_kasus'      => 'required|string|unique:kasus,nomor_kasus,' . $id,
            'jenis_kasus_id'   => 'required|string',
            'status'           => 'required|string',
            'tanggal_kejadian' => 'required|date',
            'lokasi_kejadian'  => 'nullable|string',
            'kronologi'        => 'nullable|string',
            'penyidik'         => 'nullable|string',
        ]);

        $kasus->update([
            'judul'            => $validated['judul_kasus'],
            'nomor_kasus'      => $validated['nomor_kasus'],
            'jenis_kasus'      => $validated['jenis_kasus_id'],
            'status'           => $validated['status'],
            'tanggal_kejadian' => $validated['tanggal_kejadian'],
            'lokasi'           => $validated['lokasi_kejadian'],
            'deskripsi'        => $validated['kronologi'],
            'penyidik'         => $validated['penyidik'],
        ]);

        return redirect()->route('kasus.index')->with('success', 'Kasus berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kasus = Kasus::findOrFail($id);
        $kasus->delete();
        return redirect()->route('kasus.index')->with('success', 'Kasus berhasil dihapus');
    }
}