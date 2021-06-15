<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = ['title', 'payment_mobile_no', 'icon', 'status'];
}
