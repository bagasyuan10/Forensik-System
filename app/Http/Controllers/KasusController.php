<?php

namespace App\Http\Controllers;

use App\Models\Kasus;
use Illuminate\Http\Request;

class KasusController extends Controller
{
    // List semua kasus
    public function index()
    {
        $kasus = Kasus::latest()->paginate(9);
        return view('kasus.index', compact('kasus'));
    }

    // FORM TAMBAH KASUS
    public function create()
    {
        return view('kasus.create');
    }

    // PROSES SIMPAN KASUS
    public function store(Request $request)
    {
        $request->validate([
            'judul'       => 'required|string|max:255',
            'nomor_kasus' => 'required|string|unique:kasus',
            'lokasi'      => 'nullable|string|max:255',
            'deskripsi'   => 'nullable|string',
        ]);

        Kasus::create($request->all());

        return redirect()->route('kasus.index')
                         ->with('success', 'Kasus berhasil dibuat!');
    }

    // DETAIL
    public function show($id)
    {
        $kasus = Kasus::findOrFail($id);
        return view('kasus.show', compact('kasus'));
    }

    // FORM EDIT
    public function edit($id)
    {
        $kasus = Kasus::findOrFail($id);
        return view('kasus.edit', compact('kasus'));
    }

    // PROSES UPDATE
    public function update(Request $request, $id)
    {
        $kasus = Kasus::findOrFail($id);

        $request->validate([
            'judul'       => 'required|string|max:255',
            'nomor_kasus' => "required|string|unique:kasus,nomor_kasus,{$id}",
            'lokasi'      => 'nullable|string|max:255',
            'deskripsi'   => 'nullable|string',
        ]);

        $kasus->update($request->all());

        return redirect()->route('kasus.index')
                         ->with('success', 'Kasus berhasil diperbarui!');
    }

    // HAPUS
    public function destroy($id)
    {
        $kasus = Kasus::findOrFail($id);
        $kasus->delete();

        return redirect()->route('kasus.index')
                         ->with('success', 'Kasus berhasil dihapus');
    }
}