<?php

namespace App\Http\Controllers\Front\Files;

use DB;
use Auth;
use Input;
use Session;
use App\Traits\FilesTrait;
use App\Models\User;
use App\Models\Filenas;
use App\Models\FileFolders;
use App\Models\FileUploads;
use Illuminate\Http\Request;
use App\Models\WebsiteCodes;
use App\Http\Controllers\Controller;

class ManagerActionsController extends Controller
{
	use FilesTrait;

	public function set_reference_link()
	{
		$data = request()->all();

		$code = WebsiteCodes::where('code', $data['sitecode'])->first();

		$str = syferEncode( $data['fileid'], $data['sitecode'] );

		$file = FileUploads::find( $data['fileid'] );

		if( count( $code ) )
		{
			$dl = route('file', [$str]);
			$delete = route('file_delete', [$str, $file->delete_hash]);
			$html = '&lt;a href=&quot;' . $dl . '&quot; target=&quot;_blank&quot; title=&quot;Download From FileSpace.io&quot;&gt;download ' . $file->title . '.' . $file->file_ext;
			$forum = '[url=&quot;' . $dl . '&quot;]' . $file->title . '.' . $file->file_ext . '[/url]';

			return response()->json( array(
				'success' 	=> true,
				'download' 	=> $dl, 
				'delete' 	=> $delete,
				'html' 		=> $html,
				'forum' 	=> $forum,
				'title'		=> $file->title . '.' . $file->file_ext . '(' . formatBytes( $file->filesize_bytes, 2 ) . ')',
			));
		}

		return response()->json(array( 'success' => false ));
	}

	public function set_multi_reference_link()
	{
		$data = request()->all();

		$code = WebsiteCodes::where('code', $data['sitecode'])->first();

		$list_files = [];

		$i = 0;

		foreach ( $data['ids'] as $key ) 
		{
			$file = FileUploads::find( $key );

			$str = syferEncode( $key, $data['sitecode'] );
			
			$list_files[$i]['download'] = route('file', [$str]);
			$list_files[$i]['delete'] = route('file_delete', [$str, $file->delete_hash]);

			$list_files[$i]['html'] = '&lt;a href=&quot;' . route('file', [$str]) . '&quot; target=&quot;_blank&quot; title=&quot;Download From FileSpace.io&quot;&gt;download ' . $file->title . '.' . $file->file_ext;
			$list_files[$i]['forum'] = '[url=&quot;' . route('file', [$str]) . '&quot;]' . $file->title . '.' . $file->file_ext . '[/url]';
			$list_files[$i]['title'] = $file->title . '.' . $file->file_ext . '(' . formatBytes( $file->filesize_bytes, 2 ) . ')';

			$i++;
		}

		if( count( $list_files ) > 0 )
		{
			return response()->json( array( 'success' => true, 'files' => $list_files ) );
		} 

		return response()->json( array( 'success' => false ));
	}

    public function statusPublic( $status = 0 )
	{
		$json['success'] = false;
		
		if ( isset( $_POST[ 'ajax' ] ) )
		{
			$table 	= $_POST[ 'type' ] == 'file' ? 'chs_file_uploads' : 'chs_file_folders';
			$id 	= $_POST[ 'id' ];

			DB::table( $table )->where( 'id', $id )->update( array(
				'is_public' => $status
				) );
			
			$json[ 'success' ] = true;
		}
		
		return response()->json( $json );
	}

	public function statusPremium( $status = 0 )
	{
		$json['success'] = false;
		
		if ( isset( $_POST[ 'ajax' ] ) )
		{
			$table 	= $_POST[ 'type' ] == 'file' ? 'chs_file_uploads' : 'chs_file_folders';
			$id 	= $_POST[ 'id' ];
			
			DB::table( $table )->where( 'id', $id )->update( array(
				'is_premium_only' => $status
			));
			
			$json[ 'success' ] = true;
		}
		
		return response()->json( $json );
	}

	
	public function checkPassword()
	{
		$json = array();
		$json[ 'success' ] = false;

		$fileid = (int) $_POST[ 'file_id' ];
		
		if ( isset( $_POST[ 'password' ] ) && isset( $fileid ) )
		{
			$file = FileUploads::find( $_POST['file_id'] );
			
			$has_passwd = $file->password;

			if( $file->folder_id != 0 )
			{
				$folder = FileFolders::find( $file->folder_id );
				if( !empty($folder->password) )
				{
					$has_passwd = $folder->password;
				} else {
					$has_passwd = $file->password;
				}
			} else {
				$has_passwd = $file->password;
			}

			if ( $file )
			{
				if ( $has_passwd == $_POST[ 'password' ] )
				{
					$json[ 'success' ] = true;
				}
			}
		}
		
		return response()->json( $json );
	}

	public function single_showlink(Request $request)
	{
		$file = FileUploads::find($request->id);

		$sitecode = WebsiteCodes::where( 'user id', 0)->first(); 

		$data = array();

		$i = 0;	

        $krypt = syferEncode($file->id, $sitecode->code);

        $data = [
        	'url_download' 	=> url('file/' . $krypt), 
        	'url_delete' 	=> url('file/delete/' . $krypt . '/' . $file->delete_hash),
        	'title'			=> $file->title . '.' . $file->file_ext,
        	'main_title'	=> $file->title . '.' . $file->file_ext . '(' . formatBytes( $file->filesize_bytes, 2 ) . ')'
        ];

		return response()->json($data);
	}

	public function mass_showlinks()
	{
		$id = request()->get('ids');

		$ids = FileUploads::whereIn('id', $id)->get();

		$sitecode = WebsiteCodes::where( 'user id', 0)->first(); 

		$data = array();

		$i = 0;	

		foreach ( $ids as $file ) 
		{
			$sitecode = WebsiteCodes::where( 'user id', 0)->first();

            $krypt = syferEncode($file->id, $sitecode->code);

            $data[] = [
            	'url_download' 	=> url('file/' . $krypt), 
            	'url_delete' 	=> url('file/delete/' . $krypt . '/' . $file->delete_hash),
            	'title'			=> $file->title . '.' . $file->file_ext,
            	'main_title'	=> $file->title . '.' . $file->file_ext . '(' . formatBytes( $file->filesize_bytes, 2 ) . ')'
            ];

            //$i++;
		}

		return response()->json($data);
	}

	public function post_setpassword()
	{
		$ids = request()->get('ids');
		$password = request()->get('pass');
		$cpassword = request()->get('cpass');

		if( $password != $cpassword )
		{	
			$response = array('success' => false);
			return response()->json( $response );
		}

		$file = FileUploads::whereIn('id', $ids)->update(array('password' => $password));

		$response = array('success' => true);

		return response()->json( $response );
	}

	private function mass_delete()
	{
		$items 			= $_POST[ 'file' ][ 'selected' ];
		$multi_type 	= $_POST[ 'file' ][ 'multi_type' ];
		$multi_type_db 	= $multi_type == 'file' ? 'chs_file_uploads' : 'chs_file_folders';
		
		$user = Auth::user();
		
		foreach ( $items as $item_id )
		{

			$item = DB::table($multi_type_db)->where('id', $item_id)->first();
			
			if ( !is_null( $item ) )
			{
				if ( $multi_type == 'file' )
				{
					// decrement file count from source folder

					$fu = FileUploads::find($item_id);
					
					if($ff = FileFolders::find($fu->folder_id)) 
					{
						$ff->decrement('total_files');
					}
					

					
					$this->update_user_file_stat( false, $item->filesize_bytes );
					
					$file_servers = Filenas::get_file_servers();

					foreach ( $file_servers as $server )
					{
						$server = (array) $server;
						if ( $server[ 'serverType' ] == 'direct' )
						{
							$this->update_filserver_file_space( $server, false, $item->filesize_bytes );
						}
					}
				}
				else
				{

					$dir = FileUploads::where('folder_id', $item->id);
					
					if ( $dir->count() > 0) {
						
						$user->decrement('folders');

						
						$ff = FileFolders::find($item->id)->delete();

						$files = FileUploads::where('folder_id', $item->id);

						$count = $files->sum('filesize_bytes');

						$files->delete();

						$temp->decrement('storage_used', $count);
						
						Session::put('folder_count', $user->folders - 1 );
					
						
					} else {
						$user->decrement('folders');
						
						$ff = FileFolders::find($item->id)->delete();

						return redirect()->to('/folders')->with( '_multi_select_action', '<div class="page-title-success">Unable to delete folder with existing files inside</div>' );
					}
				}

				DB::table($multi_type_db)->where('id', $item_id)->delete();
			}
		}
		
		Session::flash( '_multi_select_action', '<div class="page-title-success"><span class="success-page-title">Successfully deleted </span></div>' );
		if ( isset( $_POST[ 'file' ][ 'folder_id' ] ) )
		{
			return redirect()->to( '/folders/'. $_POST[ 'file' ][ 'folder_id' ] );
		}
		
		return redirect()->to( 'users/'. $multi_type == 'file' ? 'files/' : 'folders/' );

	}

	public function multiSelectAction()
	{
		// @TODO change 'file' to 'multi'
		if ( !isset( $_POST[ 'file' ] ) )
		{
			return redirect()->to('/');
		}
		
		$file = $_POST[ 'file' ];
		
		if ( empty( $_POST[ 'file' ] ) )
		{
			return redirect()->to('/');
		}
		
		if ( empty( $file[ 'selected' ] ) )
		{
			return redirect()->route( 'user_files' )->with( '_multi_select_action', '<div class="alert alert-error">No file is selected.</div>');
		}
		
		$this->{ $file[ 'action' ] }();
		return redirect()->back()->with('_multi_select_action', '<div class="page-title-success"><span class="success-page-title">Successfully updated.</span></div>');
	}

	private function premium_only()
	{
		$files 		= $_POST[ 'file' ][ 'selected' ];
		$multi_type = $_POST[ 'file' ][ 'multi_type' ];
		$multi_type = $multi_type == 'file' ? 'chs_file_uploads' : 'chs_file_folders';
		
		foreach ( $files as $file_id )
		{
			DB::table($multi_type)
			->where('id', $file_id)
			->where( 'user_id', Auth::id() )
			->update(array(
				'is_premium_only' => 1
				));
		}
		
		Session::flash( '_multi_select_action', '<div class="page-title-success"><span class="success-page-title">Successfully made the '. ( $multi_type == 'chs_file_uploads' ? 'files' : 'folders' ) .' accessible only to premium users</span></div>' );
		
		if ( isset( $_POST[ 'file' ][ 'folder_id' ] ) )
		{
			return redirect()->to( 'files/folder/'. $_POST[ 'file' ][ 'folder_id' ] );
		}
		
		return redirect()->to( $multi_type == 'chs_file_uploads' ? 'files/' : 'folders/' );
		
	}
	
	private function not_premium_only()
	{
		$files 				= $_POST[ 'file' ][ 'selected' ];
		$multi_type_name 	= $_POST[ 'file' ][ 'multi_type' ];
		$multi_type 		= $multi_type_name == 'file' ? 'chs_file_uploads' : 'chs_file_folders';
		
		foreach ( $files as $file_id )
		{
			DB::table($multi_type)
			->where('id', $file_id)
			->where( 'user_id', Auth::id() )
			->update(array(
				'is_premium_only' => 0
				));
		}
		
		Session::flash( '_multi_select_action', '<div class="page-title-success"><span class="success-page-title">Successfully made the '. ( $multi_type_name == 'file' ? 'files' : 'folders' ) .' accessible to all types of users</span></div>' );
		
		if ( isset( $_POST[ 'file' ][ 'folder_id' ] ) )
		{
			return redirect()->to( 'files/folder/'. $_POST[ 'file' ][ 'folder_id' ] );
		}
		
		return redirect()->to( $multi_type_name == 'file' ? 'files/' : 'folders/' );
	}

	public function moveFolder(Request $request)
	{
		if ( $request->method() === 'POST' )
		{
			$mv_folder = isset( $_POST[ 'move_to_folder' ] ) ? $_POST[ 'move_to_folder' ] : null;
			$mv_files = isset( $_POST[ 'files' ] ) ? trim( $_POST[ 'files' ] ) : null;
			
			if ( !is_null( $mv_files ) && !is_null( $mv_folder ) && $mv_folder !== '' )
			{
				$mv_files = explode( ',', $mv_files );
				$num_mv = count( $mv_files );
				
				// decrement file count from source folder

				DB::statement("
					UPDATE chs_file_folders SET total_files = total_files - $num_mv 
					WHERE id = (SELECT folder_id FROM chs_file_uploads WHERE id = {$mv_files[0]})
				");

				// increment file count to destination folder

				if( $mv_folder == 0 )
				{
					FileUploads::whereIn( 'id', $mv_files )->update( array( 'folder_id' => (int) $mv_folder ) );

					$message = 'Successfully moved '. $num_mv .' file'. ( $num_mv > 1 ? 's' : '' );
					return redirect()->route( 'user_files' )->with( '_multi_select_action', '<div class=\'page-title-success\'><span class=\'success-page-title\'>'. $message .'</span></div>' );

				}
				else
				{
					$filefolder = FileFolders::find( $mv_folder );
					$filefolder->update( array( 'total_files' => DB::raw( 'total_files + ' . $num_mv ) ) );
				
					FileUploads::whereIn( 'id', $mv_files )->update( array( 'folder_id' => (int) $mv_folder ) );

					$message = 'Successfully moved '. $num_mv .' file'. ( $num_mv > 1 ? 's' : '' );
				}

				
				
				return redirect()->route( 'folder', [$mv_folder] )->with( '_multi_select_action', '<div class=\'page-title-success\'><span class=\'success-page-title\'>'. $message .'</span></div>' );
			}

			return redirect()->back();
		}
	}
}
