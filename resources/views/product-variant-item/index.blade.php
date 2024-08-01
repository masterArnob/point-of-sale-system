@extends('admin.layout.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    </style>



    <div class="card">
        <div class="card-header bg-light d-flex justify-content-between">
            <h3>All Variant Items of
              <br>Product: {{$product->name}}
              <br>
              Variant: {{$variant->name}}
            </h3>
          <div>
            <a href="{{route('variant-item-create', ['product_id' => $product->id, 'variant_id' => $variant->id])}}" class="btn btn-primary">Create</a>
            <a href="{{route('product-variant.index', ['product_id' => $product->id])}}" class="btn btn-success">Back</a>
          </div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Variant Item Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Is Default</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                  @foreach ($items as $item)
                  <tr>
                    <td>{{++$loop->index}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->price}} TK</td>
                    <td>
                     @if ($item->is_default == '1')
                         <span class="badge badge-success">Yes</span>
                     @else
                     <span class="badge badge-danger">No</span>
                     @endif
                    </td>
                    <td>
                      @if ($item->status == '1')
                      <span class="badge badge-success">Active</span>
                  @else
                  <span class="badge badge-danger">Inactive</span>
                  @endif
                    </td>
                    <td>
                      <a href="{{route('variant-item-edit', ['product_id' => $product->id, 'variant_id' => $variant->id, 'item_id' => $item->id])}}" class="btn btn-info">Edit</a>
                      
                      <form action="{{route('delete-variant-item', $item->id)}}" method="POST" style="display: inline">
                        @csrf
                        @method('DELETE')
                        <Button class="btn btn-danger">Delete</Button>
                      </form>

                    </td>
                   </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>


   

    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@endsection
