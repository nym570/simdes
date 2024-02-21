<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Hashidable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Carbon;

class Kematian extends Model
{
    use HasFactory,Hashidable,LogsActivity;
    protected $table = 'kematian';
    protected $guarded = ['id'];
    protected $with = ['dinamika'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['tempat_kematian','waktu_kematian','usia','penyebab','verifikasi','bukti','keterangan','pelapor_nik'])
		->logOnlyDirty()
		->useLogName('Kematian');
        // Chain fluent methods for configuration options
    }
    public function getWaktuAttribute($date)
    {
            return Carbon::parse($date)->translatedFormat('d F Y H:i');
    }
    public function dinamika()
    {
        return $this->morphOne(Dinamika::class,'dinamika');
    }
}
