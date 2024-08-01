<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use File;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class ProductController extends Controller
{
  public function index(){
    $products = Product::where('status', 1)->orderBy('created_at', 'desc')->paginate(5);
    return view('product', compact('products'));
  }

  public function showProducts(){
    $products = Product::orderBy('created_at', 'desc')->paginate(5);
    return view('show-products', compact('products'));
  }

  public function createProduct(){
    $sups = Supplier::where('status', 1)->get();
    $cats = Category::where('status', 1)->get();
    return view('create-product', compact('sups', 'cats'));
  }


  public function productSave(Request $request){
    $request->validate([
      'category_id' => ['required', 'integer'],
      'supplier_id' => ['required', 'integer'],
      'thumb_image' => ['required', 'image', 'max:3000'],
      'name' => ['required', 'max:200'],
      'qty' => ['required', 'integer'],
      'price' => ['required'],
    ]);


    $product = new Product();

    if($request->has('thumb_image')){
      $image = $request->thumb_image;
      $uniqueName = Str::random(10) . '_' . time() . '.' . $image->getClientOriginalExtension();
      $image->move(public_path('uploads'), $uniqueName);

      $path = "/uploads/".$uniqueName;
      $product->thumb_image = $path;
    }


    $product->name = $request->name;
    $product->qty = $request->qty;
    $product->price = $request->price;
    $product->supplier_id = $request->supplier_id;
    $product->category_id = $request->category_id;
    $product->offer_price = $request->offer_price;
    $product->offer_start_date = $request->offer_start_date;
    $product->offer_end_date = $request->offer_end_date;
    $product->status = $request->status;
    $product->save();
    toastr()->success('Product is saved!', 'Success');
    return redirect()->route('show-products');

  }



  public function editProduct($id){
    $sups = Supplier::where('status', 1)->get();
    $cats = Category::where('status', 1)->get();
    $product = Product::findOrFail($id);
    return view('edit-product', compact('product', 'sups', 'cats'));
  }


  public function productUpdate(Request $request, $id){
  

    $product = Product::findOrFail($id);

    if($request->has('thumb_image')){

      if(File::exists(public_path($product->thumb_image))){
        File::delete(public_path($product->thumb_image));
      }

      $image = $request->thumb_image;
      $uniqueName = Str::random(10) . '_' . time() . '.' . $image->getClientOriginalExtension();
      $image->move(public_path('uploads'), $uniqueName);

      $path = "/uploads/".$uniqueName;
      $product->thumb_image = $path;
    }
    

    $product->name = $request->name;
    $product->qty = $request->qty;
    $product->price = $request->price;
    $product->offer_price = $request->offer_price;
    $product->category_id = $request->category_id;
    $product->offer_start_date = $request->offer_start_date;
    $product->offer_end_date = $request->offer_end_date;
    $product->supplier_id = $request->supplier_id;
    $product->status = $request->status;
    $product->save();
    toastr()->success('Product is updated!', 'Success');
    return redirect()->route('show-products');
  }

  public function deletePro($id){
    $product = Product::findOrFail($id);
    
    if(File::exists(public_path($product->thumb_image))){
      File::delete(public_path($product->thumb_image));
    }

    $product->delete();
    toastr()->success('Product is deleted!', 'Success');
    return redirect()->back();
  }


  public function productDestroy($id){
    $product = Product::findOrFail($id);

    $variant = ProductVariant::where('product_id', $product->id)->count();
    if($variant > 0){
      toastr()->error('Please delete the variants first!');
      return redirect()->back();
    }else{
      if(File::exists(public_path($product->thumb_image))){
        File::delete(public_path($product->thumb_image));
      }
      
    $product->delete();
    toastr()->success('Product is deleted!', 'Success');
    return redirect()->back();
    }

  }


  public function searchProduct(Request $request){
    $search = $request->search_product;
    $products = Product::with('supplier', 'category') // Eager load relationships
                           ->where('name', 'like', '%'.$search.'%')
                           ->paginate(5); 

    return view('show-products', compact('products'));
  }



  public function search_order_product(Request $request){
    $search = $request->search_order_product;
    $products = Product::where('name', 'like', '%'.$search.'%')
                           ->paginate(5); 


   return view('product', compact('products'));
  }
}
