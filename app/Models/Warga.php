<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use App\Http\Traits\Hashidable;

class Warga extends Model
{
    use HasFactory,Notifiable,LogsActivity,Hashidable;
    protected $table = 'warga';
    protected $guarded = [];
    

   

    public function getTanggalLahirAttribute($date)
    {
            return Carbon::parse($date)->translatedFormat('d M Y');
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
        return $this->hasOne(User::class,'nik', 'nik');
    }
    public function rt()
    {
        return $this->belongsTo(RT::class);
    }
    public function pemerintahan()
    {
        return $this->hasOne(Pemerintahan::class,'nik', 'nik');
    }
    public function anggota_ruta()
    {
        return $this->hasOne(AnggotaRuta::class,'anggota_nik', 'nik');
    }
    public function dinamika()
    {
        return $this->hasMany(Dinamika::class,'nik', 'nik');
    }
    public function surat_keterangan()
    {
        return $this->hasMany(SuratKeterangan::class,'nik', 'nik');
    }
    
}
