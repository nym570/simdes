<?php

namespace App\Imports;

use App\Models\Ruta;
use App\Models\AnggotaRuta;
use App\Models\Warga;
use Illuminate\Validation\Rule;
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
use App\Rules\WargaRT;
use App\Rules\KepalaRuta;
use Illuminate\Database\Eloquent\Builder;

class AnggotaRutaImport implements ToModel, WithUpserts, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation, SkipsOnError,SkipsOnFailure
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
        $ruta = Ruta::whereHas("anggota_ruta", function(Builder $builder) use ($row) {
            $builder->where('anggota_nik', '=', $row['kepala_ruta']);
        })->first();
        $anggota= AnggotaRuta::create([
            'anggota_nik' => $row['anggota_nik'],
            'hubungan' => $row['hubungan'],
            'ruta_id' => $ruta->id,
        ]);
        $data['jumlah_art'] = $ruta['jumlah_art'] + 1;
        $ruta->update($data);
        return $anggota;
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
        return ['anggota_nik'];
    }

    public function rules(): array
    {
        return [
            'anggota_nik' => ['required','unique:anggota_ruta,anggota_nik','exists:warga,nik',new WargaRT],
            'hubungan' => ['required','string',Rule::notIn(['Kepala Keluarga'])],
            'kepala_ruta' => ['required','exists:anggota_ruta,anggota_nik',new KepalaRuta],
        ];
    }
}
