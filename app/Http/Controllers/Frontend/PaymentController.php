<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\OrderProudct;
use App\Models\PaypalSetting;
use App\Models\Proudct;
use App\Models\StripeSetting;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
// Import the class namespaces first, before using it directly
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Stripe\Charge;
use Stripe\Stripe;

class PaymentController extends Controller
{
    /**
     ** Show payment page
     ** عرض صفحة الدفع
     */
    public function index()
    {
        if (!Session::has('address')) {
            return redirect()->route('user.checkout');
        }
        return view('frontend.pages.payment');
    }

    /**
     ** Show payment success page
     ** عرض صفحة نجاح الدفع
     */
    public function paymentSuccess()
    {
        return view('frontend.pages.payment-success');
    }

    /**
     * * Paypal configuration
     * * إعدادات باي بال
     */
    public function paypalConfig(PaypalSetting $paypalSetting)
    {

        $config = [
            'mode'    => $paypalSetting->mode === 1 ? 'live' : 'sandbox',
            'sandbox' => [
                'client_id'         => $paypalSetting->client_id,
                'client_secret'     => $paypalSetting->secret_key,
                'app_id'            => 'APP-80W284485P519543T',
            ],
            'live' => [
                'client_id'         => $paypalSetting->client_id,
                'client_secret'     => $paypalSetting->secret_key,
                'app_id'            => '',
            ],

            'payment_action' => 'Sale',
            'currency'       => $paypalSetting->currency_name,
            'notify_url'     => '',
            'locale'         => 'en_US',
            'validate_ssl'   =>  false,
        ];
        return $config;
    }
    /**
     * * Pay with Paypal
     * * الدفع عبر باي بال، توجيه اليوزر الي باي بال مع تفاصيل الطلب للدفع 
     */
    public function payWithPaypal()
    {
        $paypalSetting = PaypalSetting::first();

        $config = $this->paypalConfig($paypalSetting);

        $provider = new PayPalClient($config);
        $provider->getAccessToken();


        //**calculate payable amount depending on currency rate
        $total = getFinalPayableAmount();
        $payableAmount = round($total * $paypalSetting->currency_rate, 2);


        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('user.paypal.success'),
                "cancel_url" => route('user.paypal.cancel'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => $config['currency'],
                        "value" => $payableAmount
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        } else {
            return redirect()->route('user.paypal.cancel');
        }
    }

    /**
     * * توجيه اليوزر الي صفحة نجاح الدفع
     * * Redirect user to payment success page
     * @param Request $request
     */
    public function paypalSuccess(Request $request)
    {
        $paypalSetting = PaypalSetting::first();
        $config = $this->paypalConfig($paypalSetting);
        $provider = new PayPalClient($config);
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {

            // calculate payable amount depending on currency rate
            // $paypalSetting = PaypalSetting::first();
            $total = getFinalPayableAmount();
            $paidAmount = round($total * $paypalSetting->currency_rate, 2);

            $this->storeOrder('paypal', 1, $response['id'], $paidAmount, $paypalSetting->currency_name);

            // clear session
            $this->clearSession();

            return redirect()->route('user.payment.success');
        }

        return redirect()->route('user.paypal.cancel');
    }

    /**
     ** توجيه اليوزر الي صفحة فشل الدفع
     ** Redirect user to payment failed page
     */
    public function paypalCancel()
    {
        flash()->error('Someting went wrong try agin later!');
        return redirect()->route('user.payment');
    }

    /** Stripe Payment */

    public function payWithStripe(Request $request)
    {
        // calculate payable amount depending on currency rate
        $stripeSetting = StripeSetting::first();
        $total = getFinalPayableAmount();
        $payableAmount = round($total * $stripeSetting->currency_rate, 2);

        Stripe::setApiKey($stripeSetting->secret_key);
         //!!! WARNNING: you have to remove it on live !!! */
        \Stripe\ApiRequestor::setHttpClient(new \Stripe\HttpClient\CurlClient([
            CURLOPT_SSL_VERIFYPEER => false,
        ]));
        $response = Charge::create([
            "amount" => $payableAmount * 100,
            "currency" => $stripeSetting->currency_name,
            "source" => $request->stripe_token,
            "description" => "product purchase!"
        ]);

        if ($response->status === 'succeeded') {
            $this->storeOrder('stripe', 1, $response->id, $payableAmount, $stripeSetting->currency_name);
            // clear session
            $this->clearSession();

            return redirect()->route('user.payment.success');
        } else {
            flash()->error('Someting went wrong try agin later!');
            return redirect()->route('user.payment');
        }
    }

    /**
     ** this function is refactored 
     ** تخزين الطلب في قاعدة البيانات
     ** Store order in database
     * @param string $paymentMethod
     * @param string $paymentStatus
     * @param string $transactionId
     * @param float $paidAmount
     * @param string $paidCurrencyName
     * @return Order
     */
    public function storeOrder(
        string $paymentMethod,
        string $paymentStatus,
        string $transactionId,
        float $paidAmount,
        string $paidCurrencyName
    ): Order {
        $setting = GeneralSetting::firstOrFail();

        $order = Order::create([
            'invocie_id'     => rand(1, 999999),
            'user_id'        => Auth::id(),
            'sub_total'      => getCartTotal(),
            'amount'         => getFinalPayableAmount(),
            'currency_name'  => $setting->currency_name,
            'currency_icon'  => $setting->currency_icon,
            'product_qty'    => Cart::content()->count(),
            'payment_method' => $paymentMethod,
            'payment_status' => $paymentStatus,
            'order_address'  => json_encode(Session::get('address')),
            'shpping_method' => json_encode(Session::get('shipping_method')),
            'coupon'         => json_encode(Session::get('coupon')),
            'order_status'   => 'pending',
        ]);

        foreach (Cart::content() as $item) {
            $product = Proudct::findOrFail($item->id);

            $order->orderProducts()->create([
                'product_id'   => $product->id,
                'vendor_id'    => $product->vendor_id,
                'product_name' => $product->name,
                'variants'     => json_encode($item->options->variants),
                'variant_total' => $item->options->variants_total,
                'unit_price'   => $item->price,
                'qty'          => $item->qty,
            ]);

            // تحديث كمية المنتج
            $product->decrement('qty', $item->qty);
        }

        $order->transaction()->create([
            'transaction_id'             => $transactionId,
            'payment_method'             => $paymentMethod,
            'amount'                     => getFinalPayableAmount(),
            'amount_real_currency'       => $paidAmount,
            'amount_real_currency_name'  => $paidCurrencyName,
        ]);

        return $order;
    }

    public function clearSession()
    {
        Cart::destroy();
        Session::forget('address');
        Session::forget('shipping_method');
        Session::forget('coupon');
    }

    //** old func not refactored */
    public function storeOrder2($paymentMethod, $paymentStatus, $transactionId, $paidAmount, $paidCurrencyName)
    {
        $setting = GeneralSetting::first();

        $order = new Order();
        $order->invocie_id = rand(1, 999999);
        $order->user_id = Auth::user()->id;
        $order->sub_total = getCartTotal();
        $order->amount =  getFinalPayableAmount();
        $order->currency_name = $setting->currency_name;
        $order->currency_icon = $setting->currency_icon;
        $order->product_qty = Cart::content()->count();
        $order->payment_method = $paymentMethod;
        $order->payment_status = $paymentStatus;
        $order->order_address = json_encode(Session::get('address'));
        $order->shpping_method = json_encode(Session::get('shipping_method'));
        $order->coupon = json_encode(Session::get('coupon'));
        $order->order_status = 'pending';
        $order->save();

        // store order products
        foreach (Cart::content() as $item) {
            $product = Proudct::find($item->id);
            $orderProduct = new OrderProudct();
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $product->id;
            $orderProduct->vendor_id = $product->vendor_id;
            $orderProduct->product_name = $product->name;
            $orderProduct->variants = json_encode($item->options->variants);
            $orderProduct->variant_total = $item->options->variants_total;
            $orderProduct->unit_price = $item->price;
            $orderProduct->qty = $item->qty;
            $orderProduct->save();

            // update product quantity
            $updatedQty = ($product->qty - $item->qty);
            $product->qty = $updatedQty;
            $product->save();
        }

        // store transaction details
        $transaction = new Transaction();
        $transaction->order_id = $order->id;
        $transaction->transaction_id = $transactionId;
        $transaction->payment_method = $paymentMethod;
        $transaction->amount = getFinalPayableAmount();
        $transaction->amount_real_currency = $paidAmount;
        $transaction->amount_real_currency_name = $paidCurrencyName;
        $transaction->save();
    }
}
