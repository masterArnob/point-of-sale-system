@extends('admin.layout.master')
@section('content')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">




    <form class="checkoutForm">


    <section class="">
        <div class="row">
          <div class="col-lg-8 mb-4">


            <div class="card">
                <div class="card-header">
                    <h3>Customer Address</h3>
                </div>
                <div class="card-body">
                    <label for="" class="form-label"> <b> Name: *</b></label>
                    <input type="text" class="form-control" name="name">

                    <label for="" class="form-label mt-3"> <b> Email Address: *</b></label>
                    <input type="email" class="form-control" name="email">

                    <label for="" class="form-label mt-3"><b>Contact: *</b></label>
                    <input type="text" class="form-control" name="phone">

                    <label for="" class="form-label mt-3"><b>Address: *</b></label>
                    <textarea name="address" class="form-control"></textarea>
                

                    <label for="" class="form-label mt-3"> <b> Country: </b></label>
                    <input type="text" class="form-control" name="country">

                    <label for="" class="form-label mt-3"> <b> City: *</b></label>
                    <input type="text" class="form-control" name="city">

                    <label for="" class="form-label mt-3"> <b> State: </b></label>
                    <input type="text" class="form-control" name="state">

                    <label for="" class="form-label mt-3"> <b> Zip: </b></label>
                    <input type="text" class="form-control" name="zip">
                </div>
            </div>
        </div>
        <div class="col-lg-4 d-flex justify-content-center  mt-5">
            <div class="ms-lg-4 mt-4 mt-lg-0">
                <h4 class="mb-5">Purchase</h4>





                <div class="d-flex justify-content-between">



                    <h5 class="mb-2"> <b>Subtotal: </b></h5>
                    <h5 class="mb-2 px-4">{{ getSubTotal() }} TK</h5>
                </div>
                <div class="d-flex justify-content-between">
                    <h5 class="mb-2"><b>Coupon</b>:</h5>
                    <h5 class="mb-2 text-danger  px-4">-{{ getDiscount() }} TK</h5>
                </div>

                <hr />
                <div class="d-flex justify-content-between">
                    <h5 class="mb-2"><b>Total price</b>:</h5>
                    <h5 class="mb-2  px-4 fw-bold currentTotal" data-id="{{ getTotal() }}">{{ getTotal() }} TK
                    </h5>
                </div>

                <button class="btn btn-primary mt-5" type="submit">Place Order</button>






            </div>
        </div>

        </div>

    </section>
  </form>

    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
      @if ($errors->any())
        @foreach ($errors->all() as $err)
            toastr.error("{{$err}}", 'Error')
        @endforeach
    @endif
    </script>
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $('.checkoutForm').on('submit', function(e){
              e.preventDefault()
              let formData = $(this).serialize()
         
              $.ajax({
                url: "{{route('place-order')}}",
                method: 'POST',
                data: formData,

                success: function(data){
                  if(data.status == 'success'){
                    toastr.success(data.message, 'Success') 
                    window.location.href = data.redirect_link
                  }
                },
                error: function(data){

                }
              })
            })
        })
    </script>
@endsection
