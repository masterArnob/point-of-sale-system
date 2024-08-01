<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $cats = Category::orderBy('created_at', 'desc')->paginate(5);
        return view('category.index', compact('cats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $request->validate([
        'name' => ['required', 'max:200'],
        'status' => ['required', 'integer']
       ]);

       $cat = new Category();
       $cat->name = $request->name;
       $cat->status = $request->status;
       $cat->save();
       toastr()->success('Category is created!', 'Success');
       return redirect()->route('category.index');
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
      $cat = Category::findOrFail($id);
      return view('category.edit', compact('cat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      $cat = Category::findOrFail($id);
      $product = Product::where('category_id', $cat->id)->count();
      if($product > 0 && $request->status == '0'){
        toastr()->error('Please delete the product first!', 'There are products under this category!');
        return redirect()->back();
      }else{
        $cat->name = $request->name;
        $cat->status = $request->status;
        $cat->save();
        toastr()->success('Category is updated!', 'Success');
        return redirect()->route('category.index');
      }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

      $cat = Category::findOrFail($id);
      $product = Product::where('category_id', $cat->id)->count();
      if($product > 0){
        toastr()->error('Please delete the product first', 'There are products under this category!');
        return redirect()->back();
      }else{
        $cat->delete();
        toastr()->success('Category is deleted!', 'Success');
        return redirect()->back();
      }
     
    }
}
