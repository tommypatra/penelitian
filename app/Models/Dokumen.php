<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function dokumenPeneliti()
    {
        return $this->hasMany(DokumenPeneliti::class);
    }

    public function penelitian()
    {
        return $this->belongsTo(Penelitian::class);
    }
}
