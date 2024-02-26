<?php

namespace App\Imports;

use App\Models\User;
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
        return new User([
            'username'     => $row['username'],
           'nik'    => $row['nik'], 
           'email'    => $row['email'], 
           'password' => Hash::make($row['password']),
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
        return ['username','nik','email'];
    }

    public function rules(): array
    {
        return [
            'email' => ['required','string','email'],
			'username' => ['required', 'string'],
            'nik' => ['required', 'string','size:16',new NIKExist],
			'password' => ['required', 'string',Password::min(8)->letters()->numbers()],
        ];
    }
    public function upsertColumns()
    {
        return ['username', 'email','password'];
    }
}
