<?php

namespace App\Traits;

trait ValidatorTrait {

	protected function verifyReCaptcha($recaptchaCode){
	    $postdata = http_build_query([ "secret"=> config('constants.recapcha.secret') ,"response"=> $recaptchaCode]);
	    $opts = ['http' =>
	        [
	            'method'  => 'POST',
	            'header'  => 'Content-type: application/x-www-form-urlencoded',
	            'content' => $postdata
	        ]
	    ];
	    $context  = stream_context_create($opts);
	    $result = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
	    $check = json_decode($result);
	    return $check->success;
	}

}