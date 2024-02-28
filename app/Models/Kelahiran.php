<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Hashidable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Carbon;

class Kelahiran extends Model
{
    use HasFactory,Hashidable,LogsActivity;
    protected $table = 'kelahiran';
    protected $guarded = ['id'];
    protected $with = ['dinamika']; 
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['tempat','berat','panjang','waktu','verifikasi','bukti','keterangan','ibu_nik','bapak_nik','kepala_nik'])
		->logOnlyDirty()
		->useLogName('Kelahiran');
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
