@extends('admin.layout.master')
@section('content')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">







    <div class="card">
      <div class="card-header d-flex justify-content-between">
          <h3>Create Variant Item</h3>
          <a href="{{route('variant-item', ['product_id' => $product->id, 'variant_id' => $variant->id])}}">Back</a>
      </div>
      <div class="card-body">
        <form action="{{route('variant-item-store')}}" method="POST" enctype="multipart/form-data">
        @csrf
   

        <input type="hidden" name="product_id" value="{{$product->id}}">
        <input type="hidden" name="product_variant_id" value="{{$variant->id}}">

        <label for="" class="form-label mt-3"> <b>Variant Name: </b></label>
        <input type="text" class="form-control" value="{{$variant->name}}" disabled>

        <label for="" class="form-label mt-3"> <b>Variant Item Name: </b></label>
        <input type="text" class="form-control" name="name">

        <label for="" class="form-label mt-3"> <b> Price: </b></label>
        <input type="text" class="form-control" name="price">


        <label for="" class="form-label mt-3"><b>Is Default</b></label>
        <select name="is_default" class="form-control">
          <option value="1">Yes</option>
          <option value="0">No</option>
        </select>


        <label for="" class="form-label mt-3"><b>Status</b></label>
        <select name="status" class="form-control">
          <option value="1">Active</option>
          <option value="0">Inactive</option>
        </select>
   
        <button class="btn btn-info mt-4">Save</button>
      </form>
      </div>
  </div>


    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



@endsection
