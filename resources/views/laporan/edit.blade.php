@extends('layouts.layout')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Laporan</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('laporan.update', $laporan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="kasus_id" class="form-label">Kasus</label>
            <select name="kasus_id" id="kasus_id" class="form-select" required>
                <option value="">-- Pilih Kasus --</option>
                @foreach($kasus as $k)
                    <option value="{{ $k->id }}" {{ $laporan->kasus_id == $k->id ? 'selected' : '' }}>{{ $k->judul }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="judul_laporan" class="form-label">Judul Laporan</label>
            <input type="text" name="judul_laporan" class="form-control" value="{{ old('judul_laporan', $laporan->judul_laporan) }}" required>
        </div>

        <div class="mb-3">
            <label for="isi_laporan" class="form-label">Isi Laporan</label>
            <textarea name="isi_laporan" class="form-control" rows="5" required>{{ old('isi_laporan', $laporan->isi_laporan) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="tanggal_laporan" class="form-label">Tanggal Laporan</label>
            <input type="date" name="tanggal_laporan" class="form-control" value="{{ old('tanggal_laporan', $laporan->tanggal_laporan) }}">
        </div>

        <div class="mb-3">
            <label for="penyusun" class="form-label">Penyusun</label>
            <input type="text" name="penyusun" class="form-control" value="{{ old('penyusun', $laporan->penyusun) }}">
        </div>

        <button type="submit" class="btn btn-success">Perbarui</button>
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection