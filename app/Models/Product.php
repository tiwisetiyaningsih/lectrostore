<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable =[
        'id_category','name_product','image_product','size_product','desc_product','price_product','qty_stok'
    ];
}
