<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $coupons = Coupon::orderBy('created_at', 'desc')->paginate(5);
        return view('all-coupon', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    
        return view('create-coupon');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

      $request->validate([
        'code' => ['required'],
        'discount' => ['required'],
        'discount_type' => ['required'],
        'status' => ['required', 'integer'],
        'start_date' => ['required'],
        'end_date' => ['required']
       ]);

       $coupon = new Coupon();
       $coupon->name = $request->name;
       $coupon->code = $request->code;
       $coupon->qty = 5;
       $coupon->max_use = 1;
       $coupon->start_date = $request->start_date;
       $coupon->end_date = $request->end_date;
       $coupon->discount_type = $request->discount_type;
       $coupon->discount = $request->discount;
       $coupon->total_used = 0;
       $coupon->status = $request->status;
       $coupon->save();
       toastr()->success('Coupon is created!', 'Success');
       return redirect()->route('coupon.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
      $coupon = Coupon::findOrFail($id);
        return view('edit-coupon', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
  
       $coupon = Coupon::findOrFail($id);
       $coupon->name = $request->name;
       $coupon->code = $request->code;
       $coupon->start_date = $request->start_date;
       $coupon->end_date = $request->end_date;
       $coupon->discount_type = $request->discount_type;
       $coupon->discount = $request->discount;
       $coupon->status = $request->status;
       $coupon->save();
       toastr()->success('Coupon is updated!', 'Success');
       return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
        toastr()->success('Coupon is deleted!', 'Success');
        return redirect()->back();
    }
}
