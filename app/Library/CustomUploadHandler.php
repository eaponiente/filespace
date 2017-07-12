<?php
namespace App\Library;

use App\Library\UploadHandler;

class CustomUploadHandler extends UploadHandler 
{
	protected function trim_file_name($file_path, $name, $size, $type, $error, $index, $content_range) {

		$str = md5( uniqid() . ( mt_rand() * 1000 ) . time() . $name . mt_rand() );
        $name = str_replace('.', '', $str);
        return $name;
    }
	
	
} 