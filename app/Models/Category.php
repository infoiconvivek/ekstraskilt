<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = array('*');

    public function childs() {
        return $this->hasMany('App\Models\Category','parent_id','id') ;
    }

    public function parent() {
       return $this->hasone('App\Models\Category', 'id', 'parent_id') ;
   }
}
