<?php

namespace App\Http\Controllers;

use App\Models\Bukti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BuktiController extends Controller
{
    public function index(Request $request)
    {
        $query = Bukti::query();

        if ($request->search) {
            $query->where('nama_bukti', 'like', "%{$request->search}%")
                  ->orWhere('deskripsi', 'like', "%{$request->search}%")
                  ->orWhere('file_name', 'like', "%{$request->search}%");
        }

        if ($request->filter === "image") {
            $query->where('file_type', 'like', 'image/%');
        }

        if ($request->filter === "pdf") {
            $query->where('file_type', 'application/pdf');
        }

        $bukti = $query->orderBy('created_at', 'desc')->paginate(8);

        return view('bukti.index', compact('bukti'));
    }

    public function create()
    {
        return view('bukti.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bukti' => 'required',
            'deskripsi' => 'nullable',
            'file' => 'required|file|max:50000'
        ]);

        $file = $request->file('file');
        $path = $file->store('uploads/bukti', 'public');

        Bukti::create([
            'nama_bukti' => $request->nama_bukti,
            'deskripsi' => $request->deskripsi,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'file_type' => $file->getMimeType(),
            'file_path' => $path,
        ]);

        return redirect()->route('bukti.index')->with('success', 'Bukti berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $bukti = Bukti::findOrFail($id);
        return view('bukti.edit', compact('bukti'));
    }

    public function update(Request $request, $id)
    {
        $bukti = Bukti::findOrFail($id);

        $bukti->update($request->only(['nama_bukti', 'deskripsi']));

        return redirect()->route('bukti.index')->with('success', 'Bukti diperbarui.');
    }

    public function destroy($id)
    {
        $bukti = Bukti::findOrFail($id);

        Storage::disk('public')->delete($bukti->file_path);

        $bukti->delete();

        return redirect()->route('bukti.index')->with('success', 'Bukti dihapus.');
    }
}