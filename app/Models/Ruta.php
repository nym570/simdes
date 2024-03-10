<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Hashidable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Ruta extends Model
{
    use HasFactory,Hashidable,LogsActivity;
    protected $table = 'ruta';
    protected $guarded = ['id'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['rt','jumlah_art','alamat_domisili'])
		->logOnlyDirty()
		->useLogName('Ruta');
        // Chain fluent methods for configuration options
    }
    public function anggota_ruta()
    {
        return $this->hasMany(AnggotaRuta::class);
    }
    public function rt()
    {
        return $this->belongsTo(RT::class,'rt_id', 'id');
    }
}
