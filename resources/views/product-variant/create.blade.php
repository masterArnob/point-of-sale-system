@extends('admin.layout.master')
@section('content')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">







    <div class="card">
      <div class="card-header">
          <h3>Create Variant</h3>
      </div>
      <div class="card-body">
        <form action="{{route('product-variant.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
   

        <label for="" class="form-label mt-3"> <b> Name: </b></label>
        <input type="text" class="form-control" name="name">


        <input type="hidden" name="product_id" value="{{request()->product_id}}">

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
