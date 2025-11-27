<?php

namespace App\Http\Controllers;

use App\Models\Kasus;
use Illuminate\Http\Request;

class KasusController extends Controller
{
    public function index()
    {
        $kasus = Kasus::all();
        return view('kasus.index', compact('kasus'));
    }

    public function create()
    {
        // Tidak pakai model JenisKasus
        $jenisKasus = ['Kriminal', 'Cybercrime', 'Kekerasan', 'Lainnya'];
        return view('kasus.create', compact('jenisKasus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'        => 'required|string',
            'nomor_kasus'  => 'required|string|unique:kasus',
            'jenis'        => 'required|string',
            'lokasi'       => 'nullable|string',
            'tanggal'      => 'nullable|date',
            'deskripsi'    => 'nullable|string',
        ]);

        Kasus::create($validated);

        return redirect()->route('kasus.index')->with('success', 'Kasus berhasil ditambahkan');
    }

    public function show(Kasus $kasu)
    {
        return view('kasus.show', compact('kasu'));
    }

    public function edit(Kasus $kasu)
    {
        $jenisKasus = ['Kriminal', 'Cybercrime', 'Kekerasan', 'Lainnya'];
        return view('kasus.edit', compact('kasu', 'jenisKasus'));
    }

    public function update(Request $request, Kasus $kasu)
    {
        $validated = $request->validate([
            'judul'        => 'required|string',
            'nomor_kasus'  => 'required|string|unique:kasus,nomor_kasus,' . $kasu->id,
            'jenis'        => 'required|string',
            'lokasi'       => 'nullable|string',
            'tanggal'      => 'nullable|date',
            'deskripsi'    => 'nullable|string',
        ]);

        $kasu->update($validated);

        return redirect()->route('kasus.index')->with('success', 'Kasus berhasil diperbarui');
    }

    public function destroy(Kasus $kasu)
    {
        $kasu->delete();
        return redirect()->route('kasus.index')->with('success', 'Kasus berhasil dihapus');
    }
}