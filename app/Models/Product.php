<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = array('*');
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function gallery()
    {
        return $this->hasMany(ProductImage::class, 'product_id')->orderBy('image_ordering', 'ASC');
    }

    // public function variations()
    // {
    //     return $this->hasMany(Variation::class);
    // }
    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }
    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function attribute_value()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
