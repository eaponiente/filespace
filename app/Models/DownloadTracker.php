<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DownloadTracker extends Model
{
    protected $table = 'chs_download_tracker';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function file()
    {
    	return $this->belongsTo(FileUploads::class, 'file_id');
    }

    public function websitecode()
    {
    	return $this->belongsTo(WebsiteCodes::class, 'website_code_id');
    }
}
