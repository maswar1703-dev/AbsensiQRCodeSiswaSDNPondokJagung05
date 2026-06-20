@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Data Siswa Perkelas</h2>

        @if(Auth::user()->role == 'admin')

        <div class="d-flex gap-2">

            <form
                action="{{ route('siswa.import') }}"
                method="POST"
                enctype="multipart/form-data"
                class="d-flex"
            >
                @csrf

                <input
                    type="file"
                    name="file_excel"
                    class="form-control me-2"
                    accept=".xlsx,.xls,.csv"
                    required
                >

                <button class="btn btn-success">
                    Import Excel
                </button>

            </form>

            <a href="/siswa/create" class="btn btn-primary">
                + Tambah Siswa
            </a>

        </div>

        @endif

    </div>

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    <div class="accordion" id="accordionKelas">

        @foreach($kelas as $itemKelas)

        <div class="accordion-item mb-3 border-0 shadow">

            <h2 class="accordion-header">

                <div class="d-flex justify-content-between align-items-center bg-light p-3 border">

                    <button
                        class="accordion-button collapsed fw-bold flex-grow-1"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#kelas{{ $itemKelas->id }}"
                    >
                        Kelas {{ $itemKelas->nama_kelas }}
                    </button>

                    {{-- Guru & Admin bisa cetak QR --}}
                    <a
                        href="{{ route('siswa.qrkelas', $itemKelas->id) }}"
                        class="btn btn-danger ms-3"
                    >
                        Cetak QR Kelas
                    </a>

                </div>

            </h2>

            <div
                id="kelas{{ $itemKelas->id }}"
                class="accordion-collapse collapse"
                data-bs-parent="#accordionKelas"
            >

                <div class="accordion-body">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">

                            <tr>
                                <th width="70">No</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>QR Code</th>
                                <th width="280">Aksi</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($itemKelas->siswa as $item)

                            <tr>

                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nis }}</td>
                                <td>{{ $item->nama }}</td>

                                <td class="text-center">
                                    {!! QrCode::size(80)->generate($item->nis) !!}
                                </td>

                                <td>

                                    <a
                                        href="{{ route('siswa.qr', $item->id) }}"
                                        class="btn btn-success btn-sm mb-1"
                                    >
                                        Download QR
                                    </a>

                                    @if(Auth::user()->role == 'admin')

                                    <a
                                        href="/siswa/{{ $item->id }}/edit"
                                        class="btn btn-warning btn-sm mb-1"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="/siswa/{{ $item->id }}"
                                        method="POST"
                                        class="d-inline"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="btn btn-danger btn-sm mb-1"
                                            onclick="return confirm('Hapus data siswa?')"
                                        >
                                            Hapus
                                        </button>

                                    </form>

                                    @endif

                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="5" class="text-center">
                                    Belum ada siswa di kelas ini
                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        @endforeach

    </div>

</div>

@endsection