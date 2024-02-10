<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Hashidable;

class Dusun extends Model
{
    use HasFactory,Hashidable;
    protected $table = 'dusun';
    protected $guarded = ['id'];

    public function rw()
    {
        return $this->hasMany(RW::class);
    }
    public function role()
    {
        return $this->hasOne(Role::class);
    }
}
