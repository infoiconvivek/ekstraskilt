<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Order extends Model
{
    use HasFactory;
    protected $fillable = array('*');
    protected $table = 'orders';


    public function user()
    {
        return $this->hasOne(\App\Models\User::class, 'id', 'user_id');
    }

    public function user_detail()
    {
        return $this->hasOne(\App\Models\UserDetail::class, 'user_id', 'user_id');
    }
}
