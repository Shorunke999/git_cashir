<?php

namespace App\Http\Controllers;

use App\Models\PlatformStatus;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function dashboard(){
        $active_platform = PlatformStatus::where('status' ,1)->get();
        $active_no = $active_platform->count();
            return view('userDashboard',[
                'data' => $active_platform,
                'data_count' => $active_no
            ]);

    }

    public function updatePayment($status){
        if($status === 'BothPlatforms'){
            PlatformStatus::all()
            ->update([
                'status' => 1
            ]);
            return Redirect::back()->with('msg','Changes made');
        }elseif($status === 'Flutterwave'){
            PlatformStatus::whereIn('platform_name',['Flutterwave','Paystack'])
            ->update([
                'status' => [
                    1,
                    0
                ]
            ]);
            return Redirect::back()->with('msg','Payment platform is updated to Flutterwave');
        }else{
            PlatformStatus::whereIn('platform_name',['Flutterwave','Paystack'])
            ->update([
                'status' => [
                    0,
                    1
                ]
            ]);
            return Redirect::back()->with('msg','Payment platform is updated to Paystack');
        }

    }
}
