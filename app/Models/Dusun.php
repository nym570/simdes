<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Hashidable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Dusun extends Model
{
    use HasFactory,Hashidable,LogsActivity;
    protected $table = 'dusun';
    protected $guarded = ['id'];
    protected $with = ['pemimpin'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['name'])
		->logOnlyDirty()
		->useLogName('Dusun');
        // Chain fluent methods for configuration options
    }
    public function rw()
    {
        return $this->hasMany(RW::class);
    }
    public function pemimpin()
    {
        return $this->belongsTo(User::class,'pemimpin', 'id');
    }
}
