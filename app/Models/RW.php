<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Hashidable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class RW extends Model
{
    use HasFactory,Hashidable,LogsActivity;
    protected $table = 'rw';
    protected $guarded = ['id'];
    protected $with = ['pemimpin','dusun'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['name'])
		->logOnlyDirty()
		->useLogName('RW');
        // Chain fluent methods for configuration options
    }
    public function dusun()
    {
        return $this->belongsTo(Dusun::class);
    }
    public function pemimpin()
    {
        return $this->belongsTo(User::class,'pemimpin', 'id');
    }
    public function rt()
    {
        return $this->hasMany(RT::class,'rw_id','id');
    }
}
