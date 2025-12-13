<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelaku;
use App\Models\Kasus;
use App\Models\Bukti;
use Illuminate\Support\Facades\Storage; 

class PelakuController extends Controller
{
    // --- 1. INDEX (Daftar Pelaku) ---
    public function index()
    {
        $pelaku = Pelaku::with('kasus')->latest()->paginate(10);
        return view('pelaku.index', compact('pelaku'));
    }

    // --- 2. CREATE (Form Tambah) ---
    public function create()
    {
        $kasus = Kasus::all();
        $barangBukti = Bukti::all(); // Diperlukan untuk dropdown barang bukti
        return view('pelaku.create', compact('kasus', 'barangBukti'));
    }

    // --- 3. STORE (Simpan Data Baru) ---
    public function store(Request $request)
    {
        $request->validate([
            'kasus_id' => 'required|exists:kasus,id',
            'nama' => 'required|string|max:255',
            'status_hukum' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048',
            'barang_bukti_id' => 'nullable|exists:bukti,id'
        ]);

        // Upload Foto
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pelaku_photos', 'public');
        }

        // Simpan Data Utama
        $pelaku = Pelaku::create([
            'kasus_id'        => $request->kasus_id,
            'nama'            => $request->nama,
            'foto'            => $fotoPath,
            'biodata'         => $request->biodata,
            'hubungan_korban' => $request->hubungan_korban,
            'peran'           => $request->peran,
            'pengakuan'       => $request->pengakuan,
            'status_hukum'    => $request->status_hukum
        ]);

        // Simpan Relasi Bukti (Jika ada)
        if ($request->filled('barang_bukti_id')) {
            $pelaku->barangBukti()->attach($request->barang_bukti_id);
        }

        return redirect()->route('pelaku.index')->with('success', 'Pelaku berhasil ditambahkan!');
    }

    // --- 4. SHOW (Detail Pelaku) ---
    public function show($id)
    {
        $pelaku = Pelaku::with(['kasus', 'barangBukti'])->findOrFail($id);
        return view('pelaku.show', compact('pelaku'));
    }

    // --- 5. EDIT (Form Edit - INI YANG TADI ERROR) ---
    public function edit($id)
    {
        $pelaku = Pelaku::with('barangBukti')->findOrFail($id);
        $kasus = Kasus::all();       // Data untuk dropdown kasus
        $barangBukti = Bukti::all(); // Data untuk dropdown bukti

        return view('pelaku.edit', compact('pelaku', 'kasus', 'barangBukti'));
    }

    // --- 6. UPDATE (Simpan Perubahan) ---
    public function update(Request $request, $id)
    {
        $pelaku = Pelaku::findOrFail($id);

        $request->validate([
            'kasus_id' => 'required|exists:kasus,id',
            'nama' => 'required|string|max:255',
            'status_hukum' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048'
        ]);

        // Handle Foto Update
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($pelaku->foto) {
                Storage::disk('public')->delete($pelaku->foto);
            }
            $fotoPath = $request->file('foto')->store('pelaku_photos', 'public');
        } else {
            $fotoPath = $pelaku->foto;
        }

        // Update Data Utama
        $pelaku->update([
            'kasus_id'        => $request->kasus_id,
            'nama'            => $request->nama,
            'foto'            => $fotoPath,
            'biodata'         => $request->biodata,
            'hubungan_korban' => $request->hubungan_korban,
            'peran'           => $request->peran,
            'pengakuan'       => $request->pengakuan,
            'status_hukum'    => $request->status_hukum
        ]);

        // Update Relasi Bukti
        if ($request->filled('barang_bukti_id')) {
            // Sync akan menghapus relasi lama dan mengganti dengan yang baru
            $pelaku->barangBukti()->sync([$request->barang_bukti_id]);
        } else {
            // Jika user memilih "Tidak Ada", hapus semua relasi bukti
            $pelaku->barangBukti()->detach();
        }

        return redirect()->route('pelaku.index')->with('success', 'Data pelaku berhasil diperbarui!');
    }

    // --- 7. DESTROY (Hapus Data) ---
    public function destroy($id)
    {
        $pelaku = Pelaku::findOrFail($id);
        
        // Hapus foto dari storage
        if ($pelaku->foto) {
            Storage::disk('public')->delete($pelaku->foto);
        }
        
        $pelaku->delete();

        return redirect()->route('pelaku.index')->with('success', 'Pelaku berhasil dihapus!');
    }
}