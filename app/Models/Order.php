<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
      'transaction_id', 
      'invoice_id', 
      'sub_total', 
      'amount', 
      'product_qty', 
      'payment_method', 
      'shipping_method', 
      'payment_status', 
      'order_address', 
      'order_status', 
      'coupon', 
      'status', 
      'currency'
  ];

  public function transaction(){
    return $this->hasOne(Transaction::class);
  }

  public function orderProducts(){
    return $this->hasMany(OrderProduct::class);
  }
}
