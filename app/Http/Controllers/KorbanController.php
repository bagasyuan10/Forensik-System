<?php

namespace App\Http\Controllers;

use App\Models\Korban;
use App\Models\Kasus;
use Illuminate\Http\Request;

class KorbanController extends Controller
{
    // Menampilkan daftar korban
    public function index()
    {
        $data = Korban::latest()->paginate(10);
        return view('korban.index', compact('data'));
    }

    // Menampilkan form tambah korban
    public function create()
    {
        $kasus = Kasus::all(); // diperlukan untuk dropdown kasus_id
        return view('korban.create', compact('kasus'));
    }

    // Menyimpan korban baru
    public function store(Request $request)
    {
        $request->validate([
            'kasus_id'          => 'required|exists:kasus,id',
            'nama'              => 'required|string|max:255',
            'kontak'            => 'nullable|string|max:255',
            'alamat'            => 'nullable|string',
            'umur'              => 'nullable|integer|min:0|max:150',
            'jenis_kelamin'     => 'nullable|in:L,P',
            'kondisi'           => 'nullable|string',
            'keterangan'        => 'nullable|string',
            'versi_kejadian'    => 'nullable|string',
            'foto'              => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_korban', 'public');
        }

        Korban::create($data);

        return redirect()
            ->route('korban.index')
            ->with('success', 'Data korban berhasil ditambahkan');
    }

    // Menampilkan form edit
    public function edit(Korban $korban)
    {
        $kasus = Kasus::all();
        return view('korban.edit', compact('korban', 'kasus'));
    }

    // Update data korban
    public function update(Request $request, Korban $korban)
    {
        $request->validate([
            'kasus_id'          => 'required|exists:kasus,id',
            'nama'              => 'required|string|max:255',
            'kontak'            => 'nullable|string|max:255',
            'alamat'            => 'nullable|string',
            'umur'              => 'nullable|integer|min:0|max:150',
            'jenis_kelamin'     => 'nullable|in:L,P',
            'kondisi'           => 'nullable|string',
            'keterangan'        => 'nullable|string',
            'versi_kejadian'    => 'nullable|string',
            'foto'              => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        // Update foto jika ada
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_korban', 'public');
        }

        $korban->update($data);

        return redirect()
            ->route('korban.index')
            ->with('success', 'Data korban berhasil diperbarui');
    }

    // Hapus korban
    public function destroy(Korban $korban)
    {
        $korban->delete();
        return redirect()
            ->route('korban.index')
            ->with('success', 'Data korban berhasil dihapus');
    }
}