<?php
namespace App\Library;

use App\Models\Codes216;
use App\Models\Codes236;

class Syfer
{
	private $options = array(
		'codes_alphanum_table' 	=> 'chs_codes_2_36',
		'codes_numeric_table'	=> 'chs_codes_2_16'
		);
	
	private $ci = null;
	private $char_basis = null;
	
	public function __construct( $options = array() )
	{
		$this->options = $this->options + $options;
		
		array_filter( $this->options );
		
		if ( is_null( $this->options[ 'codes_alphanum_table' ] ) )
		{
			trigger_error( 'Syfer::options[ \'codes_alphanum_table\' ] must not be null' );
		}
		
		if ( is_null( $this->options[ 'codes_numeric_table' ] ) )
		{
			trigger_error( 'Syfer::options[ \'codes_numeric_table\' ] must not be null' );
		}
		
		$char_basis = $this->get_alphanum_field( '00' );
		$this->char_basis = $char_basis->field_2;
	}
	
	private function get_alphanum_field( $index )
	{
		$alphanum = Codes236::where( 'field_1', $index )->get();
		
		return $alphanum->isEmpty() ? null : $alphanum->first();
	}
	
	private function get_numeric_field( $index )
	{
		$numeric = Codes216::where( 'field_1', $index )->get();
		
		return $numeric->count() <= 0 ? null : $numeric->first();
	}
	
	private function random_alphanum_field()
	{
		$alphanum = Codes236::find( mt_rand( 1,37 ) );
		
		return ! $alphanum ? null : $alphanum;
	}
	
	private function random_numeric_field()
	{
		$numeric = Codes216::find( mt_rand( 1, 100 ) );
		
		return ! $numeric ? null : $numeric;
	}
	
	public function encode( $string )
	{
		

		$chars_16 		= $string;
		
		$alphanum_field = $this->random_alphanum_field();
		$numeric_field 	= $this->random_numeric_field();
		$alphanum		= $alphanum_field->field_2;
		$numeric		= $numeric_field->field_2;
		
		$output 		= '';
		
		for ( $i = 0, $length = strlen( $chars_16 ); $i < $length; $i++ )
		{
			$pos_on_basis = strpos( $this->char_basis, $chars_16[ $i ] );
			
			if ( $pos_on_basis === false )
			{
				trigger_error( 'Input string contains a character that is not in our character basis' );
			}
			
			$output .= $alphanum[ $pos_on_basis ];
		}
		$reordered_output 	= array_fill( 0, 16, '' );
		$character_order 	= explode( ';', $numeric );
		
		for ( $i = 0, $length = count( $character_order ); $i < $length; $i++ )
		{
			$pos = (int) $character_order[ $i ];
			
			$reordered_output[ $pos - 1 ] = $output[ $i ];
		}
		
		return $alphanum_field->field_1 . $numeric_field->field_1 . implode( '', $reordered_output );
	}
	
	public function decode( $string )
	{
		if ( !$this->check_raw_string( $string ) )
		{
			trigger_error( 'Input "'. $string .'" is not a valid input string maybe because it\'s length is not equal to 20 characters or it contains non-alphanumerical characters' );
		}
		
		$alphanum_index = $this->parse_alphanum_index( $string );
		$numeric_index 	= $this->parse_numeric_index( $string );
		$chars_16 		= $this->parse_chars_16( $string );
		
		$alphanum_field = $this->get_alphanum_field( $alphanum_index );
		$numeric_field 	= $this->get_numeric_field( $numeric_index );
		$alphanum		= $alphanum_field->field_2;
		$numeric		= $numeric_field->field_2;
		
		$strbuilder			= array_fill( 0, 16, '' );
		$character_order	= explode( ';', $numeric );
		
		foreach ( $character_order as $i => $ord )
		{
			$pos = (int) $ord; $pos = $pos - 1;
			$strbuilder[ $i ] = $chars_16[ $pos ];
		}
		$strbuilder = implode( '', $strbuilder );
		
		$output = '';
		for ( $i = 0, $length = strlen( $strbuilder ); $i < $length; $i++ )
		{
			$pos_on_alphanum = strpos( $alphanum, $strbuilder[ $i ] );
			
			if ( $pos_on_alphanum === false )
			{
				trigger_error( 'Input string contains a character that is not in our alphanum basis' );
			}
			
			$output .= $this->char_basis[ $pos_on_alphanum ];
		}
		
		return $output;
	}
	
	private function parse_chars_16( $string )
	{
		return substr( $string, 4, 16 );
	}
	
	private function parse_alphanum_index( $string )
	{
		return $string[ 0 ] . $string[ 1 ];
	}
	
	private function parse_numeric_index( $string )
	{
		return $string[ 2 ] . $string[ 3 ];
	}
	
	private function check_raw_string( $string )
	{
		if ( strlen( $string ) != 20 )
		{
			return false;
		}
		
		if ( !preg_match( '/^[a-zA-Z0-9]+$/', $string ) )
		{
			return false;
		}
		
		return true;
	}

	public function check($value)
	{
		if( strlen ( $value ) == 20 )
		{
			$string = $value;

			$alphanum_index = $this->parse_alphanum_index( $string );
			$numeric_index 	= $this->parse_numeric_index( $string );

			$alphanum_field = $this->get_alphanum_field( $alphanum_index );
			$numeric_field 	= $this->get_numeric_field( $numeric_index );

			if( ! $alphanum_field || ! $numeric_field ) 
				return false;

			return true;
		}

		return false;
	}

	public static function set()
	{
		return new Syfer();
	}
}