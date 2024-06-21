<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    use HasFactory;

    public function designs()
    {
        return $this->hasMany(Design::class);
    }

    // app/Design.php
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
