<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use App\Events\DowntimeEvent;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Unicodeveloper\Paystack\Facades\Paystack as Paystack;
use KingFlamez\Rave\Facades\Rave as Flutterwave;
use League\CommonMark\Reference\Reference;

class PaymentController extends Controller
{
    public function redirectToGateway(Request $request)
    {

        if($request->provider == 'paystack'){
            try{
                $uuid = Str::uuid()->toString();
                $reference = substr($uuid, 0, 8);
                //dd();
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . env('PAYSTACK_SECRET_KEY'),
                    'Content-Type' => 'application/json',
                ])->post('https://api.paystack.co/transaction/initialize', [
                    'amount' => $request->amount * 100,
                    'email' =>auth()->user()->email,
                    'reference' => $reference
                ]);
                    $res_body = json_decode($response->getBody()->getContents(), true);
                if($res_body == true){

                    return Redirect::away($res_body['data']['authorization_url']);
                }
            }catch(\Exception $e) {
                return Redirect::back()->withMessage(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error']);
            }
        }else{

        }

    }


    /**
     * Obtain Rave callback information
     * @return void
     */
    public function callback()
    {

        $status = request()->status;

        //if payment is successful
        if ($status ==  'successful') {

        $transactionID = Flutterwave::getTransactionIDFromCallback();
        $data = Flutterwave::verifyTransaction($transactionID);

        dd($data);
        }
        elseif ($status ==  'cancelled'){
            //Put desired action/code after transaction has been cancelled here
        }
        else{
            //Put desired action/code after transaction has failed here
        }
        // Get the transaction from your DB using the transaction reference (txref)
        // Check if you have previously given value for the transaction. If you have, redirect to your successpage else, continue
        // Confirm that the currency on your db transaction is equal to the returned currency
        // Confirm that the db transaction amount is equal to the returned amount
        // Update the db transaction record (including parameters that didn't exist before the transaction is completed. for audit purpose)
        // Give value for the transaction
        // Update the transaction to note that you have given value for the transaction
        // You can also redirect to your success page from here

    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback(Request $request)
    {
        $data =  $request->all();

        dd($data);
        //important data to save
        //user email
        //reference number
        //amount
        //time of payment
    }
}
