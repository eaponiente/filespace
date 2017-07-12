<?php
namespace App\Library;

class Form {

	public static function open($array)
	{
		$html = '<form method="POST"';

		foreach ($array as $key => $value) 
		{
			if( $key == 'url' ) 
			{
				$html .= 'action="' . url($value) . '"';
			} 
		}

		$html .= '>';

		return $html;
	}

	public static function close($url)
	{
		return csrf_field() . '</form>';
	}

}