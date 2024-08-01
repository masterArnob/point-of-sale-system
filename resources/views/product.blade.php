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
        .variant-column {
            width: 250px; 
        }
    </style>
    <div class="card">
        <div class="card-header bg-light d-flex justify-content-between">
            <h3>Order Products</h3>
            <div class="ml-auto">
              <form action="{{route('search-order-product')}}" method="GET" class="d-flex">
                  <input type="text" name="search_order_product" class="form-control">
                  <button class="btn btn-success ml-2" type="submit">Search</button>
              </form>
          </div>
            <a href="{{ route('cart-details') }}" class="btn btn-primary">Cart Details</a>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Variants</th>
                        <th scope="col">Price</th>
                        <th scope="col">Offer Price</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <form class="shopping-cart-form">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <tr>
                                <th scope="row">{{ $product->id }}</th>
                                <td>
                                  <img width="150px" class="img-thumbnail" src="{{asset($product->thumb_image)}}" alt="">
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{$product->category->name}}</td>
                                <td class="variant-column">
                                    @if ($product->productVariant->isEmpty())
                                        No Variant
                                    @else
                                        @foreach ($product->productVariant as $variant)
                                      @if ($variant->status == '1')
                                      <label for="" class="form-label mt-3">{{ $variant->name }}</label>
                                      <select name="variants_items[]" class="form-control">
                                          @foreach ($variant->variantItem as $variantItem)
                                          @if ($variantItem->status == '1')
                                          <option value="{{ $variantItem->id }}"><b>{{ $variantItem->name }}</b>: (
                                            +{{ $variantItem->price }}TK)</option>
                                          @endif
                                        
                                          @endforeach

                                      </select>
                                      @endif
                                        @endforeach
                                    @endif
                                </td>
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
                                  <button type="submit" class="btn btn-sm btn-info">Add to cart</button>
                                </td>
                            </tr>
                            <tr class="border-bottom mt-2 mb-2"></tr>
                        </form>
                      
                    @endforeach

                </tbody>
            </table>
            <div class="card-footer">
              {{$products->links()}}
            </div>
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


            $('.shopping-cart-form').on('submit', function(e) {
                e.preventDefault()
                let formData = $(this).serialize()

                $.ajax({
                    url: "{{ route('add-to-cart') }}",
                    method: 'POST',
                    data: formData,

                    success: function(data) {
                        if (data.status == 'success') {
                            toastr.success(data.message, 'Success');
                        } else if (data.status == 'error') {
                            toastr.error(data.message, 'Error')
                        }
                    },
                    error: function(data) {
                        console.log(data)
                    }
                })

            })


     
        })
    </script>
@endsection
