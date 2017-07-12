<?php

namespace App\Http\Controllers\Front\Users;

use File;
use Mail;
use Validator;
use App\Models\AbuseReport;
use App\Traits\ValidatorTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AbuseController extends Controller
{
	use ValidatorTrait;

	public function index()
	{
	    return view('front.abuses.index');
	}

	/* check if upload of file success */
	protected function upload($file)
	{

		$filename = md5(date('Ymd') . time() . uniqid()) . ".$ext";
		

		$path = config('constants.abuse_reports_folder');

		if ( ! File::isDirectory( $path ) )
		{
			File::makeDirectory( $path, 0777, true );
		}

		$upload_success = $file->move( $path, $filename );

		return $upload_success ? $filename : false;
	}

	/* check if file extension is allowed */
	protected function check_ext_allowable($file)
	{
		$extensions_allowed = [ 'jpg', 'jpeg', 'bmp', 'png', 'pdf' ];	

		$ext = $file->getClientOriginalExtension();

		if( !in_array( $ext, $extensions_allowed ) )
		{
			return false; 
		}

		return true;
	}

	public function store(Request $request)
	{
		if( $request->method() === 'POST' )
		{
			$data = $request->all();

			if( $request->hasFile('file') )
			{
				$file = $request->get('file');

				if( ! $this->check_ext_allowable($file) )
				{
					return back()
						->withInput($data)->with([
							'status' => 'danger',
							'message' => 'Type of file you uploaded is not allowed.'
						]);
				}

				if( ! $this->upload($file) )
				{
					return back()->withInput($data)->with('status', 'danger')->with('message', 'File you uploaded is not allowed.');
				}
			
				$data['uploaded_filename'] = $this->upload($file);
			}

			

			$validator = Validator::make($data, AbuseReport::$rules[ 'report' ], ['g-recaptcha-response.required' => 'Recapcha is required']);

			if( $validator->fails() )
			{
				return back()->withErrors($validator)->withInput($data)->with('status', 'error-message')->with('message', 'There was an error in submitting the report, Please try again later.');
			}

			$linksTemp = explode("\n", $data[ 'links' ] );

			$linksVar = [];

			foreach ( $linksTemp as $key ) 
			{
				$keys = get_domain( $key );
				if( $keys == config('constants.site_url') )
				{
					$linksVar[] = $key;
				}	
			}

			if( count( $linksVar ) <= 0 )
			{
				return back()
					->withInput($data)
					->with('status', 'error-message')
					->with('message', 'Please report only filespace.io links (one per line), up to 50 links.');
			}

			if( count( $linksVar ) >= 50 )
			{
				return back()
					->withInput($data)
					->with('status', 'error-message')
					->with('message', 'Please report only filespace.io links (one per line), up to 50 links.');
			}
			
			$data[ 'links' ] 					= implode(';', $linksVar);
			$data[ 'reported_links_amount' ] 	= count( $linksVar );
			$data[ 'code' ]	 					= $this->generate_code();
			$data[ 'resolved' ] 				= 0;
			$data[ 'reason' ] 					= nl2br($data[ 'reason' ]);
			$data[ 'report_datetime' ] 			= date('Y-m-d h:i:s');

			unset( $data[ 'accept' ], $data[ 'recaptcha_response_field' ] );

			$info = [
				'name' => $data['name'],
				'code' => $data['code'],
				'org'  => $data['organization']		
			];



			AbuseReport::create( $data );

			Mail::send('emails.abuse-report', $info, function($message) use($data)
			{
				$message->from('noreply@filespace.io', 'FileSpace.io System');
			    $message->to( $data['email'] , $data['name'] )->subject( 'Abuse Report Confirmation ' . $data['code'] );
			});

			return back()->with('status', 'success-message')->with('message', 'Your report was submitted');
		}
	}

	private function generate_code()
	{		
		$str = mt_rand( 112345, 999999 ) . mt_rand( 100061, 999999 ) . mt_rand( 1001, 9999 );

		if ( AbuseReport::whereCode( $str )->first() )
		{
			return $this->generate_code();
		}
		
		return $str;
	}
}
