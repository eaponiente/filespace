<?php

namespace App\Http\Controllers\Admin\Files;
use App\Library\Datatables;
use App\Models\FileUploads;
use App\Models\WebsiteCodes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadsController extends Controller
{
    public function index()
    {
    	return view('admin.uploads.index');
    }

    public function listings()
    {
    	$uploads = FileUploads::with('user');

    	$sitecode = WebsiteCodes::where( 'user id', 0)->first();

        $table = Datatables::create($uploads, $_GET, [
            'id', 
            'DESC'
        ]);

        $table['output']['data'] = [];

        foreach ($table['result'] as $key => $value) 
        {
        	$file_id = syferEncode($value->id, $sitecode->code);

        	$date = date( 'Y-m-d H:i:s', strtotime( $value->last_download ) );

			if( !strtotime( $value->last_download ) ) $date = '---';

            $action = '<a href="'. route( 'admin_file_download', [ $file_id] ) .'" data-delete class="btn btn-success btn-xs" target="_blank">Download</a> &nbsp;';
			
			$action .= '<a href="" data-delete class="btn btn-success btn-xs blue" style="margin-top:3px;">Delete</a>';


            $row = array();
            $row[] = $value->title . '.' . $value->file_ext;
            $row[] = $value->filesize_bytes == 0 ? 0 : formatBytes( $value->filesize_bytes );
            $row[] = $value->user ? $value->user->username : '';
            $row[] = $value->datetime_uploaded->format('m/d/Y H:i:s') . ' ('.$value->upload_ip .'  ' . $value->country_code . ')';
            $row[] = $date;
            $row[] = $value->total_downloads == 0 ? $value->total_downloads : '<a href="'. url( Config::get('constants.admin_url') . '/download-logs/files/' . $value->id ).'">' . $value->total_downloads . '</a>';
            $row[] = $action;


            $table['output']['data'][] = $row;
        }

        return Datatables::generateJSON($table['output']);
    }
}
