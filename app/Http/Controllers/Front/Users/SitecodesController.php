<?php

namespace App\Http\Controllers\Front\Users;

use Auth;
use App\Models\WebsiteCodes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SitecodesController extends Controller
{
    public function index()
    {
    	$codes = Auth::user()->websitecodes;

    	return view('front.registered.sitecodes.index', compact('codes'));
    }

    public function getCodeChecker( $code = null )
	{
		if( is_null( $code ) )
		{
			// redirect to file not found or 404
		}

		$this->setTitle('FileSpace.io - Site Codes Checker');	
		$this->layout->content = View::make( 'pages.affiliate.code-checker', compact( 'code' ) );
	}

	public function checker(Request $request, $code)
	{
		$code = WebsiteCodes::whereCode($code)->first();

		if( $request->method() === 'POST' )	
		{	
			$data = $request->get('sitecodes');

			$uris = explode("\n", $data[ 'urls' ] );

			if( count($uris) >= 100) return redirect()->back()
					->with('message', '<div class="alert alert-danger">Maximum of 100 links per time</div>');

			$verified_links = 0;
			$dead_links		= 0;
			$sitecodes_matched = 0;
			$mismatched     = 0;

			$ctr = 0;	
			$status = false;
			foreach ($uris as $uri) 
			{
				$uri = trim($uri);
				$parsed_url = pathinfo( $uri );

				if( strlen( strtolower( $parsed_url[ 'basename' ] ) ) == 20  )
				{
					// return file_id and site_id
					$code = syferDecode( $parsed_url[ 'basename' ] );

					// check if file exist
					if( $this->file_exists( $code['fileid'] ) )
					{
						$websites_code = WebsiteCodes::whereCode( $code['siteid'] )->first();

						if( $websites_code->code === $data['code'] ) {
							$sitecodes_matched++;
							$status = true;
						} else {
							$mismatched++;
							$status = false;
						}
						$verified_links++;
					}
					else
					{
						$status = false;
						$dead_links++;
					}	
					
				}
				else
				{
					$status = false;
					$dead_links++;
				}	
				
				$new_uri[] = [ 'verified' => $status, 'uri' => $uri ];
				$ctr++;
			}
			
			$codes = $data['code'];

			return view( 'front.registered.sitecodes.results', 
				compact( 'title', 'new_uri', 'verified_links', 'dead_links', 'sitecodes_matched', 'mismatched', 'codes', 'code' ) );
		}

		return view( 'front.registered.sitecodes.checker', compact( 'code' ) );
	}

	public function file_exists($fileid)
	{
		$file = FileUploads::find($fileid);

		return $file;
	}
}
