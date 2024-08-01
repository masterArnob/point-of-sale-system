@extends('admin.layout.master')
@section('content')
    @php
        $address = json_decode($order->order_address);
        $coupon = json_decode($order->coupon);
    @endphp


<section class="section">


  <div class="section-body">
      <div class="invoice">
          <div class="invoice-print">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="invoice-title">
                          <h2 class="text-center">FutureTech</h2>
                          <h2 >Cash Memo</h2>
                          <div class="invoice-number">Invoice ID #{{ $order->invoice_id }}</div>
                      </div>
                      <hr>
                      <div class="row">
                          <div class="col-md-6">
                              <address>
                                 <h5> <strong>Billed To:</strong><br><br></h5>
                                <b>Name: </b>{{ $address->name }}<br>
                                <b>Email Address: </b>{{ $address->email }}<br>
                                <b>Contact: </b>{{ $address->phone }}<br>
                                <b>Address: </b>{{ $address->city }}, {{ $address->state }} {{ $address->zip }}<br>
                                  {{ $address->country }}
                              </address>
                          </div>
                          <div class="col-md-6 text-md-right">
                              <address>
                                  <strong>Shipped To:</strong><br><br>
                                  <b>Name: </b>{{ $address->name }}<br>
                                  <b>Email Address: </b>{{ $address->email }}<br>
                                  <b>Contact: </b>{{ $address->phone }}<br>
                                  <b>Address: </b>{{ $address->city }}, {{ $address->state }}
                                  {{ $address->zip }}<br>
                                  {{ $address->country }}
                              </address>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-6">
                              <address>
                                  <strong>Payment Information:</strong><br><br>
                                  <b>Method: </b>{{$order->payment_method}}  <br>
                                  <b>Transaction ID: </b>{{ $order->transaction->transaction_id }}
                              </address>
                          </div>
                          <div class="col-md-6 text-md-right">
                              <address>
                                  <strong>Order Date:</strong><br>
                                  {{ date('d F, Y', strtotime($order->created_at)) }}<br><br>
                              </address>
                          </div>
                      </div>
                  </div>
              </div>

              <div class="row mt-4">
                  <div class="col-md-12">
                      <div class="section-title">Order Summary</div>
                      <p class="section-lead">Sold items are non-returnable & non-refundable</p>
                      <div class="table-responsive">
                          <table class="table table-striped table-hover table-md">
                              <tr>
                                  <th data-width="40">#</th>
                                  <th>Item</th>
                                  <th class="text-center">Variants</th>
                                  <th class="text-center">Quantity</th>
                                  <th class="text-center">Unit Price</th>
                                  <th class="text-center">Price</th>


                              </tr>
                              @foreach ($order->orderProducts as $product)
                                  @php
                                      $variants = json_decode($product->variants);
                                  @endphp
                                  <tr>
                                      <td>{{ ++$loop->index }}</td>
                                      <td>{{ $product->product_name }}</td>
                                      <td class="text-center">
                                          @foreach ($variants as $key => $variant)
                                              <b>{{ $key }}: {{ $variant->name }}
                                                  (+${{ $variant->price }})</b><br>
                                          @endforeach
                                      </td>
                                      <td class="text-center">{{ $product->qty }}</td>
                                      <td class="text-center">${{ $product->unit_price }} TK</td>
                                      <td class="text-center">
                                          {{ ($product->unit_price + $product->variants_total) * $product->qty }} TK
                                      </td>

                                  </tr>
                              @endforeach


                          </table>
                      </div>
                      <div class="row mt-4">
                          <div class="col-lg-8">

                          </div>
                          <div class="col-lg-4 text-right">
                              <div class="invoice-detail-item">
                                  <div class="invoice-detail-name">Subtotal</div>
                                  <div class="invoice-detail-value">{{ $order->sub_total }} TK</div>
                              </div>
                              <div class="invoice-detail-item">
                                  <div class="invoice-detail-name">Coupon(-)</div>
                                  <div class=""><b>Code: </b> {{ @$coupon->code }} <br>
                                      @if (@$coupon->discount_type == 'amount')
                                          <b>Discount: </b> {{ @$coupon->discount }} TK 
                                      @elseif(@$coupon->discount_type == 'percent')
                                          <b>Discount: </b> {{ @$coupon->discount }}% 
                                      @else
                                          <b>Discount: </b> 0
                                      @endif
                                  </div>
                              </div>

                              {{--
             <div class="invoice-detail-item">
        <div class="invoice-detail-name">Shipping</div>
        <div class="invoice-detail-value">$15</div>
      </div>
      --}}




                              <hr class="mt-2 mb-2">
                              <div class="invoice-detail-item">
                                  <div class="invoice-detail-name">Total</div>
                                  <div class="invoice-detail-value invoice-detail-value-lg">
                                    {{ $order->amount }} TK
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <hr>
          <div class="text-md-right">

              <button class="print btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button>
          </div>
      </div>
  </div>
</section>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function() {
      $('.print').on('click', function() {
          let printBody = $('.invoice-print')
          let originalContent = $('body').html()

          $('body').html(printBody.html())
          window.print()
          $('body').html(originalContent)
      })
  })
</script>


@endsection
