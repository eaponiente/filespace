<?php
use App\Library\Syfer;

function formatBytes($size, $precision = 2)
{
	if( $size != 0 )
	{
	  $base     = log( $size ) / log( 1024 );
	  $suffixes   = array( 'B', 'KB', 'MB', 'GB', 'TB' );   

	  return round( pow( 1024, $base - floor( $base ) ), $precision ) . ' ' . $suffixes[ floor( $base ) ];
	}
	
	return 0;
}

function delete_method($url, $class = '', $enable_submit = true)
{
	$html = '<form method="POST" class="' . $class . '" action="' . $url . '">';
	$html .= csrf_field() . method_field('DELETE');
    if( $enable_submit ) 
    {
    	$html .= '<input type="submit" class="btn btn-danger btn-xs" value="Delete">';
    }

	$html .= '</form>';

	return $html;
}

function isPremium($user)
{
    if( ! Auth::check() ) return false;
    $date_premium   = new DateTime( $user->premium_expiration_date_and_time );
    $date_now       = new Datetime( 'now' );
    
    if ( $date_premium <= $date_now  )
        return false;
    else
        return $user;
}

function syferEncode( $fileid = '', $sitecode = '' )
  {
    $str = '';

    if( strlen( $fileid ) != 12 )
    {
      $total = 12 - strlen( $fileid );

      $random_chars = webCode( $total );

      $str = $random_chars . $fileid . $sitecode;
    }

    $syfered_str = (new Syfer)->encode( $str );

    return $syfered_str;
  }

function syferDecode( $str = '' )
{
	$code = (new Syfer)->decode( $str );

	$ids = array();

	$get_fileid = substr($code, 0, 12);

	$siteid = substr($code, 12, 15);

	$ids['fileid'] = preg_replace("/[^0-9]/", "", $get_fileid);

	$ids['siteid'] = $siteid;

	return $ids;
}

function webCode( $length = 10 )
{
      $charset='abcdefghijklmnopqrstuvwxyz';

      $str = '';
      $count = strlen($charset);
      while ($length--) {
          $str .= $charset[mt_rand(0, $count-1)];
      }

      return $str;
}

function get_country_code($ip = NULL, $purpose = "location", $deep_detect = TRUE)
  {
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
  }

function formatBytesNumber($size, $precision = 2)
{
    if( $size != 0 )
    {
      $base     = log( $size ) / log( 1024 );
      $suffixes   = array( 'B', 'KB', 'MB', 'GB', 'TB' );   

      $output = round( pow( 1024, $base - floor( $base ) ), $precision );

      return number_format($output, 0, '.', ',')  . ' ' . $suffixes[ floor( $base ) ];
    }
    return 0;
}

function get_percentage($used_bytes, $total_bytes)
{
    $remaining = $total_bytes - $used_bytes;
    return round( ( $remaining / $total_bytes ) * 100, 2 ) . '%';
}

function check_if_own_file( $userid )
  {
    $own = false;

    if( Auth::user()->check() && Auth::user()->get()->id != $userid ) {
      $own = false;
    } elseif( Auth::user()->check() && Auth::user()->get()->id == $userid ) {
      $own = true;
    } else {
      $own = false;
    }

    return $own;
}

function get_domain($url)
{
    $pieces = parse_url($url);
    $domain = isset($pieces['host']) ? $pieces['host'] : '';
    if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
      return $regs['domain'];
    }
    return false;
}