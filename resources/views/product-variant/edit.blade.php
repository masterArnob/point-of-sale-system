@extends('admin.layout.master')
@section('content')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">







    <div class="card">
      <div class="card-header">
          <h3>Edit Variant</h3>
      </div>
      <div class="card-body">
        <form action="{{route('product-variant.update', $variant->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
   

        <label for="" class="form-label mt-3"> <b> Name: </b></label>
        <input type="text" class="form-control" name="name" value="{{$variant->name}}">


        <input type="hidden" name="product_id" value="{{$product_id}}">

        <label for="" class="form-label mt-3"><b>Status</b></label>
        <select name="status" class="form-control">
          <option {{$variant->status == '1' ? 'selected' : ''}} value="1">Active</option>
          <option {{$variant->status == '0' ? 'selected' : ''}} value="0">Inactive</option>
        </select>
   
        <button class="btn btn-info mt-4">Update</button>
      </form>
      </div>
  </div>


    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



@endsection
