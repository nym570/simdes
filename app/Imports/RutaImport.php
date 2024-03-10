<?php

namespace App\Imports;

use App\Models\Ruta;
use App\Models\AnggotaRuta;
use App\Models\Warga;
use App\Rules\WargaRT;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;

class RutaImport implements ToModel, WithUpserts, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation, SkipsOnError,SkipsOnFailure
{
    use Importable, SkipsErrors,SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $rt_id = auth()->user()->warga->rt_id;
        $ruta = Ruta::create([
            'alamat_domisili' => $row['alamat_domisili'],
            'jumlah_art' => 1,
             'rt_id' => $rt_id,
        ]);
        $kepala = AnggotaRuta::create([
            'anggota_nik' => $row['kepala_ruta'],
            'hubungan' => 'Kepala Keluarga',
            'ruta_id' => $ruta->id,
        ]);
        return $ruta;
    }
    public function batchSize(): int
    {
        return 1000;
    }
    public function chunkSize(): int
    {
        return 1000;
    }

    public function uniqueBy()
    {
        return ['nik'];
    }

    public function rules(): array
    {
        return [
            'alamat_domisili' => ['required','string'],
            'kepala_ruta' => ['required','unique:anggota_ruta,anggota_nik','exists:warga,nik',new WargaRT],
        ];
    }
}
