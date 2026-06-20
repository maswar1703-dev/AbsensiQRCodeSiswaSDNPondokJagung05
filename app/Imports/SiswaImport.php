<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class SiswaImport implements ToCollection
{
    protected $kelas_id;

    public function __construct($kelas_id)
    {
        $this->kelas_id = $kelas_id;
    }

    public function collection(Collection $rows)
    {
        unset($rows[0]);

        foreach ($rows as $row) {

            Siswa::create([
                'nis' => $row[0],
                'nama' => $row[1],
                'kelas_id' => $this->kelas_id,
            ]);
        }
    }
}