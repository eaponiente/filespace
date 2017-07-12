<?php

namespace App\Traits;

use App\Models\IpBan;
use App\Models\Countries;

trait LoginTrait {

	protected function isCountryBanned()
    {
    	# check if country is banned
		$country_code = function_exists( 'geoip_country_code_by_name' ) ? @geoip_country_code_by_name( $_SERVER[ 'REMOTE_ADDR' ] ) : '';
		
		$banned_country = Countries::whereCode($country_code)->whereIsBanned(1)->first();

		if($banned_country)
			return true;

		return false;
    }

    protected function isIpBanned($ip)
    {
    	# check if user is banned
		$banned_ip = IpBan::whereIp( $ip )->first();

		if( $banned_ip )
			return true;

		return false;
    }

}