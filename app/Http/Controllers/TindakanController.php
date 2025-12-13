<?php

namespace App\Http\Controllers;

use App\Models\Tindakan;
use App\Models\Kasus;
use Illuminate\Http\Request;

class TindakanController extends Controller
{
    // --- INDEX (Daftar Tindakan) ---
    public function index(Request $request)
    {
        $query = Tindakan::with('kasus')->latest();

        // Fitur Pencarian (Opsional tapi berguna)
        if ($request->has('q')) {
            $query->where('judul_tindakan', 'like', '%' . $request->q . '%')
                  ->orWhere('petugas', 'like', '%' . $request->q . '%');
        }

        $tindakan = $query->paginate(10);
        return view('tindakan.index', compact('tindakan'));
    }

    // --- CREATE (Form Tambah) ---
    public function create()
    {
        $kasus = Kasus::all();
        return view('tindakan.create', compact('kasus'));
    }

    // --- STORE (Simpan Data) ---
    public function store(Request $request)
    {
        // Validasi input agar tidak error database
        $request->validate([
            'kasus_id'       => 'required|exists:kasus,id',
            'judul_tindakan' => 'required|string|max:255',
            'deskripsi'      => 'nullable|string',
            'waktu_tindakan' => 'nullable|date',
            'petugas'        => 'nullable|string|max:255',
        ]);

        Tindakan::create($request->all());

        return redirect()->route('tindakan.index')
                         ->with('success', 'Tindakan berhasil ditambahkan.');
    }

    // --- EDIT (Form Edit) ---
    public function edit($id)
    {
        $tindakan = Tindakan::findOrFail($id);
        $kasus = Kasus::all();
        return view('tindakan.edit', compact('tindakan', 'kasus'));
    }

    // --- UPDATE (Simpan Perubahan) ---
    public function update(Request $request, $id)
    {
        $tindakan = Tindakan::findOrFail($id);

        $request->validate([
            'kasus_id'       => 'required|exists:kasus,id',
            'judul_tindakan' => 'required|string|max:255',
            'deskripsi'      => 'nullable|string',
            'waktu_tindakan' => 'nullable|date',
            'petugas'        => 'nullable|string|max:255',
        ]);

        $tindakan->update($request->all());

        return redirect()->route('tindakan.index')
                         ->with('success', 'Tindakan berhasil diperbarui.');
    }

    // --- DESTROY (Hapus Data) ---
    public function destroy($id)
    {
        $tindakan = Tindakan::findOrFail($id);
        $tindakan->delete();

        return redirect()->route('tindakan.index')
                         ->with('success', 'Tindakan berhasil dihapus.');
    }
}