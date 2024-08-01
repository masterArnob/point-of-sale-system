@extends('admin.layout.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">



    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <style>
        .input-qty {
            width: 70px;
        }
    </style>
    <div class="card">
        <div class="card-header bg-light d-flex justify-content-between">
            <h3>All Products</h3>
            <div class="ml-auto">
              <form action="{{route('search-product')}}" method="GET" class="d-flex">
                  <input type="text" name="search_product" class="form-control">
                  <button class="btn btn-success ml-2" type="submit">Search</button>
              </form>
          </div>
            <a href="{{route('create-product')}}" class="btn btn-primary">Create</a>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Supplier</th>
                        <th scope="col">Category</th>
                        <th scope="col">Price</th>
                        <th scope="col">Offer Price</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                      <th scope="row">{{$product->id}}

                        <!-- +$loop->index + $products->firstItem() -->
                      </th>
                      <td>
                        <img width="150px" class="img-thumbnail" src="{{asset($product->thumb_image)}}" alt="">
                      </td>
                      <td>{{ $product->name }}</td>
                      <td class="">{{ $product->supplier->name }}</td>
                 

                      <td>{{$product->category->name}}</td>

                      <td>{{ $product->price }} TK</td>
                      <td>
                          @php
                              $currentDate = date('Y-m-d');
                          @endphp

                          @if ($product->offer_price > 0 && $currentDate >= $product->offer_start_date && $product->offer_end_date)
                              {{ $product->offer_price }} Tk
                          @else
                              No offer going on
                          @endif

                      </td>

                    

                   


                      <td>
                        @if ($product->status == '1')
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                      </td>

                      <td>
                        <a href="{{route('edit-product', $product->id)}}" class="btn btn-warning">Edit</a>
                        <form action="{{route('product-delete', $product->id)}}" method="POST" style="display: inline">
                          @method('DELETE')
                          @csrf
                          <button class="btn btn-danger">Delete</button>
                        </form>
                        <div class="dropdown d-inline">
                          <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            More
                          </button>
                          <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                            <a class="dropdown-item has-icon" href="{{route('product-variant.index', ['product_id' => $product->id])}}"> Variants</a>
                          
                          </div>
                        </div>
                      </td>
                  </tr>
                      
                    @endforeach

                </tbody>
            </table>
            <div class="card-footer">
              {{$products->links()}}
            </div>
        </div>
    </div>


    <script src="{{asset('backend/assets/modules/popper.js')}}"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@endsection
