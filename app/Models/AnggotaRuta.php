<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Hashidable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class AnggotaRuta extends Model
{
    use HasFactory,Hashidable,LogsActivity;
    protected $table = 'anggota_ruta';
    protected $guarded = ['id'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['anggota_nik','ruta_id','hubungan'])
		->logOnlyDirty()
		->useLogName('Anggota Ruta');
        // Chain fluent methods for configuration options
    }
    public function warga()
    {
        return $this->belongsTo(Warga::class,'nik', 'anggota_nik');
    }
    public function ruta()
    {
        return $this->belongsTo(Ruta::class);
    }
}
