<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use App\Http\Traits\Hashidable;

class SuratKeterangan extends Model
{
    use HasFactory,Notifiable,LogsActivity,Hashidable;
    protected $table = 'surat_keterangan';
    protected $guarded = [];
    protected $with = ['warga','user'];

    public function getCreatedAtAttribute($date)
    {
            return Carbon::parse($date)->translatedFormat('d F Y');
    }

    public function getUpdatedAtAttribute($date)
    {
            return Carbon::parse($date)->translatedFormat('d F Y H:i');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['nik', 'jenis','penanggung_jawab','count','tingkat','no_surat','status','verifikasi','tracking','lampiran','file'])
		->logOnlyDirty()
		->useLogName('Pengajuan Surat Keterangan');
        // Chain fluent methods for configuration options
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function warga()
    {
        return $this->belongsTo(Warga::class,'nik','nik');
    }
}
