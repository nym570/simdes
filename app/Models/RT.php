<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Hashidable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class RT extends Model
{
    use HasFactory,Hashidable,LogsActivity;
    protected $table = 'rt';
    protected $guarded = ['id'];
    protected $with = ['pemimpin','rw'];

    public function rw()
    {
        return $this->belongsTo(RW::class);
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['name'])
		->logOnlyDirty()
		->useLogName('RT');
        // Chain fluent methods for configuration options
    }
    public function ruta()
    {
        return $this->hasMany(Ruta::class);
    }
    public function pemimpin()
    {
        return $this->belongsTo(User::class,'pemimpin', 'id');
    }
    public function warga()
    {
        return $this->hasMany(Warga::class,'rt_id','id');
    }
}
