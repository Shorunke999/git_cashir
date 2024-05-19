<?php

namespace App\Jobs;

use App\Models\PaymentRecords;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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
        try{
        if (!isset($this->data['provider']) || !isset($this->data['data'])) {
            Log::error('Invalid data structure', ['data' => $this->data]);
            return;
        }

        $provider = $this->data['provider'];
        $transactionData = $this->data['data'];

        if($provider == 'paystack'){
            Log::info('working', ['data' => 'working']);
            PaymentRecords::create([
                'user_email' => $transactionData['customer']['email'],
                'Payment_platform' => 'paystack',
                'reference' => $transactionData['reference'],
                'amount' => $transactionData['amount'],
                'fees' => $transactionData['fees']
            ]);
        } else {
            Log::info('working',['maybe' => 'free']);
            PaymentRecords::create([
                'user_email' => $transactionData['customer']['email'],
                'Payment_platform' => 'monny',
                'reference' => $transactionData["product"]['reference'],
                'amount' => $transactionData['amountPaid'],
                'fees' => $transactionData['fees'] ?? 0
            ]);
        }
    } catch (Exception $e) {
        Log::error('Error saving payment to database: ' . $e->getMessage(), ['data' => $this->data]);
    }
    }
}
