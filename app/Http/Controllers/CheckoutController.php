<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Models\Order;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function show(string $checkoutLink)
    {
        $product = Product::where('checkout_link', $checkoutLink)
            ->where('is_active', true)
            ->firstOrFail();

        return view('checkout.show', compact('product'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
            'checkout_link' => 'required|string',
        ]);

        $product = Product::where('checkout_link', $request->checkout_link)
            ->where('is_active', true)
            ->firstOrFail();

        $coupon = Coupon::where('code', $request->coupon_code)
            ->where('is_active', true)
            ->first();

        if (!$coupon) {
            return back()->with('coupon_error', 'Invalid coupon code.');
        }

        if (!$coupon->isValid()) {
            return back()->with('coupon_error', 'This coupon has expired or reached its usage limit.');
        }

        $discountAmount = $coupon->calculateDiscount($product->price);
        
        session([
            'coupon_id' => $coupon->id,
            'discount_amount' => $discountAmount
        ]);

        return back()->with('coupon_success', 'Coupon applied successfully!');
    }

    public function handlePayPalIPN(Request $request)
    {
        // Verify the payment
        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2) {
                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
        }

        // Read the post from PayPal and add 'cmd'
        $req = 'cmd=_notify-validate';
        foreach ($myPost as $key => $value) {
            $value = urlencode($value);
            $req .= "&$key=$value";
        }

        // Post back to PayPal to validate
        $ch = curl_init('https://www.paypal.com/cgi-bin/webscr');
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
        
        $res = curl_exec($ch);
        
        if (!$res) {
            \Log::error('PayPal IPN Error: ' . curl_error($ch));
            return response('IPN Error', 500);
        }
        
        curl_close($ch);

        if (strcmp($res, "VERIFIED") == 0) {
            // Check payment details
            $payment_status = $request->input('payment_status');
            $amount = $request->input('mc_gross');
            $currency = $request->input('mc_currency');
            $item_name = $request->input('item_name');
            $txn_id = $request->input('txn_id');
            $receiver_email = $request->input('receiver_email');
            $payer_email = $request->input('payer_email');

            // Find the product
            $product = Product::where('name', $item_name)->first();
            if (!$product) {
                \Log::error('PayPal IPN: Product not found - ' . $item_name);
                return response('Product not found', 404);
            }

            // Validate payment
            if ($payment_status == "Completed") {
                // Create order
                $order = Order::create([
                    'product_id' => $product->id,
                    'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                    'customer_email' => $payer_email,
                    'amount' => $amount,
                    'currency' => $currency,
                    'payment_method' => 'paypal',
                    'payment_id' => $txn_id,
                    'status' => 'completed',
                    'paid_at' => now()
                ]);

                // Send confirmation email
                Mail::to($payer_email)->send(new OrderConfirmation($order));
            }
        }

        return response('OK', 200);
    }

    public function success(string $orderNumber)
    {
        return view('checkout.success', compact('orderNumber'));
    }

    public function cancel(string $orderNumber)
    {
        return view('checkout.cancel', compact('orderNumber'));
    }
}
