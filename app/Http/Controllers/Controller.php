<?php

namespace App\Http\Controllers;

use App\Http\Resources\platformStatusResources;
use App\Models\PlatformStatus;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
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

            PlatformStatus::where('status', 0)->update(['status' => 1]);
            return Redirect::back()->with('msg','Changes made');

        }elseif($status === 'Flutterwave'){
            //query
                PlatformStatus::whereIn('platform_name', ['Flutterwave', 'Paystack'])
                ->update(['status' => DB::raw('CASE
                    WHEN platform_name = "Flutterwave" THEN 1
                    WHEN platform_name = "Paystack" THEN 0
                END')]);

            return Redirect::back()->with('msg','Payment platform is updated to Flutterwave');
        }else{
            //query
            PlatformStatus::whereIn('platform_name', ['Flutterwave', 'Paystack'])
            ->update(['status' => DB::raw('CASE
                WHEN platform_name = "Flutterwave" THEN 0
                WHEN platform_name = "Paystack" THEN 1
            END')]);

            return Redirect::back()->with('msg','Payment platform is updated to Paystack');
        }

    }
}
