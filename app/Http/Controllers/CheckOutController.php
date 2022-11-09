<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Evryn\LaravelToman\Facades\Toman;
use Evryn\LaravelToman\CallbackRequest;

class CheckOutController extends Controller
{

    public function test()
    {
        $request = Toman::amount(1000)
             ->description('Subscribing to Plan A')
             ->callback(route('callback'))
             ->mobile('09923869693')
             ->email('mehdi.matinfar1397@gmail.com')
            ->request();

        if ($request->successful()) {
            $transactionId = $request->transactionId();
            // Store created transaction details for verification

            return $request->pay(); // Redirect to payment URL
        }

        if ($request->failed()) {
            // Handle transaction request failure; Probably showing proper error to user.
      echo $request->message();
      echo '</br>';
      echo $request->status();
     die();
        }
    }


    /**
     * Handle payment callback
     */
    public function callback(CallbackRequest $request)
    {
        // Use $request->transactionId() to match the payment record stored
        // in your persistence database and get expected amount, which is required
        // for verification. Take care of Double Spending.

        $payment = $request->amount(1000)->verify();

        if ($payment->successful()) {
            // Store the successful transaction details
            $referenceId = $payment->referenceId();
        }

        if ($payment->alreadyVerified()) {
            // ...
        }

        if ($payment->failed()) {
            // ...
        }
    }



}
