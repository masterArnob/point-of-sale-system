@extends('admin.layout.master')
@section('content')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">







    <div class="card">
      <div class="card-header">
          <h3>Edit Supplier</h3>
      </div>
      <div class="card-body">
        <form action="{{route('supplier.update', $sup->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="" class="form-label mt-3"> <b> Company Name: </b></label>
        <input type="text" class="form-control" name="name" value="{{$sup->name}}">

        <label for="" class="form-label mt-3"> <b>Supplier Name: </b></label>
        <input type="text" class="form-control" name="sname" value="{{$sup->sname}}">


        <label for="" class="form-label mt-3"> <b> Email Address: </b></label>
        <input type="email" class="form-control" name="email" value="{{$sup->email}}">

        <label for="" class="form-label mt-3"> <b> Contact: </b></label>
        <input type="text" class="form-control" name="phone" value="{{$sup->phone}}">

        <label for="" class="form-label mt-3"> <b> Address: </b></label>
        <input type="text" class="form-control" name="address" value="{{$sup->address}}">

      

        <label for="" class="form-label mt-3"><b>Status</b></label>
        <select name="status" class="form-control">
          <option {{$sup->status == '1' ? 'selected' : ''}} value="1">Active</option>
          <option {{$sup->status == '0' ? 'selected' : ''}} value="0">Inactive</option>
        </select>
   
        <button class="btn btn-info mt-4">Update</button>
      </form>
      </div>
  </div>


    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



@endsection
