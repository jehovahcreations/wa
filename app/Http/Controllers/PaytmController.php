<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Anand\LaravelPaytmWallet\Facades\PaytmWallet;
use App\Models\Paydata;

class PaytmController extends Controller
{
    /**
     * Redirect the user to the Payment Gateway.
     *
     * @return Response
     */
    public function paytmPayment(Request $request)

    {   $order = 'WA'.rand(100000, 999999);
        $task = new Paydata;
        $task->username = $request->username;
        $task->email = $request->email;
        $task->phone = $request->phone;
        $task->order = $order;
        $task->status = 'Processing';
        $task->save();
        $payment = PaytmWallet::with('receive');
        $payment->prepare([
            'order' => $order,
            'user' => $request->username,
            'mobile_number' => $request->phone,
            'email' => $request->email,
            'amount' => 399,
            'callback_url' => route('paytm.callback'),
        ]);
        return $payment->receive();
    }


    /**
     * Obtain the payment information.
     *
     * @return Object
     */
    public function paytmCallback()
    {
        $transaction = PaytmWallet::with('receive');

        // $response = $transaction->response(); // To get raw response as array
        //Check out response parameters sent by paytm here -> http://paywithpaytm.com/developer/paytm_api_doc?target=interpreting-response-sent-by-paytm
        Paydata::where('order', $transaction->getOrderId())
        ->update([
            'status' => $transaction->getResponseMessage()
        ]);
        if ($transaction->isSuccessful()) {

           return view('paytm-success-page');
        } else if ($transaction->isFailed()) {

            return view('paytm-fail');
        } else if ($transaction->isOpen()) {

            return view('paytm-fail');
        }

        // $UpdateDetails->status
        // = $transaction->getResponseMessage();
        // $UpdateDetails = Paydata::where('order', $transaction->getOrderId())->first();

        $transaction->getResponseMessage(); //Get Response Message If Available
        //get important parameters via public methods
        $transaction->getOrderId(); // Get order id
        $transaction->getTransactionId(); // Get transaction id
    }

    /**
     * Paytm Payment Page
     *
     * @return Object
     */
    public function paytmPurchase()
    {
        return view('detail');
    }
    public function main()
    {
        return view('whatsapp');
    }
}
