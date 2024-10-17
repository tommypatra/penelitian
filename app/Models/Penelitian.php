<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penelitian extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function peneliti()
    {
        return $this->hasMany(Peneliti::class);
    }


    public function dokumen()
    {
        return $this->hasMany(Dokumen::class);
    }


    public function jenisPenelitian()
    {
        return $this->belongsTo(JenisPenelitian::class);
    }

    public function userRole()
    {
        return $this->belongsTo(UserRole::class);
    }
}
