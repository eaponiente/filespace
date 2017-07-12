<?php

namespace App\Http\Controllers\Front\Resellers;

use Auth;
use App\Models\Resellers;
use App\Models\Packages;
use App\Models\Vouchers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActionController extends Controller
{
    public function vouchers()
    {
    	return view('front.resellers.vouchers');
    }

    public function profile()
    {
    	return view('front.resellers.profile');
    }

    public function listing()
	{

		$search = (isset($_GET['sSearch']) ? $_GET['sSearch'] : ''); 

		$where = Vouchers::with('reseller')->where('reseller_id', Auth::guard('resellers')->id())->where(function($query) use($search) {
			if( $search != '' ) {
				$query->where('code', $search);
			}
		});

		$iTotalRecords =  $where->count();
		$iDisplayLength = intval($_GET['iDisplayLength']);
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		$iDisplayStart =  intval($_GET['iDisplayStart']);
		$sEcho = intval($_GET['sEcho']);

		$recs = $where->skip($iDisplayStart)->take($iDisplayLength)->get();


		$records = array();
		$records["aaData"] = array(); 

		$end = $iDisplayStart + $iDisplayLength;

		foreach($recs as $rows){
			
			$row = array();
			
			$row[] = $rows->code;
			$row[] = $rows->pin;
			$row[] = $rows->generation_datetime;
			$row[] = '';
			$row[] = $rows->consumed_datetime;
			
			$records["aaData"][] = $row;
			
		} 
		
		$records["sEcho"] = $sEcho;
		$records["iTotalRecords"] = $iTotalRecords;
		$records["iTotalDisplayRecords"] = $iTotalRecords;
		  
		 return json_encode($records);
	}

	public function generate_voucher( $length = 12 )
	{
		
		$alphanum 	= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$output 	= '';
		$charslen	= strlen( $alphanum );
		
		for ( $i = 0; $i < $length; $i++ )
		{
			$output .= $alphanum[ mt_rand( 0, $charslen - 1 ) ];
		}
		
		return $output;
		
	}

	protected function generatePin()
	{
		$pin = mt_rand(1, 127);

		if( Vouchers::wherePin($pin)->first() )
			return $this->generatePin();

		return $pin;

	}

	public function generateVoucher(Request $request)
	{
		$reseller = Auth::guard('resellers')->user()->id;

		$data = $request->get('data');

		$package = Packages::find( $data['package'] );

		if( Auth::guard('resellers')->user()->balance > $package->price )
		{
			$code = $reseller . $this->generate_voucher( 12 - strlen( $reseller ) );

			Vouchers::create( array(
				'generation_datetime' => date( 'Y-m-d H:i:s' ),
				'is_used' => false,
				'pin' => $this->generatePin(),
				'premium_days' => $package->premium_days,
				'code' => $code,
				'reseller_id' => $reseller,
				'is_generated_by' => Auth::guard('resellers')->user()->username
			));

			$remaining_balance = Auth::guard('resellers')->user()->balance - $package->price;

			Resellers::find(Auth::guard('resellers')->user()->id)->update(array('balance' => $remaining_balance));

			return redirect()->back();
		} 

		return redirect()->back()->with('error', 'Your funds is not enough to purchase a package');
	}
}
