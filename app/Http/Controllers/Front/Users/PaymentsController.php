<?php

namespace App\Http\Controllers\Front\Users;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentsController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
    	return view('front.registered.payments.index');
    }

    public function successful(Request $request)
    {
        $user = Auth::user();

        if($request->method() === 'POST')
        {
            $data = $this->request->all();

            $time_to_extend = strtotime($data['duration']);

            $user_premium = strtotime($user->premium_expiration_date_and_time);

            $date_today = strtotime(date('Y-m-d H:i:s'));

            if( $user_premium == 0 || $user_premium < date('Y-m-d H:i:s') )
            {
                $user->premium_expiration_date_and_time = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) + $this->getTotalDays( $data['duration'] ) );
            }
            else
            {
                $user->premium_expiration_date_and_time = date('Y-m-d H:i:s', $user_premium + $this->getTotalDays( $data['duration'] ) );
            }

            $user->save();
        }


        $premium_time = $user->premium_expiration_date_and_time;


        return view('front.registered.payments.successful', compact('premium_time'));
    }

    public function getTotalDays($days)
    {
        return (( 60 * 60 ) * 24) * $days;
    }

}
