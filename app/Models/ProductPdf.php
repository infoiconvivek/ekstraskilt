<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPdf extends Model
{
    use HasFactory;
    protected $table = 'product_pdfs';
    protected $fillable = array('*');
}
