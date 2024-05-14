<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function dashboard(){
        if(Cache::get('Downtime_Paystack')){
            $paystack_downtime = Cache::get('Downtime_Paystack');
        }
        return view('userDashboard',[
            'Paystack_Downtime' => isset ($paystack_downtime) ?  $paystack_downtime : 'Data not available'
        ]);
    }
}
