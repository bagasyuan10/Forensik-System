<?php

namespace App\Http\Controllers;

use App\Models\Bukti;
use App\Models\Kasus;
use Illuminate\Http\Request;

class BuktiController extends Controller
{
    public function index()
    {
        $bukti = Bukti::with('kasus')->latest()->paginate(10);
        return view('bukti.index', compact('bukti'));
    }

    public function create()
    {
        $kasus = Kasus::all(); // supaya dropdown kasus muncul
        return view('bukti.create', compact('kasus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kasus_id'          => 'required|exists:kasus,id',
            'kategori'          => 'required',
            'nama_bukti'        => 'required',
            'foto'              => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'deskripsi'         => 'nullable',
            'lokasi_ditemukan'  => 'nullable|string',
            'waktu_ditemukan'   => 'nullable|date',
            'petugas_menemukan' => 'nullable|string'
        ]);

        $data = $request->all();

        // Upload file
        if ($request->hasFile('foto')) {
            $fileName = time() . '_' . $request->foto->getClientOriginalName();
            $request->foto->move(public_path('uploads/bukti'), $fileName);
            $data['foto'] = $fileName;
        }

        Bukti::create($data);

        return redirect()
            ->route('bukti.index')
            ->with('success', 'Barang bukti berhasil ditambahkan.');
    }

    public function edit(Bukti $bukti)
    {
        $kasus = Kasus::all();
        return view('bukti.edit', compact('bukti', 'kasus'));
    }

    public function update(Request $request, Bukti $bukti)
    {
        $request->validate([
            'kasus_id'          => 'required|exists:kasus,id',
            'kategori'          => 'required',
            'nama_bukti'        => 'required',
            'foto'              => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'deskripsi'         => 'nullable',
            'lokasi_ditemukan'  => 'nullable|string',
            'waktu_ditemukan'   => 'nullable|date',
            'petugas_menemukan' => 'nullable|string'
        ]);

        $data = $request->all();

        // Upload file baru (jika ada)
        if ($request->hasFile('foto')) {
            $fileName = time() . '_' . $request->foto->getClientOriginalName();
            $request->foto->move(public_path('uploads/bukti'), $fileName);
            $data['foto'] = $fileName;
        }

        $bukti->update($data);

        return redirect()
            ->route('bukti.index')
            ->with('success', 'Data bukti berhasil diperbarui.');
    }

    public function destroy(Bukti $bukti)
    {
        $bukti->delete();
        return redirect()
            ->route('bukti.index')
            ->with('success', 'Barang bukti berhasil dihapus.');
    }
}