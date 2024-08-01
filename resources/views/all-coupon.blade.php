@extends('admin.layout.master')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    <div class="card">
        <div class="card-header bg-light d-flex justify-content-between">
            <h3>All Coupon</h3>
            <a href="{{route('coupon.create')}}" class="btn btn-primary">Create Coupon</a>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Code</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
                        <th scope="col">Discount Type</th>
                        <th scope="col">Discount</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
               @foreach ($coupons as $coupon)
               <tr>
                
                <td>{{$coupon->id}}</td>
                <td>{{$coupon->name}}</td>
                <td>{{$coupon->code}}</td>
                <td>{{$coupon->start_date}}</td>
                <td>{{$coupon->end_date}}</td>
                <td>{{$coupon->discount_type}}</td>
                <td>{{$coupon->discount}}</td>
                <td>
                  @if ($coupon->status == '1')
                      <span class="badge badge-success">Active</span>
                  @else
                  <span class="badge badge-danger">Inative</span>
                  @endif
                </td>
                <td>
                  <a href="{{route('coupon.edit', $coupon->id)}}" class="btn btn-info">Edit</a>
                  <form action="{{route('coupon.destroy', $coupon->id)}}" method="POST" style="display: inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Delete</button>
                  </form>
                </td>
          
          
            
            </tr>
               @endforeach

                </tbody>
            </table>
            <div class="card-footer">
              {{$coupons->links()}}
            </div>
        </div>
    </div>


    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@endsection
