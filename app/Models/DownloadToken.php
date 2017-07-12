<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DownloadToken extends Model
{
    protected $table = 'chs_download_token';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function file()
    {
    	return $this->belongsTo(FileUploads::class, 'file_id');
    }
}
