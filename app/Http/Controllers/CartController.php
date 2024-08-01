<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductVariantItem;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{


  public function cartDetails()
  {
    if (Cart::count() < 1) {
      Session::forget('coupon');
    }
    $cartItems = Cart::content();
    return view('cart-details', compact('cartItems'));
  }

  public function addToCart(Request $request)
  {
    $product = Product::findOrFail($request->product_id);


    if (Cart::count() > 1) {
      foreach (Cart::content()->where('id', $request->product_id) as $cartItem) {
        if ($product->quantity <= $cartItem->qty) {
          return response(['status' => 'error', 'message' => 'Quantity not available!']);
        }
      }
    }




    $variants = [];
    $productPrice = 0;
    $variants_total = 0;

    if ($request->has('variants_items')) {
      foreach ($request->variants_items as $item_id) {
        $variantItem = ProductVariantItem::findOrFail($item_id);
        $variants[$variantItem->productVariant->name]['name'] = $variantItem->name;
        $variants[$variantItem->productVariant->name]['price'] = $variantItem->price;
        $variants_total += $variantItem->price;
      }
    }


    $currentDate = date('Y-m-d');
    if ($product->offer_price > 0 && $currentDate >= $product->offer_start_date && $currentDate <= $product->offer_end_date) {
      $productPrice = $product->offer_price;
    } else {
      $productPrice = $product->price;
    }


    $cartData = [];
    $cartData['id'] = $product->id;
    $cartData['name'] = $product->name;
    $cartData['price'] = $productPrice;
    $cartData['qty'] = 1;
    $cartData['weight'] = 10;
    $cartData['options']['thumb_image'] = $product->thumb_image;
    $cartData['options']['variants'] = $variants;
    $cartData['options']['variants_total'] = $variants_total;



    Cart::add($cartData);
    return response(['status' => 'success', 'message' => 'Added to the cart!']);
  }

  public function clearCart()
  {
    Cart::destroy();
    return response(['status' => 'success']);
  }

  public function removeItem($rowId)
  {
    Cart::remove($rowId);
    return redirect()->back();
  }


  public function qtyUpdate(Request $request)
  {

    $product_id = Cart::get($request->rowId)->id;
    $product = Product::findOrFail($product_id);

    if($product->qty == 0){
      return response(['status' => 'error', 'message' => 'Product stock out']);
    }else if ($request->qty > $product->qty) {
      return response(['status' => 'error', 'message' => 'Quantity not available']);
    }

    Cart::update($request->rowId, $request->qty);
    $productTotal = $this->productTotal($request->rowId);
    return response(['status' => 'success', 'message' => 'Quantity is updated!', 'productTotal' => $productTotal]);
  }

  public function productTotal($rowId)
  {
    $product = Cart::get($rowId);
    $total = ($product->price + $product->options->variants_total) * $product->qty;
    return $total;
  }

  public function subTotal()
  {
    return getSubTotal();
  }

  public function applyCoupon(Request $request)
  {
    if ($request->coupon_code == null) {
      return response(['status' => 'error', 'message' => 'Coupon code is required!']);
    }

    $coupon = Coupon::where(['code' => $request->coupon_code, 'status' => 1])->first();
    $currentDate = date('Y-m-d');

    if ($coupon == "") {
      return response(['status' => 'error', 'message' => 'Coupon code not exist!']);
    } else if ($currentDate < $coupon->start_date && $currentDate > $coupon->end_date) {
      return response(['status' => 'error', 'message' => 'Coupon code expired!']);
    } else if ($coupon->total_used > $coupon->qty) {
      return response(['status' => 'error', 'message' => 'Coupon code expired!']);
    } else {
      if ($coupon->discount_type == 'amount') {
        Session::put('coupon', [
          'id' => $coupon->id,
          'code' => $coupon->code,
          'discount_type' => 'amount',
          'discount' => $coupon->discount
        ]);
      } else if ($coupon->discount_type == 'percent') {
        Session::put('coupon', [
          'id' => $coupon->id,
          'code' => $coupon->code,
          'discount_type' => 'percent',
          'discount' => $coupon->discount
        ]);
      }

      return response(['status' => 'success', 'message' => 'Coupon code is applied!']);
    }
  }

  public function couponCalculation()
  {
    if (Session::has('coupon')) {
      $coupon = Session::get('coupon');
      $subtotal = getSubTotal();
      if ($coupon['discount_type'] == 'amount') {
        $total = $subtotal - $coupon['discount'];
        return response(['status' => 'success', 'cart_total' => round($total), 'discount' => $coupon['discount']]);
      } else if ($coupon['discount_type'] == 'percent') {
        $discount = $subtotal - ($subtotal * $coupon['discount'] / 100);
        $total = $subtotal - $discount;
        return response(['status' => 'success', 'cart_total' => round($total), 'discount' => $discount]);
      }
    } else {
      $total = getSubTotal();
      return response(['status' => 'success', 'cart_total' => $total, 'discount' => 0]);
    }
  }
}
