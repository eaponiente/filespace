<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileFolders extends Model
{
    protected $table = 'chs_file_folders';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function fileuploads()
    {
    	return $this->hasMany(FileUploads::class, 'folder_id');
    }

	public function get_folders($user_id)
	{
		$this->table = 'chs_file_folders as f';

		$query = $this::where('user_id', $user_id)
		->select('f.*', DB::raw(' (SELECT COUNT(id) FROM chs_file_uploads WHERE f.id = folder_id AND user_id = f.user_id ) file_count') )
		->orderBy('date_created', 'DESC')
		->get();

		return $query->toArray();
	}
}
