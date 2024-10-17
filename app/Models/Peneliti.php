<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peneliti extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function suratPenugasan()
    {
        return $this->hasMany(SuratPenugasan::class);
    }

    public function dokumenPeneliti()
    {
        return $this->hasMany(DokumenPeneliti::class);
    }

    public function penelitian()
    {
        return $this->belongsTo(Penelitian::class);
    }

    // Relasi ke user_roles menggunakan user_role_id
    public function userRole()
    {
        return $this->belongsTo(UserRole::class, 'user_role_id');
    }

    // Relasi ke user_roles menggunakan admin_role_id
    public function adminRole()
    {
        return $this->belongsTo(UserRole::class, 'admin_role_id');
    }
}
