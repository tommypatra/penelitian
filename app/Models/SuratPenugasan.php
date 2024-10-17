<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPenugasan extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function peneliti()
    {
        return $this->belongsTo(Peneliti::class);
    }

    // Relasi ke user_roles menggunakan user_role_id
    public function userRole()
    {
        return $this->belongsTo(UserRole::class, 'user_role_id');
    }

    // Relasi ke user_roles menggunakan ketua_lppm_role_id
    public function ketuaLppmRole()
    {
        return $this->belongsTo(UserRole::class, 'ketua_lppm_role_id');
    }
}
