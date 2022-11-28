<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable =[
        'id_user','name_user','id_product','name_product','qty_order','qty_product','amount', 'id_status_order'
    ];
}
