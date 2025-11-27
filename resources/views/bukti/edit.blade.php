@extends('layouts.Layout')

@section('content')
<div class="container mt-4">

    <h2>Edit Bukti</h2>

    <form action="{{ route('bukti.update', $bukti->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Nama Bukti</label>
            <input type="text" name="nama_bukti" value="{{ $bukti->nama_bukti }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ $bukti->deskripsi }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('bukti.index') }}" class="btn btn-secondary">Kembali</a>

    </form>

</div>
@endsection