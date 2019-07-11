<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\IPNStatus;
use App\Item;
use App\User;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\AdaptivePayments;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Page;
use App\Banner;
use Illuminate\Support\Facades\Session;

class PayPalController extends Controller
{
    /**
     * @var ExpressCheckout
     */
    protected $provider;
    protected $user = null;

    public function __construct()
    {
        $this->provider = new ExpressCheckout();
    }

    public function getIndex(Request $request)
    {


        $page = Page::where('pages.slug', 'subscription')
            ->where('pages.status', 1)
            ->first();
        $banner = Banner::where('page_name', $page->id)->first();
        $breadcrumbs = getBreadcrumb($page);
        if (!$page) {

            return abort(404);

        }
        $response = [];
        if (session()->has('code')) {
            $response['code'] = session()->get('code');
            session()->forget('code');
        }

        if (session()->has('message')) {
            $response['message'] = session()->get('message');
            session()->forget('message');
        }
        return view("subscription", compact("page", "banner", "breadcrumbs","response"));


    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getExpressCheckout(Request $request)
    {
        Session(['payer_email' => $request->email]);
        $recurring = ($request->get('mode') === 'recurring') ? true : false;
        $cart = $this->getCheckoutData($recurring);

        try {
            $response = $this->provider->setExpressCheckout($cart, $recurring);

            return redirect($response['paypal_link']);
        } catch (\Exception $e) {
            $user = User::where('email', $request->email)->first();
            $data['subscription_type'] = $request->mode;
            $data['period_type'] = masterSetting()->subscription_validity;
            $data['period_value'] = masterSetting()->subscription_validity_type;
            $cart['transaction_id'] = null;
            $cart['profile_id'] = null;
            $cart['user_id'] = $user->id;
            $cart['email'] = $user->email;
            $invoice = $this->createInvoice($cart, 'Invalid');

            session()->put(['code' => 'danger', 'message' => "Error processing PayPal payment for Order $invoice->id!"]);
        }
    }

    /**
     * Process payment on PayPal.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getExpressCheckoutSuccess(Request $request)
    {
        $user = User::where('email', $request->session()->get('payer_email'))->first();
        $recurring = ($request->get('mode') === 'recurring') ? true : false;
        $token = $request->get('token');
        $PayerID = $request->get('PayerID');

        $cart = $this->getCheckoutData($recurring);
        $cart['transaction_id'] = null;
        $cart['profile_id'] = null;
        $cart['user_id'] = $user->id;
        $cart['email'] = $user->email;
        // Verify Express Checkout Token
        $response = $this->provider->getExpressCheckoutDetails($token);

        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            if ($recurring === true) {
                $response = $this->provider->createMonthlySubscription($response['TOKEN'], $cart['total'], $cart['subscription_desc']);
                if (!empty($response['PROFILESTATUS']) && in_array($response['PROFILESTATUS'], ['ActiveProfile', 'PendingProfile'])) {
                    $status = 'Processed';
                    $cart['profile_id'] = $response['PROFILEID'];
                } else {
                    $status = 'Invalid';
                }
            } else {
                // Perform transaction on PayPal
                $payment_status = $this->provider->doExpressCheckoutPayment($cart, $token, $PayerID);
                $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];
                $cart['transaction_id'] = $payment_status['PAYMENTINFO_0_TRANSACTIONID'];
            }

            $invoice = $this->createInvoice($cart, $status);

            if ($invoice->paid) {
                session()->put(['code' => 'success', 'message' => "Order $invoice->order_id has been paid successfully!"]);
                return redirect(url('/subscription'));
            } else {
                session()->put(['code' => 'danger', 'message' => "Error processing PayPal payment for Order $invoice->order_id!"]);
                return redirect(url('/subscription'));
            }


        }
    }

    public function getAdaptivePay()
    {
        $this->provider = new AdaptivePayments();

        $data = [
            'receivers' => [
                [
                    'email' => 'johndoe@example.com',
                    'amount' => 10,
                    'primary' => true,
                ],
                [
                    'email' => 'janedoe@example.com',
                    'amount' => 5,
                    'primary' => false,
                ],
            ],
            'payer' => 'EACHRECEIVER', // (Optional) Describes who pays PayPal fees. Allowed values are: 'SENDER', 'PRIMARYRECEIVER', 'EACHRECEIVER' (Default), 'SECONDARYONLY'
            'return_url' => url('payment/success'),
            'cancel_url' => url('payment/cancel'),
        ];

        $response = $this->provider->createPayRequest($data);
        dd($response);
    }

    /**
     * Parse PayPal IPN.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function notify(Request $request)
    {
        if (!($this->provider instanceof ExpressCheckout)) {
            $this->provider = new ExpressCheckout();
        }

        $post = [
            'cmd' => '_notify-validate',
        ];
        $data = $request->all();
        foreach ($data as $key => $value) {
            $post[$key] = $value;
        }

        $response = (string)$this->provider->verifyIPN($post);

        $ipn = new IPNStatus();
        $ipn->payload = json_encode($post);
        $ipn->status = $response;
        $ipn->save();
    }

    /**
     * Set cart data for processing payment on PayPal.
     *
     * @param bool $recurring
     *
     * @return array
     */
    protected function getCheckoutData($recurring = false)
    {
        $data = [];
        $constant = masterSetting()->invoice_constant;
        $invoiceCount = Invoice::all()->count();
        $order_id = masterSetting()->invoice_constant . date("y") . str_pad((masterSetting()->invoice_series_no + $invoiceCount), 4, '0', STR_PAD_LEFT);

        if ($recurring === true) {
            $data['items'] = [
                [
                    'name' => 'Subscription ' . ' #' . $order_id,
                    'price' => masterSetting()->subscription_value,
                    'qty' => 1,
                ],
            ];

            $data['return_url'] = url('/paypal/ec-checkout-success?mode=recurring');
            $data['subscription_desc'] = 'Subscription ' . 'Subscription ' . ' #' . $order_id;
            $data['subscription_type'] = 'recurring';
        } else {
            $data['items'] = [
                [
                    'name' => 'Subscription ' . ' #' . $order_id,
                    'price' => masterSetting()->subscription_value,
                    'qty' => 1,
                ]
            ];

            $data['return_url'] = url('/paypal/ec-checkout-success');
            $data['subscription_type'] = 'non-recurring';
        }


        $data['period_type'] = masterSetting()->subscription_validity_type;
        $data['period_value'] = masterSetting()->subscription_validity;
        $data['invoice_id'] = $order_id;
        $data['invoice_description'] = "Order #$order_id Invoice";
        $data['cancel_url'] = url('/');

        $total = 0;
        foreach ($data['items'] as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $data['total'] = $total;

        return $data;
    }

    /**
     * Create invoice.
     *
     * @param array $cart
     * @param string $status
     *
     * @return \App\Invoice
     */
    protected function createInvoice($cart, $status)
    {
        $invoice = new Invoice();
        $invoice->order_id = $cart['invoice_id'];
        $invoice->subscription_type = $cart['subscription_type'];
        $invoice->period_type = $cart['period_type'];
        $invoice->period_value = $cart['period_value'];
        $invoice->user_id = $cart['user_id'];
        $invoice->user_email = $cart['email'];
        $invoice->title = $cart['invoice_description'];
        $invoice->price = $cart['total'];
        $invoice->transaction_id = $cart['transaction_id'];
        $invoice->profile_id = $cart['profile_id'];
        if (!strcasecmp($status, 'Completed') || !strcasecmp($status, 'Processed')) {
            $invoice->paid = 1;
        } else {
            $invoice->paid = 0;
        }
        $invoice->save();

        collect($cart['items'])->each(function ($product) use ($invoice) {
            $item = new Item();
            $item->invoice_id = $invoice->id;
            $item->item_name = $product['name'];
            $item->item_price = $product['price'];
            $item->item_qty = $product['qty'];

            $item->save();
        });

        return $invoice;
    }

    public function recurringPaymentProfileDetail($id)
    {
        $response = $this->provider->getRecurringPaymentsProfileDetails($id);
        dd($response);
    }
}
