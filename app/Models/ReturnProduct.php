<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnedProduct extends Model
{
	protected $fillable = ['order_id', 'product_id', 'user_id', 'quantity', 'price'];
}