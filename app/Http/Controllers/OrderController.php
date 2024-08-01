<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(){
      $orders = Order::orderBy('created_at', 'desc')->paginate(5);
      return view('orders', compact('orders'));
    }

    public function invoice($id){
      $order = Order::findOrFail($id);
      return view('invoice', compact('order'));
    }

    public function searchOrder(Request $request){
      $search = $request->search_order;
      $orders = DB::table('orders')->where('invoice_id', 'like', '%'. $search .'%')
      ->orwhere('amount', 'like', '%'. $search .'%')
      ->orwhere('payment_method', 'like', '%'. $search .'%')
      ->orwhere('transaction_id', 'like', '%'. $search .'%')
      ->paginate(5);

      return view('orders', compact('orders'));
    }
}
