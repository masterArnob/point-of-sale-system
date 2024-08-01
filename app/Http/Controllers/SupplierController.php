<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $sups = Supplier::orderBy('created_at', 'desc')->paginate(5);
        return view('supplier.index', compact('sups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
  
      return view('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
          'name' => ['required', 'max:200'],
          'sname' => ['required', 'max:200'],
          'email' => ['required'],
          'phone' => ['required', 'max:200'],
          'address' => ['required', 'max:500'],
          'status' => ['required', 'integer']
        ]);

        $sup = new Supplier();
        $sup->name = $request->name;
        $sup->sname = $request->sname;
        $sup->email = $request->email;
        $sup->phone = $request->phone;
        $sup->address = $request->address;
        $sup->status = $request->status;
        $sup->save();
        toastr()->success('Supplier is created!', 'Success');
        return redirect()->route('supplier.index');
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
      $sup = Supplier::findOrFail($id);
      return view('supplier.edit', compact('sup'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      
 
      $sup = Supplier::findOrFail($id);
      $product = Product::where('supplier_id', $sup->id)->count();
      if($product > 0 && $request->status == '0'){
        toastr()->error('Please delete the product first!', 'There are products under this suppliers!');
        return redirect()->back();
      }else{
        $sup->name = $request->name;
        $sup->sname = $request->sname;
        $sup->email = $request->email;
        $sup->phone = $request->phone;
        $sup->address = $request->address;
        $sup->status = $request->status;
        $sup->save();
        toastr()->success('Supplier is updated!', 'Success');
        return redirect()->route('supplier.index');
      }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sup = Supplier::findOrFail($id);

        $product = Product::where('supplier_id', $sup->id)->count();

        if($product > 0){
          toastr()->error('Please delete the supplier product first!', 'There are products under this suppliers!');
          return redirect()->back();
        }else{
          $sup->delete();
          toastr()->success('Supplier is deleted!', 'Success');
          return redirect()->back();
        }
     
    }
}
