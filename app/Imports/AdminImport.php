<?php

namespace App\Imports;

use App\Models\Admin;
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
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use App\Notifications\PasswordSend;


class AdminImport implements ToModel, WithUpserts, WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation, SkipsOnError,SkipsOnFailure
{
    use Importable, SkipsErrors,SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $admin = new Admin([
            'username'     => $row['username'],
           'nama'    => $row['nama'], 
           'email'    => $row['email'], 
           'password' => Hash::make($row['password']),
        ]);
        Notification::send($admin, new PasswordSend($row['password'],route('admin.login')));
        return $admin;
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
        return ['username','email'];
    }

    public function rules(): array
    {
        return [
            'nama' => ['required','string'],
			'email' => ['required','string','email'],
			'username' => ['required', 'string'],
			'password' => ['required', 'string',Password::min(8)->letters()->numbers()],
        ];
    }
}
