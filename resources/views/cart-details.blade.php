@extends('admin.layout.master')
@section('content')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        .qty {
            width: 70px;
        }

        .shopping-cart-footer {
            display: table;
            width: 100%;
            padding: 10px 0;
            border-top: 1px solid #e1e7ec
        }

        .shopping-cart-footer>.column {
            display: table-cell;
            padding: 5px 0;
            vertical-align: middle
        }

        .shopping-cart-footer>.column:last-child {
            text-align: right
        }

        .shopping-cart-footer>.column:last-child .btn {
            margin-right: 0;
            margin-left: 15px
        }

        @media (max-width: 768px) {
            .shopping-cart-footer>.column {
                display: block;
                width: 100%
            }

            .shopping-cart-footer>.column:last-child {
                text-align: center
            }

            .shopping-cart-footer>.column .btn {
                width: 100%;
                margin: 12px 0 !important
            }
        }

        .coupon-form .form-control {
            display: inline-block;
            width: 100%;
            max-width: 235px;
            margin-right: 12px;
        }

        .form-control-sm:not(textarea) {
            height: 36px;
        }
    </style>


    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

    <div class="card">
        <div class="card-header">
            <h4>Cart Details</h4>
        </div>
        <div class="card-body">
            <div class=" padding-bottom-3x mb-1">
                <!-- Shopping Cart-->
                <div class="table-responsive shopping-cart">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Unit Price</th>
                                <th scope="col">Price</th>
                                <th scope="col">Qty</th>
                                <th scope="col">
                                    <a href="" class="clear btn btn-danger">Clear</a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartItems as $item)
                                <tr>
                                    <th scope="row">{{ ++$loop->index }}</th>
                                    <td>
                                      <img src="{{asset($item->options->thumb_image)}}" width="150px">
                                    </td>
                                    <td>
                                        <h6><b>{{ $item->name }}</b>
                                            <br>
                                            @foreach ($item->options->variants as $key => $variant)
                                                <span><b>{{ $key }}</b>: {{ $variant['name'] }}
                                                    (+{{ $variant['price'] }}TK) <br></span>
                                            @endforeach

                                        </h6>

                                    </td>
                                    <td>
                                        <h6>{{ $item->price }} TK</h6>
                                    </td>

                                    <td>
                                        <h6 class="{{ $item->rowId }}">
                                            {{ ($item->price + $item->options->variants_total) * $item->qty }} TK</h6>
                                    </td>

                                    <td>
                                        <div class="d-flex">
                                            <button class="btn btn-danger decrement-btn">-</button>
                                            <input data-rowid="{{ $item->rowId }}" class="form-control qty" name="qty"
                                                type="number" min="1" value="{{ $item->qty }}">
                                            <button class="btn btn-success increment-btn">+</button>
                                        </div>
                                    </td>

                                    <td>

                                        <a href="{{ route('remove-item', $item->rowId) }}"
                                            class="btn btn-danger ">Remove</a>
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
                <div class="shopping-cart-footer">
                    <div class="column">
                        <form class="coupon-form">
                            <input name="coupon_code" class="form-control form-control-sm" type="text"
                                placeholder="Coupon code">
                            <button class="btn btn-outline-primary btn-sm" type="submit">Apply Coupon</button>
                        </form>
                    </div>
                    <div class=" text-lg">Subtotal: <span class="text-medium subtotal">{{ getSubTotal() }} TK</span></div>
                    <div class=" text-lg">Coupon(-): <span
                            class="text-medium text-danger discount">{{ getDiscount() }} TK</span>
                    </div>
                    <div class=" text-lg">Total: <span class="text-medium total">{{ getTotal() }} TK</span></div>
                </div>
                <div class="shopping-cart-footer">
                    <div class="column"><a class="btn btn-success" href="{{ route('checkout') }}">Checkout</a></div>
                </div>
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



            $('.increment-btn').on('click', function() {
                let input = $(this).siblings('.qty')
                let qty = parseInt(input.val()) + 1
                input.val(qty)
                let rowId = input.data('rowid')
                $.ajax({
                    url: "{{ route('qty-update') }}",
                    method: 'GET',
                    data: {
                        rowId: rowId,
                        qty: qty
                    },

                    success: function(data) {
                        if (data.status == 'success') {
                            let productId = '.' + rowId
                            $(productId).text(data.productTotal+' TK')
                            subtotal()
                            couponCalculation()
                            toastr.success(data.message, 'Success')
                        } else if (data.status == 'error') {
                            toastr.error(data.message, 'Error')
                        }
                    },
                    error: function(data) {

                    }
                })

            })


            $('.decrement-btn').on('click', function() {
                let input = $(this).siblings('.qty')
                let qty = parseInt(input.val()) - 1

                if (qty < 1) {
                    qty = 1
                }
                input.val(qty)
                let rowId = input.data('rowid')
                $.ajax({
                    url: "{{ route('qty-update') }}",
                    method: 'GET',
                    data: {
                        rowId: rowId,
                        qty: qty
                    },

                    success: function(data) {
                        let productId = '.' + rowId
                        $(productId).text(data.productTotal+' TK')
                        subtotal()
                        couponCalculation()
                        toastr.success(data.message, 'Success')
                    },
                    error: function(data) {

                    }
                })

            })

            function subtotal() {
                $.ajax({
                    url: "{{ route('sub-total') }}",
                    method: 'POST',

                    success: function(data) {
                        console.log(data)
                        $('.subtotal').text(data+' TK')
                    },
                    error: function(data) {

                    }
                })
            }


            $('.coupon-form').on('submit', function(e) {
                e.preventDefault()
                let formData = $(this).serialize()
                $.ajax({
                    url: "{{ route('apply-coupon') }}",
                    method: 'GET',
                    data: formData,

                    success: function(data) {
                        if (data.status == 'error') {
                            toastr.error(data.message, 'Error')

                        } else if (data.status == 'success') {
                            couponCalculation()
                            toastr.success(data.message, 'Success')
                        }
                    },
                    error: function(data) {

                    }
                })
            })


            function couponCalculation() {
                $.ajax({
                    url: "{{ route('coupon-calculation') }}",
                    method: 'GET',

                    success: function(data) {
                        if (data.status == 'success') {
                            // console.log('Total :'+data.cart_total)
                            //console.log('discount :'+data.discount)
                            $('.discount').text(data.discount+' TK')
                            $('.total').text(data.cart_total+' TK')
                        }
                    },
                    error: function(data) {

                    }
                })
            }


            $('.clear').on('click', function(e) {
                e.preventDefault()
                $.ajax({
                    url: "{{ route('clear-cart') }}",
                    method: 'GET',
                    success: function(data) {
                        if (data.status == 'success') {
                            window.location.reload()
                        }
                    },
                    error: function(data) {

                    }
                })
            })
        })
    </script>
@endsection
