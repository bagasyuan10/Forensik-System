<?php

namespace App\Http\Controllers;

use App\Models\Tindakan;
use App\Models\Kasus;
use Illuminate\Http\Request;

class TindakanController extends Controller
{
    public function index()
    {
        $tindakan = Tindakan::with('kasus')->latest()->paginate(10);
        return view('tindakan.index', compact('tindakan'));
    }

    public function create()
    {
        $kasus = Kasus::all();
        return view('tindakan.create', compact('kasus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kasus_id' => 'required|exists:kasus,id',
            'judul_tindakan' => 'required',
        ]);

        Tindakan::create([
            'kasus_id' => $request->kasus_id,
            'judul_tindakan' => $request->judul_tindakan,
            'deskripsi' => $request->deskripsi,
            'waktu_tindakan' => $request->waktu_tindakan,
            'petugas' => $request->petugas,
        ]);

        return redirect()->route('tindakan.index')
                         ->with('success', 'Tindakan berhasil ditambahkan');
    }

    public function edit(Tindakan $tindakan)
    {
        $kasus = \App\Models\Kasus::all();
        return view('tindakan.edit', compact('tindakan', 'kasus'));
    }

    public function update(Request $request, Tindakan $tindakan)
    {
        $request->validate([
            'kasus_id' => 'required|exists:kasus,id',
            'judul_tindakan' => 'required',
        ]);

        $tindakan->update([
            'kasus_id' => $request->kasus_id,
            'judul_tindakan' => $request->judul_tindakan,
            'deskripsi' => $request->deskripsi,
            'waktu_tindakan' => $request->waktu_tindakan,
            'petugas' => $request->petugas,
        ]);

        return redirect()->route('tindakan.index')
                         ->with('success', 'Tindakan berhasil diperbarui');
    }

    public function destroy(Tindakan $tindakan)
    {
        $tindakan->delete();

        return redirect()->route('tindakan.index')
                         ->with('success', 'Tindakan berhasil dihapus');
    }
}