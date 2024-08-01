@extends('admin.layout.master')
@section('content')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">







    <div class="card">
      <div class="card-header">
          <h3>Create Product</h3>
      </div>
      <div class="card-body">
        <form action="{{route('product-save')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="" class="form-label"> <b> Thumb Image: </b></label>
        <input type="file" class="form-control" name="thumb_image">

        <label for="" class="form-label mt-3"><b>Supplier</b></label>
        <select name="supplier_id" class="form-control">
       <option>Select</option>
         @foreach ($sups as $sup)
          <option value="{{$sup->id}}">{{$sup->name}}</option>
         @endforeach
        </select>
        
        <label for="" class="form-label mt-3"> <b> Name: </b></label>
        <input type="text" class="form-control" name="name">


        <label for="" class="form-label mt-3"><b>Category</b></label>
        <select name="category_id" class="form-control">
       <option>Select</option>
         @foreach ($cats as $cat)
          <option value="{{$cat->id}}">{{$cat->name}}</option>
         @endforeach
        </select>


        <label for="" class="form-label mt-3"><b>Quantity: </b></label>
        <input type="text" class="form-control" name="qty">

        <label for="" class="form-label mt-3"><b>Price: </b></label>
       <input type="text" name="price" class="form-control">
    

        <label for="" class="form-label mt-3"> <b> Offer Price: </b></label>
        <input type="text" class="form-control" name="offer_price">

        <label for="" class="form-label mt-3"> <b> Offer Start Date: (ex: Y-m-d)</b></label>
        <input type="text" class="form-control" name="offer_start_date">

        <label for="" class="form-label mt-3"> <b> Offer End Date: (ex: Y-m-d)</b></label>
        <input type="text" class="form-control" name="offer_end_date">

        <label for="" class="form-label mt-3">Status</label>
        <select name="status" class="form-control">
          <option value="1">Active</option>
          <option value="0">Inactive</option>
        </select>
   
        <button class="btn btn-info mt-4">Save</button>
      </form>
      </div>
  </div>


    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


   
        })
    </script>
@endsection
