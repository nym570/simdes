<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Hashidable;

class RW extends Model
{
    use HasFactory,Hashidable;
    protected $table = 'rw';
    protected $guarded = ['id'];

    public function dusun()
    {
        return $this->belongsTo(Dusun::class);
    }
    public function rt()
    {
        return $this->hasMany(RT::class);
    }
}
