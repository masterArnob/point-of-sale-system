<?php

use Illuminate\Support\Facades\Session;

function getSubTotal(){
  $total = 0;
  foreach(Cart::content() as $product){
    $total += ($product->price + $product->options->variants_total) * $product->qty;
  }
  return $total;
}



function getDiscount(){
  if(Session::has('coupon')){
    $coupon = Session::get('coupon');
    $subtotal = getSubTotal();
    if($coupon['discount_type'] == 'amount'){
      return $coupon['discount'];
    }else if($coupon['discount_type'] == 'percent'){
      $discount = $subtotal - ($subtotal * $coupon['discount'] / 100);
      return $discount;
    }
  }else{
  return 0;
  }
}

function getTotal(){
  if(Session::has('coupon')){
    $coupon = Session::get('coupon');
    $subtotal = getSubTotal();
    if($coupon['discount_type'] == 'amount'){
      $total = $subtotal - $coupon['discount'];
      return round($total);
    }else if($coupon['discount_type'] == 'percent'){
      $discount = $subtotal - ($subtotal * $coupon['discount'] / 100);
      $total = $subtotal - $discount;
      return round($total);
    }
  }else{
    $total = getSubTotal();
    return $total;
  }
}
