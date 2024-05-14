<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Events\DowntimeEvent;

class DowntimeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Cache::lock('Downtime_Paystack',1, function (){
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('PAYSTACK_SECRET_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.paystack.co/transaction/customer');
            if($response->ok()){
                dd('ok');
                Cache::put('Downtime_Paystack',false);
            }else{
                dd('not ok');
                Cache::put('Downtime_Paystack',true);
            }
            });
            DowntimeEvent::dispatch(cache('Downtime_Paystack'));
    }
}
