<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Hashidable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Kedatangan extends Model
{
    use HasFactory,Hashidable,LogsActivity;
    protected $table = 'kedatagan';
    protected $guarded = ['id'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['waktu_datang','verifikasi','bukti','keterangan'])
		->logOnlyDirty()
		->useLogName('Kedatangan');
        // Chain fluent methods for configuration options
    }
    public function getWaktuAttribute($date)
    {
            return Carbon::parse($date)->translatedFormat('d F Y H:i');
    }
    public function dinamika()
    {
        return $this->morphMany(Dinamika::class,'dinamika');
    }
}
