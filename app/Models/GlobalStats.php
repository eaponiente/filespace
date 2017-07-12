<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class GlobalStats extends Model
{
    protected $table = 'chs_global_stats';

    protected $guarded = ['id'];

    public $timestamps = false;

    public static function increment_columns( $column )
	{
		if( !in_array( $column, array('uploads', 'downloads', 'new_users', 'abuses') ))
			return false;

		$today = self::where('date', date('Y-m-d'))->first();
		if( $today )
			static::where('date', date('Y-m-d'))->update(array( $column => DB::raw( $column . '+ 1' ) ));
		else
			static::create( array( 'date' => date('Y-m-d'), $column => DB::raw( $column . '+ 1' ) ));
	}
}
