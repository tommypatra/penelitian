<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function penelitian()
    {
        return $this->hasMany(Penelitian::class);
    }

    public function dokumenPeneliti()
    {
        return $this->hasMany(DokumenPeneliti::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi hasMany untuk user_role_id pada model Peneliti
    public function penelitiUserRole()
    {
        return $this->hasMany(Peneliti::class, 'user_role_id');
    }

    // Relasi hasMany untuk admin_role_id pada model Peneliti
    public function penelitiAdminRole()
    {
        return $this->hasMany(Peneliti::class, 'admin_role_id');
    }

    public function suratPenugasanUserRole()
    {
        return $this->hasMany(SuratPenugasan::class, 'user_role_id');
    }

    public function suratPenugasanKetuaLppmRole()
    {
        return $this->hasMany(SuratPenugasan::class, 'ketua_lppm_role_id');
    }
}
