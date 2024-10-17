<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPenelitian extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function penelitian()
    {
        return $this->hasMany(Penelitian::class);
    }
}
