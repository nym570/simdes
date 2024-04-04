<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use App\Http\Traits\Hashidable;

class PengajuanInfoPublik extends Model
{
    use HasFactory,Notifiable,LogsActivity,Hashidable;
    protected $table = 'pengajuan_info_publik';
    protected $guarded = [];

    public function getCreatedAtAttribute($date)
    {
            return Carbon::parse($date)->translatedFormat('d F Y H:i');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['no_pendaftaran', 'nama','nik_pengaju','email','no_telp','alamat','pekerjaan','tujuan','rincian','cara_perolehan','media_perolehan','status','lampiran','bukti'])
		->logOnlyDirty()
		->useLogName('Pengajuan Informasi Publik');
        // Chain fluent methods for configuration options
    }
}
