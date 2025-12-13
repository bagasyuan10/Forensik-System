<?php

namespace App\Http\Controllers;

use App\Models\Bukti;
use App\Models\Kasus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BuktiController extends Controller
{
    // --- 1. INDEX (Daftar Bukti) ---
    public function index(Request $request)
    {
        $query = Bukti::with('kasus')->latest();

        // Pencarian
        if ($request->has('search')) {
            $query->where('nama_bukti', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
        }

        // Filter Tipe File
        if ($request->has('filter') && $request->filter != 'all') {
            if ($request->filter == 'image') {
                $query->where('file_type', 'like', 'image/%');
            } elseif ($request->filter == 'pdf') {
                $query->where('file_type', 'application/pdf');
            }
        }

        $bukti = $query->paginate(12);
        return view('bukti.index', compact('bukti'));
    }

    // --- 2. CREATE (Form Tambah) ---
    public function create()
    {
        $kasus = Kasus::all();
        return view('bukti.create', compact('kasus'));
    }

    // --- 3. STORE (Simpan Data Baru) ---
    public function store(Request $request)
    {
        $request->validate([
            'kasus_id'          => 'required|exists:kasus,id',
            'nama_bukti'        => 'required|string|max:255',
            'kategori'          => 'required|string',
            'foto'              => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240', // Max 10MB
            'deskripsi'         => 'nullable|string',
            'lokasi_ditemukan'  => 'nullable|string',
            'waktu_ditemukan'   => 'nullable|date',
            'petugas_menemukan' => 'nullable|string'
        ]);

        $data = [
            'kasus_id'          => $request->kasus_id,
            'nama_bukti'        => $request->nama_bukti,
            'kategori'          => $request->kategori,
            'deskripsi'         => $request->deskripsi,
            'lokasi_ditemukan'  => $request->lokasi_ditemukan,
            'waktu_ditemukan'   => $request->waktu_ditemukan,
            'petugas_menemukan' => $request->petugas_menemukan,
        ];

        // Upload File Baru
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $path = $file->store('bukti_files', 'public');

            $data['file_path'] = $path;
            $data['file_type'] = $file->getMimeType();
            $data['file_size'] = $file->getSize();
        }

        Bukti::create($data);

        return redirect()->route('bukti.index')->with('success', 'Barang bukti berhasil ditambahkan.');
    }

    // --- 4. EDIT (Form Edit) ---
    public function edit($id)
    {
        $bukti = Bukti::findOrFail($id);
        $kasus = Kasus::all();
        return view('bukti.edit', compact('bukti', 'kasus'));
    }

    // --- 5. UPDATE (Simpan Perubahan) ---
    public function update(Request $request, $id)
    {
        $bukti = Bukti::findOrFail($id);

        $request->validate([
            'kasus_id'          => 'required|exists:kasus,id',
            'nama_bukti'        => 'required|string|max:255',
            'kategori'          => 'required|string',
            'foto'              => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'deskripsi'         => 'nullable|string',
            'lokasi_ditemukan'  => 'nullable|string',
            'waktu_ditemukan'   => 'nullable|date',
            'petugas_menemukan' => 'nullable|string'
        ]);

        $data = [
            'kasus_id'          => $request->kasus_id,
            'nama_bukti'        => $request->nama_bukti,
            'kategori'          => $request->kategori,
            'deskripsi'         => $request->deskripsi,
            'lokasi_ditemukan'  => $request->lokasi_ditemukan,
            'waktu_ditemukan'   => $request->waktu_ditemukan,
            'petugas_menemukan' => $request->petugas_menemukan,
        ];

        // Cek jika ada upload file baru
        if ($request->hasFile('foto')) {
            // Hapus file lama fisik
            if ($bukti->file_path && Storage::disk('public')->exists($bukti->file_path)) {
                Storage::disk('public')->delete($bukti->file_path);
            }

            // Simpan file baru
            $file = $request->file('foto');
            $path = $file->store('bukti_files', 'public');

            $data['file_path'] = $path;
            $data['file_type'] = $file->getMimeType();
            $data['file_size'] = $file->getSize();
        }

        $bukti->update($data);

        return redirect()->route('bukti.index')->with('success', 'Data bukti berhasil diperbarui.');
    }

    // --- 6. DESTROY (Hapus Data & File) ---
    public function destroy($id)
    {
        $bukti = Bukti::findOrFail($id);

        // Hapus file fisik
        if ($bukti->file_path && Storage::disk('public')->exists($bukti->file_path)) {
            Storage::disk('public')->delete($bukti->file_path);
        }

        $bukti->delete();

        return redirect()->route('bukti.index')->with('success', 'Barang bukti berhasil dihapus.');
    }
}