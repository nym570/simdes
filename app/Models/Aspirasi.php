<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use App\Http\Traits\Hashidable;

class Aspirasi extends Model
{
    use HasFactory,Notifiable,LogsActivity,Hashidable;
    protected $table = 'aspirasi';
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['kategori', 'tingkat','judul','isi','lampiran','is_open'])
		->logOnlyDirty()
		->useLogName('Aspirasi');
        // Chain fluent methods for configuration options
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function balas_aspirasi()
    {
        return $this->hasMany(BalasAspirasi::class,'aspirasi_id', 'id');
    }
}
