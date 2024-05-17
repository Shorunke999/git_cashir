<?php

namespace App\Jobs;

use App\Models\PaymentRecords;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class PaymentProcessing implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data;
    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if($this->data == 'paystack'){
            PaymentRecords::create([
                'user_email'=>$this->data->customer->email,
                'Payment_platform'=> 'paystack',
                'reference' =>$this->data->data->reference,
                'amount' =>$this->data->data->amount,
                'fees' => $this->data->data->fees
            ]);
        }else{
            PaymentRecords::create([
                'user_email'=>$this->data->customer->email,
                'Payment_platform'=> 'paystack',
                'reference' =>$this->data->data->reference,
                'amount' =>$this->data->data->amount,
                'fees' => $this->data->data->fees
            ]);
        }
    }
}
