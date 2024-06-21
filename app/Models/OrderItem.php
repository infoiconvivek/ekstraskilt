<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->hasOne(\App\Models\Category::class, 'id', 'category_id');
    }

    public function product()
    {
        return $this->hasOne(\App\Models\Product::class, 'id', 'product_id');
    }
}
