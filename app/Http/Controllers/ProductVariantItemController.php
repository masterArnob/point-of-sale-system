<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\IgnoreFunctionForCodeCoverage;

class ProductVariantItemController extends Controller
{
    public function index($product_id, $variant_id){
      $product = Product::findOrFail($product_id);
      $variant = ProductVariant::findOrFail($variant_id);
      $items = ProductVariantItem::where('product_variant_id', $variant->id)->get();
      return view('product-variant-item.index', compact('product', 'variant', 'items'));
    }

    public function create($product_id, $variant_id){
      $product = Product::findOrFail($product_id);
      $variant = ProductVariant::findOrFail($variant_id);
      return view('product-variant-item.create', compact('product','variant'));
    }


    public function store(Request $request){
      $request->validate([
        'name' => ['required', 'max:200'],
        'price' => ['required'],
        'is_default' => ['required', 'integer'],
        'status' => ['required', 'integer']
      ]);

      $item = new ProductVariantItem();
      $item->product_variant_id = $request->product_variant_id;
      $item->name = $request->name;
      $item->price = $request->price;
      $item->is_default = $request->is_default;
      $item->status = $request->status;
      $item->save();
      toastr()->success('Variant item is saved!', 'Success');
      return redirect()->route('variant-item', ['product_id' => $request->product_id, $request->product_variant_id]);
    }


    public function edit($product_id, $variant_id, $item_id){
    $product = Product::findOrFail($product_id);
    $variant = ProductVariant::findOrFail($variant_id);
    $item = ProductVariantItem::findOrFail($item_id);
    return view('product-variant-item.edit', compact('product','variant', 'item'));
    }


    public function update(Request $request, $id){
      $item = ProductVariantItem::findOrFail($id);
      $item->product_variant_id = $request->product_variant_id;
      $item->name = $request->name;
      $item->price = $request->price;
      $item->is_default = $request->is_default;
      $item->status = $request->status;
      $item->save();
      toastr()->success('Variant item is updated!', 'Success');
      return redirect()->route('variant-item', ['product_id' => $request->product_id, $request->product_variant_id]);
    }


    public function destroy($id){
     $item = ProductVariantItem::findOrFail($id);
     $item->delete();
     toastr()->success('Variant item is deleted!', 'Success');
     return redirect()->back();
    }
}
