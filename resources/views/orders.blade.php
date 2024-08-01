@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-header d-flex">
            <h4>Orders Table</h4>
            <div class="ml-auto">
                <form action="{{route('search-order')}}" method="GET" class="d-flex">
                    <input type="text" name="search_order" class="form-control">
                    <button class="btn btn-success ml-2" type="submit">Search</button>
                </form>
            </div>
        </div>


    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-md">
                <tr>
                    <th>#</th>
                    <th>Invoice ID</th>
                    <th>Date</th>
                    <th>Product Qty</th>
                    <th>Sub Total</th>
                    <th>Payment Method</th>
                    <th>Transaction ID</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->invoice_id }}</td>
                        <td>{{ date('d-M-y', strtotime($order->created_at)) }}</td>
                        <td>{{ $order->product_qty }}</td>
                        <td>{{ $order->sub_total }}TK</td>
                        <td>{{ $order->payment_method }}</td>
                        <td>{{ $order->transaction_id }}</td>
                        <td>{{ $order->amount }}TK</td>

                        <td><a href="{{ route('show', $order->id) }}" class="btn btn-primary">View</a></td>
                    </tr>
                @endforeach


            </table>
           <div class="card-footer">
            {{ $orders->links() }}
           </div>
        </div>
    </div>

    </div>
@endsection
