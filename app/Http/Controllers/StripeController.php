<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Purchases;
use Illuminate\Http\Request;
use Stripe\Product;
use Stripe\Price;
use App\Models\Orders;
use App\Models\Order_purchases;
use App\Models\Digital_painting;
use App\Models\Digital_purchase;
use Stripe\Checkout\Session;


class StripeController extends Controller
{
    public function createPaymentSession(Request $request)
    {
        $shop = Shop::findOrFail($request->product);
        // create a new Pruchase
        $purchase = Purchases::create([
            'uuid' =>  time(),
            'user_id' => auth()->user()->id,
            'product_id' => $request->product,
            'status' => 'pending',
            'is_paid' => 0,
            'tnx_id' => '',
            'Price' => $shop->price_in_eur,
        ]);
        
        \Stripe\Stripe::setApiKey('sk_test_7NyImHAKY2arJv2aDu9jqJ1600TjVN3zFF');

        // register the product in stipe
        $product = Product::create([
            'name' => $shop->work_name,
        ]);

        $price = Price::create([
            'currency' => 'eur',
            'product' => $product['id'],
            'unit_amount' =>  $shop->price_in_eur * 100
        ]);
        $session = Session::create([
            'success_url' => url('/success?stripe_id={CHECKOUT_SESSION_ID}&order_id=' . $purchase->uuid),
            'cancel_url' =>  url('/store'),
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => [[
                'price' => $price['id'],
                'quantity' => 1,
            ]]
        ]);
        $res['session_id'] = $session['id'];

        return response()->json($res, 200);
    }

    public function createOrderPaymentSession(Request $request)
    {
        $order = Orders::where('id',$request->order)->first();
      
    
         

        \Stripe\Stripe::setApiKey('sk_test_7NyImHAKY2arJv2aDu9jqJ1600TjVN3zFF');

        // register the product in stipe
        $product = Product::create([
            'name' => $order->id,
        ]);

        $price = Price::create([
            'currency' => 'eur',
            'product' => $product['id'],
            'unit_amount' =>  $order->price * 100
        ]);
        $session = Session::create([
            'success_url' => url('/order/success?stripe_id={CHECKOUT_SESSION_ID}&order_id=' . $order->id),
            'cancel_url' =>  url('/orders'),
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => [[
                'price' => $price['id'],
                'quantity' => 1,
            ]]
        ]);
        $res['session_id'] = $session['id'];

        return response()->json($res, 200);
    }

    // DIGITAL PAINTINGS

    public function createDigitalPaintingPaymentSession(Request $request)
    {
        $digital = Digital_painting::findOrFail($request->portfolio);
        // create a new Pruchase
        $purchase = Digital_purchase::create([
            'uuid' =>  time(),
            'user_id' => auth()->user()->id,
            'digital_painting_id' => $request->portfolio,
            'status' => 'pending',
            'is_paid' => 0,
            'tnx_id' => '',
            'Price' => $digital->price,
        ]);

        \Stripe\Stripe::setApiKey('sk_test_7NyImHAKY2arJv2aDu9jqJ1600TjVN3zFF');

        // register the product in stipe
        $product = Product::create([
            'name' => $digital->portfolio_id,
        ]);

        $price = Price::create([
            'currency' => 'eur',
            'product' => $product['id'],
            'unit_amount' =>  $digital->price * 100
        ]);
        $session = Session::create([
            'success_url' => url('/digital/success?stripe_id={CHECKOUT_SESSION_ID}&digital_id=' . $purchase->uuid),
            'cancel_url' =>  url('/store'),
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => [[
                'price' => $price['id'],
                'quantity' => 1,
            ]]
        ]);
        $res['session_id'] = $session['id'];

        return response()->json($res, 200);
    }

    public function DigitalPaymentSuccess(Request $request)
    {
            $digital = Digital_purchase::where('uuid',$request->digital_id)->first();


        // check session from stripe
        \Stripe\Stripe::setApiKey('sk_test_7NyImHAKY2arJv2aDu9jqJ1600TjVN3zFF');
        $session = Session::retrieve($request->stripe_id);

        if ($session['payment_status'] == 'paid') {
            $digital->tnx_id = $request->stripe_id;
            $digital->status = 'paid';
            $digital->is_paid = 1;
            $digital->save();
            return redirect('/digital/thank-you?digital=' . $digital->uuid);
        } else {
            return redirect('/');
        }
    }

    public function orderPaymentSuccess(Request $request)
    {
            $order = Orders::where('id',$request->order_id)->first();


        // check session from stripe
        \Stripe\Stripe::setApiKey('sk_test_7NyImHAKY2arJv2aDu9jqJ1600TjVN3zFF');
        $session = Session::retrieve($request->stripe_id);

        if ($session['payment_status'] == 'paid') {
            // $order->tnx_id = $request->stripe_id;
            // $order->status = 'paid';
            $order->is_paid = 1;
            $order->save();
            return redirect('/order/thank-you?order=' . $order->id);
        } else {
            return redirect('/orders');
        }
    }


    public function paymentSuccess(Request $request)
    {
        $purchase = Purchases::where('uuid', $request->order_id)->first();
        
        // check session from stripe
        \Stripe\Stripe::setApiKey('sk_test_7NyImHAKY2arJv2aDu9jqJ1600TjVN3zFF');
        $session = Session::retrieve($request->stripe_id);

        if ($session['payment_status'] == 'paid') {
            $purchase->tnx_id = $request->stripe_id;
            $purchase->status = 'paid';
            $purchase->is_paid = 1;
            $purchase->save();
            $shop = Shop::where('id',$purchase->product_id)->first();
            $shop->is_bought = 1;
            $shop->save();
            return redirect('/thank-you?order=' . $purchase->uuid);
        } else {
            return redirect('/store');
        }
        
    }
}
