<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
  public function index(){
    return view('checkout');
  }

  public function placeOrder(Request $request){
    $request->validate([
      'name' => 'required',
      'address' => 'required',
      'phone' => 'required',
      'email' => 'required',
      'city'  => 'required',
    ]);

    Session::put('address', [
      'name' => $request->name,
      'address' => $request->address,
      'phone' => $request->phone,
      'email' => $request->email,
      'country' => $request->country,
      'city'  => $request->city,
      'state' => $request->state,
      'zip' => $request->zip
    ]);

    return response(['status' => 'success', 'message' => 'Order is placed!', 'redirect_link' => route('payment-page')]);
  }


  public function paymentPage(){
    return view('payment-page');
  }
}
