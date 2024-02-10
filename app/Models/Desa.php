<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Hashidable;

class Desa extends Model
{
    use HasFactory,Hashidable;
    protected $table = 'desa';
    protected $guarded = ['id'];
}
