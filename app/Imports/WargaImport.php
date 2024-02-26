<?php

namespace App\Imports;

use App\Models\Warga;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
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

class WargaImport implements ToModel, WithUpserts, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation, SkipsOnError,SkipsOnFailure
{
    use Importable, SkipsErrors,SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Warga([
            'nik' => $row['nik'],
            'no_kk' => $row['no_kk'],
            'nama' => $row['nama'],
            'tempat_lahir' =>  $row['tempat_lahir'],
            'tanggal_lahir' =>  $row['tanggal_lahir'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'pendidikan' => $row['pendidikan'],
            'pekerjaan' => $row['pekerjaan'],
            'gol_darah' => $row['gol_darah'],
            'kode_wilayah_ktp' => $row['kode_wilayah_ktp'],
            'ktp_desa' => $row['kode_wilayah_ktp']==$desa['kode_wilayah']?true:false,
            'alamat_ktp' => $row['alamat_ktp'],
            'status' => $row['status'],
             'no_telp' => $row['no_telp'],
        ]);
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
            'nik' => ['required', 'size:16'],
            'no_kk' => ['required', 'size:16'],
            'nama' => ['required'],
            'tempat_lahir' =>  ['required'],
            'tanggal_lahir' =>  ['required'],
            'jenis_kelamin' => ['required'],
            'pendidikan' => ['required'],
            'pekerjaan' => ['required'],
            'gol_darah' => ['required'],
            'kode_wilayah_ktp' => ['required','regex:/[0-9]{2}.[0-9]{2}.[0-9]{4}/u'],
            'alamat_ktp' => ['required'],
            'status' => ['required'],
             'no_telp' => ['required','regex:/62[0-9]+$/u'],
        ];
    }
}
