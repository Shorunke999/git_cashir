<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use App\Events\DowntimeEvent;
use App\Jobs\PaymentProcessing;
use App\Models\PaymentRecords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use League\CommonMark\Reference\Reference;
use CustomTransactionHashUtil;

class PaymentController extends Controller
{
    //initialize paystack payment
    public function initailizePayment(Request $request)
    {
        //initiating paystack payment
        $uuid = Str::uuid()->toString();
        $reference = substr($uuid, 0, 8);

        if($request->provider == 'paystack'){
            try{
                //dd('working paystack');
                $res_body = $this->Paystack($request,$reference);
                 return Redirect::away($res_body['data']['authorization_url']);
            }catch(\Exception $e) {
                return Redirect::back()->withMessage(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error']);
            }
        }else{
            try{
                //dd('working Monny');
                 $res_body = $this->Monny($request,$reference);
                return redirect()->away($res_body["responseBody"]["checkoutUrl"]);
            }catch(\Exception $e){
                return Redirect::back()->withMessage(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error']);
            }

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
            if ($request->event == "charge.success") {
                $data = [
                    'provider' => 'paystack',
                        'data' => $request->data
                ];
                Log::info('request:',['request Paystack' => $request->data]);
                PaymentProcessing::dispatch($data);
            }

            // Send a 200 response back to Paystack
            return response()->json(['message' => 'Webhook received successfully'], 200);
        }
}

    private function Paystack($payload,$reference){
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PAYSTACK_SECRET_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.paystack.co/transaction/initialize', [
            'amount' => $payload->amount * 100,
            'email' =>auth()->user()->email,
            'reference' => $reference,
            'callback_url' => env('App_site').'/DashboardUser?message=Payment+successful!'
        ]);
            return json_decode($response->getBody()->getContents(), true);
    }

    private function Monny($payload,$reference){
        $apiKey = env('MONNY_PUBLIC_KEY');
        $secretKey = env('MONNY_SECRET_KEY');
        $basicToken = base64_encode("{$apiKey}:{$secretKey}");
        // Set the Authorization header with the basic token
       // Set the Authorization header with the basic token
        $headers = [
            'Authorization' => "Basic {$basicToken}",
        ];

        // Make a request to the login endpoint to obtain an access token
        $responseGuzzle = Http::withHeaders($headers)->post('https://api.monnify.com/api/v1/auth/login');
        $stringify_response = $responseGuzzle->getBody()->getContents();
        $response = json_decode($stringify_response,true);
        if ($responseGuzzle->ok()) {
            $accessToken = $response['responseBody']['accessToken'];

            $newheaders = [
                'Authorization' => "Bearer {$accessToken}",
            ];
            // Make a request to a Monnify API endpoint using the access token
            $apiResponse = Http::withHeaders($newheaders)->post('https://sandbox.monnify.com/api/v1/merchant/transactions/init-transaction',[
                'amount' => $payload->amount,
                'customerEmail' =>auth()->user()->email,
                'customerName'=>auth()->user()->name,
                'paymentReference' => $reference,
                "currencyCode"=> "NGN",
                "contractCode"=> env('MONNY_CONTRACT_CODE'),
                "redirectUrl" => env('App_site').'/DashboardUser?message=Payment+successful!',
                "paymentMethods"=> ["CARD","ACCOUNT_TRANSFER"]

            ]);
            return json_decode($apiResponse->getBody()->getContents(),true);
        }
    }



    /**
     * Obtain Rave callback information
     * @return void
     */
    public function Monnywebhook(Request $request)
    {
        try{
            $clientSecret = env('MONNY_SECRET_KEY');
            $monnifySignature = $request->header('monnify-signature');
            $requestBody = $request->getContent();
                Log::info('Monnify webhook received:', ['monny' => $request,'requestbody' => $requestBody]);

            $validator = hash_hmac('sha512', $requestBody, $clientSecret);
            if(hash_equals($validator, $monnifySignature)){
                $payload = json_decode($requestBody, true);
                Log::info('payload:',['payload' => $payload]);
                $data = [
                    'provider' => 'monny',
                        'data' => $payload['eventData']
                ];
                PaymentProcessing::dispatch($data);
            // dispatch(new PaymentProcessing($data));
                //$this->saveRecord($data);
                return response()->json(['message' => 'Webhook received successfully'], 200);
        }
        } catch (\Exception $e) {
            Log::error('Error processing Monnify webhook', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }



}
