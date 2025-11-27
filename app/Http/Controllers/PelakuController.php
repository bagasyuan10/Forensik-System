<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelaku;
use App\Models\Kasus;
use App\Models\Bukti;

class PelakuController extends Controller
{
    public function index()
    {
        $pelaku = Pelaku::with('kasus')->latest()->paginate(10);
        return view('pelaku.index', compact('pelaku'));
    }

    public function create()
    {
        $kasus = Kasus::all();
        $barangBukti = Bukti::all(); // ← FIX PENTING

        return view('pelaku.create', compact('kasus', 'barangBukti'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kasus_id' => 'required|exists:kasus,id',
            'nama' => 'required|string|max:255',
            'status_hukum' => 'required|string',
            'foto' => 'image|mimes:jpg,png,jpeg,webp|max:2048'
        ]);

        // Upload Foto
        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('pelaku', 'public');
        }

        // Create Pelaku
        $pelaku = Pelaku::create([
            'kasus_id'        => $request->kasus_id,
            'nama'            => $request->nama,
            'foto'            => $foto,
            'biodata'         => $request->biodata,
            'hubungan_korban' => $request->hubungan_korban,
            'peran'           => $request->peran,
            'pengakuan'       => $request->pengakuan,
            'status_hukum'    => $request->status_hukum
        ]);

        // Jika pelaku punya barang bukti terkait
        if ($request->barang_bukti_id) {
            $pelaku->barangBukti()->sync($request->barang_bukti_id);
        }

        return redirect()->route('pelaku.index')
                         ->with('success', 'Pelaku berhasil ditambahkan!');
    }

    public function show($id)
    {
        $pelaku = Pelaku::with(['kasus', 'barangBukti'])->findOrFail($id);
        return view('pelaku.show', compact('pelaku'));
    }

    public function edit($id)
    {
        $pelaku = Pelaku::findOrFail($id);
        $kasus = Kasus::all();
        $barangBukti = Bukti::all();

        return view('pelaku.edit', compact('pelaku', 'kasus', 'barangBukti'));
    }

    public function update(Request $request, $id)
    {
        $pelaku = Pelaku::findOrFail($id);

        $request->validate([
            'kasus_id' => 'required|exists:kasus,id',
            'nama' => 'required|string|max:255',
            'status_hukum' => 'required|string',
            'foto' => 'image|mimes:jpg,png,jpeg,webp|max:2048'
        ]);

        // Update foto jika ada
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('pelaku', 'public');
        } else {
            $foto = $pelaku->foto;
        }

        $pelaku->update([
            'kasus_id'        => $request->kasus_id,
            'nama'            => $request->nama,
            'foto'            => $foto,
            'biodata'         => $request->biodata,
            'hubungan_korban' => $request->hubungan_korban,
            'peran'           => $request->peran,
            'pengakuan'       => $request->pengakuan,
            'status_hukum'    => $request->status_hukum
        ]);

        // Update relasi barang bukti
        if ($request->barang_bukti_id) {
            $pelaku->barangBukti()->sync($request->barang_bukti_id);
        }

        return redirect()->route('pelaku.index')
                         ->with('success', 'Data pelaku berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Pelaku::findOrFail($id)->delete();

        return redirect()->route('pelaku.index')
                         ->with('success', 'Pelaku berhasil dihapus!');
    }
}