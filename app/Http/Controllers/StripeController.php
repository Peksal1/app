<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Purchases;
use Illuminate\Http\Request;
use Stripe\Product;
use Stripe\Price;
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
            return redirect('/thank-you?order=' . $purchase->uuid);
        } else {
            return redirect('/store');
        }
    }
}
