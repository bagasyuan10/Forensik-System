<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Kasus;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $laporan = Laporan::latest()->paginate(10);
        return view('laporan.index', compact('laporan'));
    }

    public function create()
    {
        $kasus = Kasus::all();
        return view('laporan.create', compact('kasus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kasus_id' => 'required|exists:kasus,id',
            'judul_laporan' => 'required',
            'isi_laporan' => 'required',
        ]);

        Laporan::create($request->all());

        return redirect()->route('laporan.index')
                         ->with('success', 'Laporan berhasil ditambahkan');
    }

    public function edit(Laporan $laporan)
    {
        $kasus = Kasus::all();
        return view('laporan.edit', compact('laporan', 'kasus'));
    }

    public function update(Request $request, Laporan $laporan)
    {
        $request->validate([
            'kasus_id' => 'required|exists:kasus,id',
            'judul_laporan' => 'required',
            'isi_laporan' => 'required'
        ]);

        $laporan->update($request->all());

        return redirect()->route('laporan.index')
                         ->with('success', 'Laporan berhasil diperbarui');
    }

    public function destroy(Laporan $laporan)
    {
        $laporan->delete();

        return redirect()->route('laporan.index')
                         ->with('success', 'Laporan berhasil dihapus');
    }
}