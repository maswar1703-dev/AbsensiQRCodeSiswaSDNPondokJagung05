@extends('layouts.app')

@section('content')

<h2>Edit Kelas</h2>

<form action="/kelas/{{ $kelas->id }}"
method="POST">

    @csrf
    @method('PUT')

    <div class="mb-3">

        <label>Nama Kelas</label>

        <input type="text"
        name="nama_kelas"
        value="{{ $kelas->nama_kelas }}"
        class="form-control">

    </div>

    <button class="btn btn-primary">

        Update

    </button>

</form>

@endsection