<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Hashidable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Pemerintahan extends Model
{
    use HasFactory,Hashidable,LogsActivity;
    protected $table = 'pemerintahan';
    protected $guarded = ['id'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['nik','jabatan','foto','tugas','wewenang'])
		->logOnlyDirty()
		->useLogName('Pemerintahan');
        // Chain fluent methods for configuration options
    }
    public function warga()
    {
        return $this->belongsTo(Warga::class,'nik', 'nik');
    }
}
