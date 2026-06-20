@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">
        Data Kelas
    </h2>

    <div class="mb-3">

        <a href="/kelas/create"
        class="btn btn-primary">

            Tambah Kelas

        </a>

        <a href="{{ route('kelas.pdf') }}"
        class="btn btn-danger">

            Cetak PDF

        </a>

    </div>

    <table class="table table-bordered table-striped">

        <thead class="table-dark">

            <tr>

                <th>No</th>
                <th>Nama Kelas</th>
                <th>Jumlah Siswa</th>
                <th width="200">Aksi</th>

            </tr>

        </thead>

        <tbody>

            @foreach($kelas as $k)

            <tr>

                <td>
                    {{ $loop->iteration }}
                </td>

                <td>
                    {{ $k->nama_kelas }}
                </td>

                <td>

                    <span class="badge bg-success">

                        {{ $k->siswa_count ?? 0 }} Siswa

                    </span>

                </td>

                <td>

                    <a href="/kelas/{{ $k->id }}/edit"
                    class="btn btn-warning btn-sm">

                        Edit

                    </a>

                    <form
                        action="/kelas/{{ $k->id }}"
                        method="POST"
                        style="display:inline;"
                    >

                        @csrf
                        @method('DELETE')

                        <button
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Hapus kelas ini?')"
                        >

                            Hapus

                        </button>

                    </form>

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</div>

@endsection