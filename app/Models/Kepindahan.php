<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Hashidable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Carbon;

class Kepindahan extends Model
{
    use HasFactory,Hashidable,LogsActivity;
    protected $table = 'kepindahan';
    protected $guarded = ['id'];
    protected $with = ['dinamika'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['waktu','kode_wilayah_pindah','alamat_pindah','penyebab','verifikasi','bukti','keterangan'])
		->logOnlyDirty()
		->useLogName('Kepindahan');
        // Chain fluent methods for configuration options
    }
    public function getWaktuAttribute($date)
    {
            return Carbon::parse($date)->translatedFormat('d F Y');
    }
    public function dinamika()
    {
        return $this->morphMany(Dinamika::class,'dinamika');
    }
}
