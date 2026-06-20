@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow-lg border-0 rounded-4">

        <div class="card-body p-5">

            <h2 class="mb-4 fw-bold text-primary">

                Tambah Siswa

            </h2>

            <form action="/siswa" method="POST">

                @csrf

                <div class="mb-4">

                    <label class="form-label fw-semibold">

                        Kelas

                    </label>

                    <select name="kelas_id"
                    class="form-select">

                        @foreach($kelas as $k)

                        <option value="{{ $k->id }}">

                            {{ $k->nama_kelas }}

                        </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-4">

                    <label class="form-label fw-semibold">

                        NIS

                    </label>

                    <input type="text"
                    name="nis"
                    class="form-control form-control-lg"
                    placeholder="Masukkan NIS">

                </div>

                <div class="mb-4">

                    <label class="form-label fw-semibold">

                        Nama Siswa

                    </label>

                    <input type="text"
                    name="nama"
                    class="form-control form-control-lg"
                    placeholder="Masukkan Nama Siswa">

                </div>

                <button class="btn btn-primary btn-lg">

                    Simpan Data

                </button>

            </form>

        </div>

    </div>

</div>

@endsection