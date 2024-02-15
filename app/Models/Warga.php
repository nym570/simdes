<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class Warga extends Model
{
    use HasFactory,Notifiable,LogsActivity;
    protected $table = 'warga';
    protected $guarded = [];

   

    public function getTanggalLahirAttribute($date)
    {
            return Carbon::parse($date)->translatedFormat('d F Y');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['nik', 'no_kk','nama','tempat_lahir','tanggal_lahir','jenis_kelamin','agama','pendidikan','pekerjaan','gol_darah','kode_wilayah_ktp','alamat_ktp','no_telp','ktp_desa','status','dokumen_ktp','dokumen_kk'])
		->logOnlyDirty()
		->useLogName('Warga');
        // Chain fluent methods for configuration options
    }

    public function user()
    {
        return $this->hasOne(User::class,'foreign_key', 'nik');
    }
    public function desa()
    {
        return $this->hasOne(Warga::class,'foreign_key', 'nik');
    }
}
