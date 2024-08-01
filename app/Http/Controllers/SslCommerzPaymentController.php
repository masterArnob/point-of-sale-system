<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Session;
use Cart;
class SslCommerzPaymentController extends Controller
{



  public function index(Request $request)
  {
    # Here you have to receive all the order data to initate the payment.
    # Let's say, your oder transaction informations are saving in a table called "orders"
    # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

    $post_data = array();
    $post_data['total_amount'] = getTotal(); # You cant not pay less than 10
    $post_data['currency'] = "BDT";
    $post_data['tran_id'] = uniqid(); // tran_id must be unique
    $post_data['invoice_id'] = uniqid();
    $post_data['sub_total'] = getSubTotal();
    $post_data['amount'] = getTotal();
    $post_data['payment_method'] = 'Online payment using SSlzCommerz';
    $post_data['payment_status'] = '1';
    $post_data['order_address'] = json_encode(Session::get('address'));
    $post_data['coupon'] = json_encode(Session::get('coupon'));
    $post_data['product_qty'] = Cart::content()->count();
    $post_data['order_status'] = 1;
    $post_data['status'] = 1;

    # CUSTOMER INFORMATION
    $post_data['cus_name'] = 'Customer Name';
    $post_data['cus_email'] = 'customer@mail.com';
    $post_data['cus_add1'] = 'Customer Address';
    $post_data['cus_add2'] = "";
    $post_data['cus_city'] = "";
    $post_data['cus_state'] = "";
    $post_data['cus_postcode'] = "";
    $post_data['cus_country'] = "Bangladesh";
    $post_data['cus_phone'] = '8801XXXXXXXXX';
    $post_data['cus_fax'] = "";

    # SHIPMENT INFORMATION
    $post_data['ship_name'] = "Store Test";
    $post_data['ship_add1'] = "Dhaka";
    $post_data['ship_add2'] = "Dhaka";
    $post_data['ship_city'] = "Dhaka";
    $post_data['ship_state'] = "Dhaka";
    $post_data['ship_postcode'] = "1000";
    $post_data['ship_phone'] = "";
    $post_data['ship_country'] = "Bangladesh";

    $post_data['shipping_method'] = "NO";
    $post_data['product_name'] = "Computer";
    $post_data['product_category'] = "Goods";
    $post_data['product_profile'] = "physical-goods";

    # OPTIONAL PARAMETERS
    $post_data['value_a'] = "ref001";
    $post_data['value_b'] = "ref002";
    $post_data['value_c'] = "ref003";
    $post_data['value_d'] = "ref004";

    #Before  going to initiate the payment order status need to insert or update as Pending.
    #Before going to initiate the payment, order status need to insert or update as Pending.
    $order = Order::updateOrCreate(
      ['transaction_id' => $post_data['tran_id']],
      [
        'invoice_id' => $post_data['invoice_id'],
        'sub_total' => $post_data['sub_total'],
        'amount' => $post_data['amount'],
        'product_qty' => $post_data['product_qty'],
        'payment_method' => $post_data['payment_method'],
        'shipping_method' => $post_data['shipping_method'],
        'payment_status' => 1,
        'order_address' => $post_data['order_address'],
        'order_status' => $post_data['order_status'],
        'coupon' => $post_data['coupon'],
        'status' => $post_data['status'],
        'currency' => $post_data['currency']
      ]
    );

    // Save order products
    foreach (Cart::content() as $item) {
      $product = Product::findOrFail($item->id);
      $orderProduct = new OrderProduct();
      $orderProduct->order_id = $order->id;
      $orderProduct->product_id = $product->id;
      $orderProduct->product_name = $product->name;
      $orderProduct->variants = json_encode($item->options->variants);
      $orderProduct->variants_total = $item->options->variants_total;
      $orderProduct->unit_price = $item->price;
      $orderProduct->qty = $item->qty;
      $orderProduct->save();


      $currentQty = $product->qty;
      $newQty = ($currentQty - $item->qty);
      $product->qty = $newQty;
      $product->save();
    }

    $transaction = new Transaction();
    $transaction->order_id = $order->id;
    $transaction->transaction_id = $post_data['tran_id'];
    $transaction->amount = getTotal();
    $transaction->save();

    $sslc = new SslCommerzNotification();

    Cart::destroy();
    Session::forget('shipping_method');
    Session::forget('shipping_address');
    Session::forget('coupon');


    # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
    $payment_options = $sslc->makePayment($post_data, 'hosted');

    if (!is_array($payment_options)) {
      print_r($payment_options);
      $payment_options = array();
    }
  }

    public function payViaAjax(Request $request)
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "orders"
        # In orders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table('orders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function success(Request $request)
    {
     

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
      
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

          if($validation){
            return "Transaction is Successful
            <br>
            <br>
    <a href='" . route('orders') . "' class='btn btn-success'>Orders</a>";

          }
           
        }


    

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);
            echo "Transaction is Falied";
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }

    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);
            echo "Transaction is Cancel";
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }


    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    echo "Transaction is successfully Completed";
                }
            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }

}
