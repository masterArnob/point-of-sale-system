<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $product = Product::findOrFail(request()->product_id);
      $variants = ProductVariant::where('product_id', $product->id)->get();
        return view('product-variant.index', compact('variants', 'product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('product-variant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
          'name' => ['required', 'max:200'],
          'product_id' => ['required', 'integer'],
          'status' => ['required', 'integer'],
        ]);

        $variant = new ProductVariant();
        $variant->product_id = $request->product_id;
        $variant->name = $request->name;
        $variant->status = $request->status;
        $variant->save();
        toastr()->success('Variant is created!', 'Success');
        return redirect()->route('product-variant.index', ['product_id' => $request->product_id]);
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
    public function edit(Request $request, string $id)
    {
      $product_id = $request->product_id;
        $variant = ProductVariant::findOrFail($id);
        return view('product-variant.edit', compact('variant', 'product_id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      $variant = ProductVariant::findOrFail($id);
      $variant->product_id = $request->product_id;
      $variant->name = $request->name;
      $variant->status = $request->status;
      $variant->save();
      toastr()->success('Variant is updated!', 'Success');
      return redirect()->route('product-variant.index', ['product_id' => $request->product_id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $variant = ProductVariant::findOrFail($id);

        $item = ProductVariantItem::where('product_variant_id', $variant->id)->count();
        if($item > 0){
          toastr()->error('Please delete the Variant items first!');
          return redirect()->back();
        }else{
          $variant->delete();
          toastr()->success('Variant is deleted!', 'Success');
          return redirect()->back();
        }

    }
}
