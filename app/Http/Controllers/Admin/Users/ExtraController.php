<?php

namespace App\Http\Controllers\Admin\Users;

use App\Models\User;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExtraController extends Controller
{
    public function addFreeDays(Request $request, $id)
    {
    	$this->validate($request, [
    		'amount' => 'required|min:0|max:366|numeric'
    	]);

    	$user = User::find($id);

		$date_now = new \DateTime( 'now' );
		$date_premium = new \DateTime( $user->premium_expiration_date_and_time );

		$date_new = $date_premium <= $date_now ? $date_now : $date_premium;

		$premium_start = $date_new->format( 'Y-m-d' );

		$date_new->add( new \DateInterval( sprintf( 'P%sD', $request->amount ) ) );

		$premium_end = $date_new->format( 'Y-m-d' );

		$user->premium_expiration_date_and_time = $date_new->format( 'Y-m-d H:i:s' );
		$user->is_last_transaction_verified = 'No';
		$user->save();

		/*Transactions::create( [
			'trans_datetime' 	=> $date_now->format( 'Y-m-d H:i:s' ),		
			'ip' 				=> null,
			'ip_geocountry' 	=> null,
			'status' 			=> 3,
			'card type'			=> '',
			'transaction_amount' => 0,
			'type' 				=> 4,
			'user_id' 			=> $user->id,
			'premium_days' 		=> $request->amount,
			'premium_start' 	=> $premium_start,
			'premium_end' 		=> $premium_end
		] );*/

		return response()->json([
			'msg' => 'Successfully added '. $request->amount .' days to the account of '. $user->username,
			'success' => true
		]);
    }

    public function setCustomStorage(Request $request, $id)
    {
    	$this->validate($request, [
    		'storage' => 'required|numeric'
    	]);

		$gb = $request->storage;
		$kb = $gb * pow( 1024, 3 );


		$user = User::find($id)->update( array( 
			'custom_storage' => $kb
		));

		return response()->json([
			'msg' => 'Custom storage updated',
			'storage' => $request->storage,
			'success' => true
		]);
    }

    public function addNote(Request $request, $id)
    {
    	
    }

    


}
