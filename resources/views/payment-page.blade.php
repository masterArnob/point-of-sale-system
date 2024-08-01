@extends('admin.layout.master')
@section('content')
    <div class="d-flex mt-5 px-5">
      <a href="{{route('hand-cash')}}" class="btn btn-success px-5">Pay HandCash</a>
      <form action="{{route('ssl-pay')}}" method="POST">
        @csrf
        <button type="submit" class="btn btn-info px-5">Pay with SSLCommerz</button>
      </form>
    </div>
@endsection