<?php

namespace App\Http\Controllers;

use App\Models\Korban;
use App\Models\Kasus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KorbanController extends Controller
{
    public function index(Request $request)
    {
        $query = Korban::with('kasus')->latest();

        // Update pencarian agar sesuai kolom baru
        if ($request->has('q')) {
            $query->where('nama', 'like', '%' . $request->q . '%')
                  ->orWhere('nik', 'like', '%' . $request->q . '%');
        }

        $data = $query->paginate(10);
        return view('korban.index', compact('data'));
    }

    public function create()
    {
        $kasus = Kasus::all();
        return view('korban.create', compact('kasus'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input sesuai Form View
        $validatedData = $request->validate([
            'kasus_id'        => 'required|exists:kasus,id',
            'nik'             => 'nullable|numeric|digits:16', // Validasi NIK
            'nama'            => 'required|string|max:255',
            'tempat_lahir'    => 'nullable|string|max:100',
            'tanggal_lahir'   => 'nullable|date',
            'jenis_kelamin'   => 'nullable|string',
            'no_telp'         => 'nullable|string|max:20',     // Sesuaikan dengan name="no_telp"
            'alamat'          => 'nullable|string',
            'status_korban'   => 'required|string',            // Wajib diisi sesuai dropdown
            'keterangan_luka' => 'nullable|string',            // Sesuaikan dengan name="keterangan_luka"
            'versi_kejadian'  => 'nullable|string',
            'foto'            => 'nullable|image|max:2048',
        ]);

        // 2. Handle Upload Foto
        if ($request->hasFile('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('korban_photos', 'public');
        }

        // 3. Simpan ke Database
        Korban::create($validatedData);

        return redirect()->route('korban.index')->with('success', 'Data korban berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $korban = Korban::findOrFail($id);
        $kasus = Kasus::all();
        return view('korban.edit', compact('korban', 'kasus'));
    }

    public function update(Request $request, $id)
    {
        $korban = Korban::findOrFail($id);

        // 1. Validasi Update
        $validatedData = $request->validate([
            'kasus_id'        => 'required|exists:kasus,id',
            'nik'             => 'nullable|numeric|digits:16',
            'nama'            => 'required|string|max:255',
            'tempat_lahir'    => 'nullable|string|max:100',
            'tanggal_lahir'   => 'nullable|date',
            'jenis_kelamin'   => 'nullable|string',
            'no_telp'         => 'nullable|string|max:20',
            'alamat'          => 'nullable|string',
            'status_korban'   => 'required|string',
            'keterangan_luka' => 'nullable|string',
            'versi_kejadian'  => 'nullable|string',
            'foto'            => 'nullable|image|max:2048',
        ]);

        // 2. Handle Update Foto
        if ($request->hasFile('foto')) {
            if ($korban->foto && Storage::disk('public')->exists($korban->foto)) {
                Storage::disk('public')->delete($korban->foto);
            }
            $validatedData['foto'] = $request->file('foto')->store('korban_photos', 'public');
        }

        // 3. Update Data
        $korban->update($validatedData);

        return redirect()->route('korban.index')->with('success', 'Data korban berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $korban = Korban::findOrFail($id);
        if ($korban->foto && Storage::disk('public')->exists($korban->foto)) {
            Storage::disk('public')->delete($korban->foto);
        }
        $korban->delete();
        return redirect()->route('korban.index')->with('success', 'Data korban berhasil dihapus.');
    }
}