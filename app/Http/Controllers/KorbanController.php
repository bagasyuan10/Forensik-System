<?php

namespace App\Http\Controllers;

use App\Models\Korban;
use Illuminate\Http\Request;

class KorbanController extends Controller
{
    public function index()
    {
        $data = Korban::all();
        return view('korban.index', compact('data'));
    }

    public function create()
    {
        return view('korban.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
        ]);

        Korban::create($request->all());

        return redirect()->route('korban.index')
                         ->with('success', 'Korban berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $korban = Korban::findOrFail($id);
        return view('korban.edit', compact('korban'));
    }

    public function update(Request $request, $id)
    {
        $korban = Korban::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
        ]);

        $korban->update($request->all());

        return redirect()->route('korban.index')->with('success', 'Data korban berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Korban::destroy($id);

        return redirect()->route('korban.index')
                         ->with('success', 'Korban berhasil dihapus.');
    }
}
