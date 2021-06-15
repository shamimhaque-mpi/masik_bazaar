<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['user_id', 'order_id', 'product_id', 'quantity', 'price', 'size', 'size_id', 'color', 'color_id', 'admin_id', 'order_status', 'status',  'is_return', 'created_at', 'updated_at'];

    protected $with = ['product', 'colorS', 'sizeS'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function colorS(){
        return $this->hasOne(Color::class, 'id', 'color_id');
    }

    public function sizeS(){
        return $this->hasOne(Size::class, 'id', 'size_id');
    }
}
