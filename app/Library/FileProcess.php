<?php 

class FileProcess
{
	const ERR_SOURCE_NULL 	= 0x100;
	const ERR_MD5_DUPE 		= 0x101;
	const ERR_NEW_DIR		= 0x102;
	const ERR_NONE			= 0x000;
	
	public $options = array(
		'tmp_dir' 		=> 'uploads/tmp/',
		'upload_dir' 	=> 'uploads/',
		'files_db'		=> 'chs_file_uploads'
	);
	
	public function __construct( $options = array() )
	{
		
		$this->options = $options + $this->options;
	}
	
	private $source = null;
	
	public function set_source( $source )
	{
		if ( is_null( $this->source ) )
		{
			$this->source = $source;
		}
	}
	
	public $file 		= null;
	public $db_id 		= null;
	public $dir			= null;
	public $size		= null;
	public $path_info 	= null;

	public function run()
	{
		if ( is_null( $this->source ) )
		{
			return FileProcess::ERR_SOURCE_NULL;
		}
		
		if ( !is_dir( $this->options[ 'tmp_dir' ] ) )
		{
			mkdir( $this->options[ 'tmp_dir' ], 0777, true );
		}
		
		$this->dir 	= $this->generate_dir_name() . '/';
		$new_dir 	= $this->options[ 'upload_dir' ] . $this->dir;
		
		if ( !is_dir( $new_dir ) )
		{
			mkdir( $new_dir, 0777, true );
		}
		
		$source_info 	= pathinfo( $this->source );
		$new_file 		= $new_dir . $source_info[ 'basename' ];

		/*if( ! File::move( $this->source, $new_file ) )
		{
			return FileProcess::ERR_NEW_DIR;
		}*/

		$this->file 		= $new_file;
		$this->size 		= @filesize( $this->file );
		$this->path_info 	= pathinfo( $this->file );

		if ( ( $this->db_id = $this->check_file_md5() ) === false )
		{
			
			unlink( $this->file );
			return FileProcess::ERR_MD5_DUPE;
			
		}
		
		return FileProcess::ERR_NONE;
	}
	
	public function generate_dir_name()
	{
		$user_id = Auth::check() ? Auth::id() : 0;

		return round( $user_id / 5000 );
	}
	
	public $file_md5 = null;
	
	public function check_file_md5( $file )
	{
		$this->file_md5 = md5_file( $file );
		
		$query = FileUploads::where( 'file_md5', $this->file_md5 )->first();
		
		if ( count( $query ) )
		{
			return false;
		}
		
		$file_upload = new FileUploads;
		$file_upload->file_md5 = $this->file_md5;
		$file_upload->save();

		return $file_upload->id;
	}
}