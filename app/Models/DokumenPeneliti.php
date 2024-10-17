<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPeneliti extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function peneliti()
    {
        return $this->belongsTo(Peneliti::class);
    }

    public function userRole()
    {
        return $this->belongsTo(UserRole::class);
    }

    public function dokumen()
    {
        return $this->belongsTo(Dokumen::class);
    }
}
