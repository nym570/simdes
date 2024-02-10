<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Hashidable;

class RT extends Model
{
    use HasFactory,Hashidable;
    protected $table = 'rt';
    protected $guarded = ['id'];

    public function rw()
    {
        return $this->belongsTo(RW::class);
    }
}
