<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Hashidable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Dinamika extends Model
{
    use HasFactory,Hashidable,LogsActivity;
    protected $table = 'dinamika';
    protected $guarded = ['id'];
    protected $with = ['warga'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['nik','dinamika_id','dinamika_type'])
		->logOnlyDirty()
		->useLogName('Dinamika');
        // Chain fluent methods for configuration options
    }

    public function dinamika()
    {
        return $this->morphTo();
    }
    
    public function warga()
    {
        return $this->belongsTo(Warga::class,'nik', 'nik');
    }
}
