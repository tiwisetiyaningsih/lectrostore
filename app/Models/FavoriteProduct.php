<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteProduct extends Model
{
    protected $fillable =[
        'id_user','id_product','name_user'
    ];
}
