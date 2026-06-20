@extends('layouts.app')

@section('content')

<div class="container">

<div class="card shadow p-4">

    <h3 class="mb-4">
        Input Siswa Sakit
    </h3>

    <form method="POST" action="/absensi/sakit">

        @csrf

        <div class="mb-3">

            <label class="form-label">
                Pilih Kelas
            </label>

            <select id="kelasFilter" class="form-control">

                <option value="">
                    -- Semua Kelas --
                </option>

                @foreach($kelasList as $kelas)

                    <option value="{{ $kelas->id }}">
                        {{ $kelas->nama_kelas }}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="mb-3">

    <select
        name="siswa_id"
        id="siswaSelect"
        class="form-control"
        required
    >

        <option value="">
            -- Pilih Siswa --
        </option>

        @foreach($siswas as $siswa)
<option
    value="{{ $siswa->id }}"
    data-kelas="{{ $siswa->kelas_id }}"
>
    {{ $siswa->nis }} - {{ $siswa->nama }}
</option>

        @endforeach

    </select>

</div>
        <button class="btn btn-warning">
            Simpan Data Sakit
        </button>

        <a href="/laporan" class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>


</div>

<script>

document.getElementById('kelasFilter').addEventListener('change', filterSiswa);

function filterSiswa()
{
    let kelas = document.getElementById('kelasFilter').value;
    let options = document.querySelectorAll('#siswaSelect option');

    options.forEach(function(option){

        if(option.value === ''){
            option.hidden = false;
            return;
        }

        let kelasId = option.dataset.kelas;

        option.hidden = (kelas !== '' && kelasId !== kelas);
    });
}

</script>

@endsection
