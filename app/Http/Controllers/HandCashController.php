<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Cart;

class HandCashController extends Controller
{
    public function index(){
      
      $invoice_id = uniqid();
      $sub_total = getSubTotal();
      $coupon = json_encode(Session::get('coupon'));
      $amount = getTotal();
      $product_qty = Cart::content()->count();
      $payment_method = 'Hand Cash';
      $shipping_method = 'NO';
      $payment_status = 1;
      $order_address = json_encode(Session::get('address'));
      $order_status = 1;
      $status = 1;
      $transaction_id = uniqid();
      $currency = 'BDT';

      $order = new Order();
      $order->invoice_id = $invoice_id;
      $order->sub_total = $sub_total;
      $order->coupon = $coupon;
      $order->amount = $amount;
      $order->product_qty = $product_qty;
      $order->payment_method = $payment_method;
      $order->shipping_method = $shipping_method;
      $order->payment_status = $payment_status;
      $order->order_address = $order_address;
      $order->order_status = $order_status;
      $order->status = $status;
      $order->transaction_id = $transaction_id;
      $order->currency = $currency;
      $order->save();
      

          // Save order products
    foreach (Cart::content() as $item) {
      $product = Product::findOrFail($item->id);
      $orderProduct = new OrderProduct();
      $orderProduct->order_id = $order->id;
      $orderProduct->product_id = $product->id;
      $orderProduct->product_name = $product->name;
      $orderProduct->variants = json_encode($item->options->variants);
      $orderProduct->variants_total = $item->options->variants_total;
      $orderProduct->unit_price = $item->price;
      $orderProduct->qty = $item->qty;
      $orderProduct->save();

      $currentQty = $product->qty;
      $newQty = ($currentQty - $item->qty);
      $product->qty = $newQty;
      $product->save();


    }

    $transaction = new Transaction();
    $transaction->order_id = $order->id;
    $transaction->transaction_id = $transaction_id;
    $transaction->amount = getTotal();
    $transaction->save();


    Cart::destroy();
    Session::forget('shipping_method');
    Session::forget('shipping_address');
    Session::forget('coupon');

    toastr()->success('Order is placed!');
    return redirect()->route('orders');
    }
}
