<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use App\Http\Traits\Hashidable;


class InfoPublik extends Model
{
    use HasFactory,Notifiable,LogsActivity,Hashidable;
    protected $table = 'info_publik';
    protected $guarded = [];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['kategori', 'judul','keterangan','lampiran','is_show'])
		->logOnlyDirty()
		->useLogName('Informasi Publik');
        // Chain fluent methods for configuration options
    }
}
