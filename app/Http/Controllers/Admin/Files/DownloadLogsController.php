<?php

namespace App\Http\Controllers\Admin\Files;

use App\Models\WebsiteCodes;
use App\Models\DownloadTracker;
use App\Library\Datatables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DownloadLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.downloadlogs.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function listings()
    {
        $table = Datatables::create(DownloadTracker::with('file'), $_GET, [
            'date_started', 
            'DESC'
        ]);

        $table['output']['data'] = [];

        foreach ($table['result'] as $key => $dt) 
        {
            $sitecode = WebsiteCodes::where( 'user id', 0)->first(); 

            $krypt_file = syferEncode($dt->file->id, $sitecode->code);
     
            $action = empty($dt->file_id ) ? '' : '<a href="' . url( '/file/' . $krypt_file ) .'" data-delete class="btn btn-success btn-xs" target="_blank">Download</a> &nbsp;';

            $userid = empty($dt->file->user_id) ? '' : ( $dt->fileupload->user_id != 0 ? ($dt->fileupload->user->username) : '' );

            

            

            $row = array();
            $row[] = '<span style="display:block">' .date('Y-m-d', strtotime($dt->date_started)) . '</span>' . date('H:i:s', strtotime($dt->date_started));
            $row[] = '<a target="_blank" href="'. url('file/' . $krypt_file) . '">' . ($dt->file ? $dt->file->title . '.' . $dt->file->file_ext : '') . '</a>';
            $row[] = $dt->file->user ? $dt->file->user->username : '';// ? true : false;
            $row[] = $dt->download_username;
            $row[] = $dt->ip_address. ' ('.$dt->download_country.')'; 
            $row[] = $dt->status == 'finished' ? 'Yes(' . $dt->download_speed . ')' : 'No';
            $row[] = $dt->referring_url;
            $row[] = $action;


            $table['output']['data'][] = $row;
        }

        return Datatables::generateJSON($table['output']);
    }
}
