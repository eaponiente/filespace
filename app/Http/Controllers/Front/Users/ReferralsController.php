<?php

namespace App\Http\Controllers\Front\Users;

use Auth;
use App\Models\User;
use App\Models\Countries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReferralsController extends Controller
{
    public function index()
    {
    	return view('front.registered.referrals.index');
    }

    public function listings()
	{
		$user = new User;
		$search = (isset($_GET['sSearch']) ? $_GET['sSearch'] : ''); 

		$iTotalRecords =  $user->getAllRefferals($search, Auth::id());
		$iDisplayLength = intval($_GET['iDisplayLength']);
		$iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
		$iDisplayStart =  intval($_GET['iDisplayStart']);
		$sEcho = intval($_GET['sEcho']);

		$recs = $user->ShowReferrals($iDisplayStart, $iDisplayLength, $search, Auth::id());

		
		$records = array();
		$records["aaData"] = array(); 

		$end = $iDisplayStart + $iDisplayLength;

		foreach($recs as $rows){
			
			$row = array();
			
			$data = Countries::where('code', $rows[ 'registration_geocountry' ] )->first();

			$row[] = $rows[ 'username' ];
			$row[] = empty( $data->full_name ) ? '' : $data->full_name ;
			$row[] = date( 'Y-m-d | H:i:s', strtotime( $rows[ 'registration_date' ] ) );
			$row[] = $rows[ 'is_affiliate' ] == 'YES' ? 'Premium' : 'Registered';
			
			$records["aaData"][] = $row;
			
		} 
		
		$records["sEcho"] = $sEcho;
		$records["iTotalRecords"] = $iTotalRecords;
		$records["iTotalDisplayRecords"] = $iTotalRecords;
		  
		 return json_encode($records);
	}
}
