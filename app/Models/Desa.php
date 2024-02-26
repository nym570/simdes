<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Hashidable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Desa extends Model
{
    use HasFactory,Hashidable,LogsActivity;
    protected $table = 'desa';
    protected $guarded = ['id'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['kode_wilayah','nama', 'kecamatan','kabupaten','provinsi','alamat_kantor','email_desa','no_telp','deskripsi'])
		->logOnlyDirty()
		->useLogName('Desa');
        // Chain fluent methods for configuration options
    }
    public function warga()
    {
        return $this->belongsTo(Warga::class,'kepala_desa_nik', 'nik');
    }
}
