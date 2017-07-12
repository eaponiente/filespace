<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\IpBan;
use App\Models\Countries;

class IpAndCountryBan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $data = geoip(\Request::ip());



        // check first if user country is banned
        $country = Countries::whereCode( $data['iso_code'] )->whereIsBanned(1)->first();

        if( $country )
        {
            return redirect()->route('banned');
        } 

        // check if country allowed but ip is banned
        $ipban = IpBan::whereIp( $data['ip'] )->first();

        if( $ipban )
        {
            return redirect()->route('banned');
        }


        return $next($request);
    }
}
