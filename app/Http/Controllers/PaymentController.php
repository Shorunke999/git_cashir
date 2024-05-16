<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use App\Events\DowntimeEvent;
use App\Jobs\PaystackkVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Unicodeveloper\Paystack\Facades\Paystack as Paystack;
use KingFlamez\Rave\Facades\Rave as Flutterwave;
use League\CommonMark\Reference\Reference;

class PaymentController extends Controller
{
    public function initailizePayment(Request $request)
    {

        if($request->provider == 'paystack'){
            try{

                //initiating paystack payment
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
            //initiaing flutterwave payment
        }

    }
     /**
     * Obtain Paystack payment information
     * @return void
     */
    public function Paystackwebhook(Request $request)
    {
        $paystackSignature = $request->header('X-Paystack-Signature');
        $secret = env('PAYSTACK_SECRET_KEY');
        $expectedSignature = hash_hmac('sha512', $request->getContent(), $secret);

        if(hash_equals($expectedSignature, $paystackSignature)){
             // Process the webhook event
            $event = $request->all(); // Retrieve the request body

            // Do something with the event (e.g., handle payment success, update database, etc.)

            Log::info('Paystack webhook received', $event);
            //Response::make('Webhook processed successfully', 200);
            return redirect()->to('/')->with('msg', 'Payment Successful');
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

}
