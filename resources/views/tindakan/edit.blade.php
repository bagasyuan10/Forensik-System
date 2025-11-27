@extends('layouts.Layout')

@section('content')
<div class="container py-4">

    <h2 class="fw-bold mb-4">✏️ Edit Tindakan</h2>

    <div class="card p-4 shadow-sm rounded-4">

        <form action="{{ route('tindakan.update', $tindakan->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Kasus --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Pilih Kasus</label>
                <select name="kasus_id" class="form-select rounded-pill" required>
                    @foreach($kasus as $k)
                        <option value="{{ $k->id }}" {{ $k->id == $tindakan->kasus_id ? 'selected' : '' }}>
                            {{ $k->judul }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Judul tindakan --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Judul Tindakan</label>
                <input type="text" name="judul_tindakan"
                       class="form-control rounded-pill"
                       value="{{ $tindakan->judul_tindakan }}"
                       required>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="deskripsi" class="form-control rounded-4" rows="4">{{ $tindakan->deskripsi }}</textarea>
            </div>

            {{-- Waktu tindakan --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Waktu Tindakan</label>
                <input type="datetime-local" name="waktu_tindakan"
                       class="form-control rounded-pill"
                       value="{{ $tindakan->waktu_tindakan ? date('Y-m-d\TH:i', strtotime($tindakan->waktu_tindakan)) : '' }}">
            </div>

            {{-- Petugas --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Petugas / Penyidik</label>
                <input type="text" name="petugas"
                       class="form-control rounded-pill"
                       value="{{ $tindakan->petugas }}">
            </div>

            <button class="btn btn-primary rounded-pill px-4">Update</button>
            <a href="{{ route('tindakan.index') }}" class="btn btn-secondary rounded-pill px-4">Kembali</a>

        </form>

    </div>

</div>
@endsection