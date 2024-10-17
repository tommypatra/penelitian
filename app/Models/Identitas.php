<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Identitas extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function pangkat()
    {
        return $this->belongsTo(Pangkat::class);
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
