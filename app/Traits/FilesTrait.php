<?php

namespace App\Traits;

use DB;
use Auth;
use Session;
use App\Models\User;
use App\Models\Filenas;

trait FilesTrait 
{
	private function update_user_file_stat( $increment = true, $bytes = 0 )
	{
		if( Auth::check() )
		{
			$user = Auth::user();

			if ( $increment || ( $user->storage_used >= $bytes && $user->files > 0 ) )
			{
				$user->update( array(
					'storage_used'	=> DB::raw( 'storage_used '. ( $increment ? '+' : '-' ) .' '. $bytes ),
					'files'			=> DB::raw( 'files '. ( $increment ? '+' : '-' ) .' 1' )
					) );

				$user = User::find( $user->id );

				$this->update_local_fileserver_stat( $increment, $bytes );
			}

			Session::put( 'file_count', $user->files );
		}
		
	}

	private function update_local_fileserver_stat( $increment = true, $bytes )
	{
		$server = Filenas::where('serverType', 'local')->first();
		
		if ( !is_null( $server ) )
		{
			if ( $increment || ( $server->space_used >= $bytes && $server->files > 0 ) )
			{
				$filenas = Filenas::find( $server->id );

				$filenas->update( array(
					'space_used'	=> DB::raw( 'space_used '. ( $increment ? '+' : '-' ) .' '. $bytes ),
					'files'			=> DB::raw( 'files '. ( $increment ? '+' : '-' ) .' 1' )
					) );

			}
		}
	}

	private function update_filserver_file_space( $server, $increment = true, $size )
	{
		if ( $increment || ( $server[ 'space_used' ] >= $size && $server[ 'files' ] > 0 ) )
		{
			$filenas = Filenas::find( $server[ 'id' ] );
			$filenas->update( array(
				'space_used'	=> DB::raw( 'space_used '. ( $increment ? '+' : '-' ) .' '. $size ),
				'files'			=> DB::raw( 'files '. ( $increment ? '+' : '-' ) .' 1' )
				) );
		}
	}

}