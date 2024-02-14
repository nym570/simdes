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
    public function warga()
    {
        return $this->belongsTo(Warga::class,'kepala_desa_nik', 'nik');
    }
}
