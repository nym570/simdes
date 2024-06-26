<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Warga;
use App\Models\Desa;
use App\Models\RT;
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
use App\Rules\NIKExist;
use App\Notifications\PasswordSend;
use Illuminate\Support\Facades\Notification;
use App\Helper\wilayahHelper;

class UserImport implements ToModel , WithUpserts, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation, SkipsOnError,SkipsOnFailure
{
    use Importable, SkipsErrors,SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $desa = Desa::get()->first();
        $rt = RT::where('name',$row['domisili'])->first();
        $warga = Warga::create([
            'nik' => $row['nik'],
            'no_kk' => $row['no_kk'],
            'nama' => $row['nama'],
            'tempat_lahir' =>  wilayahHelper::getNamaKab($row['tempat_lahir']),
            'tanggal_lahir' =>  $row['tanggal_lahir'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'pendidikan' => $row['pendidikan'],
            'pekerjaan' => $row['pekerjaan'],
            'gol_darah' => $row['gol_darah'],
            'agama' => $row['agama'],
            'kode_wilayah_ktp' => $row['kode_wilayah_ktp'],
            'ktp_desa' => $row['kode_wilayah_ktp']==$desa['kode_wilayah']?true:false,
            'alamat_ktp' => $row['alamat_ktp'],
            'status' => $row['status'],
             'no_telp' => $row['no_telp'],
             'rt_id' => is_null($rt)?null : $rt->id,
        ]);
        $user = User::create([
            'username'     => $row['username'],
           'nik'    => $row['nik'], 
           'email'    => $row['email'], 
           'password' => Hash::make($row['password']),
        ])->assignRole('warga');
        Notification::send($user, new PasswordSend($row['password'],route('login')));
        return $user;
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
        return ['username','nik','email'];
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
            'agama' => ['required'],
            'kode_wilayah_ktp' => ['required','regex:/[0-9]{2}.[0-9]{2}.[0-9]{4}/u'],
            'alamat_ktp' => ['required'],
            'domisili' => ['required'],
            'status' => ['required'],
             'no_telp' => ['required','regex:/62[0-9]+$/u'],
            'email' => ['required','string','email','unique:users,email'],
			'username' => ['required', 'string'],
			'password' => ['required', 'string',Password::min(8)->letters()->numbers()],
        ];
    }
}
