<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGallery extends Model
{
    protected $table = 'product_galleries';
    protected $fillable = array('*');
    use HasFactory;

    // public function gallery()
    // {
    //     return $this->belongsTo(ProductImage::class, 'product_id', 'id');
    // }

}
