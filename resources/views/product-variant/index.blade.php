@extends('admin.layout.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    </style>

    <div class="card">
      <div class="card-body text-center">
        <img src="{{asset($product->thumb_image)}}" width="160px">
      </div>
    </div>

    <div class="card">
        <div class="card-header bg-light d-flex justify-content-between">
            <h3>All Variants of Product: {{$product->name}}</h3>
          <div>
            <a href="{{route('product-variant.create', ['product_id' => request()->product_id])}}" class="btn btn-primary">Create</a>
            <a href="{{route('show-products')}}" class="btn btn-success">Back</a>
          </div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Variant Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    
              @foreach ($variants as $variant)
              <tr>
                <td>{{++$loop->index}}</td>
                <td>{{$variant->name}}</td>
                <td>
                  @if ($variant->status == '1')
                      <span class="badge badge-success">Active</span>
                  @else
                  <span class="badge badge-danger">Inactive</span>
                  @endif
                </td>
                <td>
                  <a href="{{route('product-variant.edit', ['product_id' => request()->product_id, $variant->id])}}" class="btn btn-info">Edit</a>
             
                  <form method="POST" action="{{route('product-variant.destroy', $variant->id)}}" style="display: inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Delete</button>
                  </form>
                  <a href="{{route('variant-item', ['product_id' => request()->product_id, $variant->id])}}" class="btn btn-warning">Variant items</a>
                </td>
              </tr>
              @endforeach
                </tbody>
            </table>
        </div>
    </div>


   

    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@endsection
