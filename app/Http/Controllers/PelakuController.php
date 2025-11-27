<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelaku;
use Illuminate\Support\Facades\Storage;

class PelakuController extends Controller
{
    // =====================================================
    // INDEX
    // =====================================================
    public function index()
    {
        $pelaku = Pelaku::latest()->paginate(10);
        return view('pelaku.index', compact('pelaku'));
    }

    // =====================================================
    // CREATE
    // =====================================================
    public function create()
    {
        return view('pelaku.create');
    }

    // =====================================================
    // STORE
    // =====================================================
    public function store(Request $request)
    {
        $request->validate([
            'nama'       => 'required|string|max:255',
            'foto'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'biodata'    => 'required|string',
            'runtutan'   => 'required|string',
        ]);

        $fotoPath = null;

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pelaku', 'public');
        }

        Pelaku::create([
            'nama'       => $request->nama,
            'foto'       => $fotoPath,
            'biodata'    => $request->biodata,
            'runtutan'   => $request->runtutan,
        ]);

        return redirect()->route('pelaku.index')
            ->with('success', 'Data pelaku berhasil ditambahkan.');
    }

    // =====================================================
    // EDIT
    // =====================================================
    public function edit($id)
    {
        $pelaku = Pelaku::findOrFail($id);
        return view('pelaku.edit', compact('pelaku'));
    }

    // =====================================================
    // UPDATE
    // =====================================================
    public function update(Request $request, $id)
    {
        $pelaku = Pelaku::findOrFail($id);

        $request->validate([
            'nama'       => 'required|string|max:255',
            'foto'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'biodata'    => 'required|string',
            'runtutan'   => 'required|string',
        ]);

        $fotoPath = $pelaku->foto;

        if ($request->hasFile('foto')) {
            if ($pelaku->foto) {
                Storage::disk('public')->delete($pelaku->foto);
            }

            $fotoPath = $request->file('foto')->store('pelaku', 'public');
        }

        $pelaku->update([
            'nama'       => $request->nama,
            'foto'       => $fotoPath,
            'biodata'    => $request->biodata,
            'runtutan'   => $request->runtutan,
        ]);

        return redirect()->route('pelaku.index')
            ->with('success', 'Data pelaku berhasil diperbarui.');
    }

    // =====================================================
    // DESTROY
    // =====================================================
    public function destroy($id)
    {
        $pelaku = Pelaku::findOrFail($id);

        if ($pelaku->foto) {
            Storage::disk('public')->delete($pelaku->foto);
        }

        $pelaku->delete();

        return redirect()->route('pelaku.index')
            ->with('success', 'Data pelaku berhasil dihapus.');
    }
}