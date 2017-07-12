<?php

namespace App\Http\Controllers\Admin;

use App\Models\AbuseReport;
use App\Library\Datatables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AbusesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.abuses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
        $table = Datatables::create(new AbuseReport, $_GET, [
            'id', 
            'DESC'
        ]);

        $table['output']['data'] = [];

        foreach ($table['result'] as $key => $rows) 
        {
            $action = delete_method( route('admin.vouchers.destroy', [$rows->id]) );

            $row = array();
            $row[] = $rows[ 'code' ];
            $row[] = $rows[ 'email' ];
            $row[] = $rows[ 'reported_links_amount' ];
            $row[] = $rows[ 'report_datetime' ];
            $row[] = $rows[ 'reply_datetime' ];
            $row[] = $action;


            $table['output']['data'][] = $row;
        }

        return Datatables::generateJSON($table['output']);
    }

    public function submit_process()
    {
        $data = Input::get('data');

        if( Input::get( 'btn' ) == 'delete' )
        {
            
            $links = explode(';', $data[ 'links' ] );

            $sh = new StringHelper;

            if( !empty( $data[ 'links' ] ) )
            {
                foreach ( $links as $link ) 
                {
                    $segment = pathinfo( trim($link) );
                    if( strlen ( $segment[ 'filename' ] ) == 20 )
                    {
                        $string = $segment[ 'filename' ];
                        
                        $alphanum_index = $this->parse_alphanum_index( $string );
                        $numeric_index  = $this->parse_numeric_index( $string );
                        
                        $alphanum_field = $this->get_alphanum_field( $alphanum_index );
                        $numeric_field  = $this->get_numeric_field( $numeric_index );
                        
                        if( ! $alphanum_field || ! $numeric_field ) continue;

                        $ids = $sh->syfer_to_decode( $segment[ 'filename' ] );

                        $fileid = (int) $ids[ 'fileid' ];

                        if( $file = FileUploads::find( $fileid ) )
                        {
                            if( !Md5Ban::where('md5_file', $file->file_md5)->first() ){
                                $md5 = new Md5Ban;
                                $md5->md5_file = $file->file_md5;
                                $md5->save();
                            }

                            $files = FileUploads::whereFileMd5($file->file_md5)->distinct()->get(array('user_id'));

                            if(!$files->isEmpty())
                            {
                                foreach ($files as $key) 
                                {
                                    if($key->user_id != 0)
                                    {
                                        $file_owner = User::find($key->user_id);
                                        $file_owner->decrement('custom_storage', $file->filesize_bytes);
                                        $file_owner->decrement('files');
                                    }
                                }
                            }
                            
                            $fn = Filenas::find($filenas_id);
                            $fn->decrement('space_used', $file->filesize_bytes);
                            FileUploads::whereFileMd5($file->file_md5)->delete();



                            GlobalStats::increment_columns('abuses');
                        }
                        
                    }
                }   
            }   

            $abuse = Abuse::find( $data[ 'id' ] );
            $abuse->message = 'processed';
            $abuse->resolved = 1;
            $abuse->reply_datetime = date('Y-m-d h:i:s');
            $abuse->save();

            $info = [
                'name'  => $abuse->name,
                'links' => $links,
                'org'   => $abuse->organization,
            ];

            $inf = [
                'name'  => $abuse->name,
                'email' => $abuse->email,
                'code'  => $abuse->code
            ];

            Mail::send('emails.abuse-reply', $info, function($message) use($inf)
            {
                $message->from('noreply@filespace.io', 'FileSpace.io System');
                $message->to( $inf['email'] , $inf['name'] )->subject( 'Abuse Report Confirmation ' . $inf['code'] );
            });

            
            
            return Redirect::to( Config::get('constants.admin_url') . '/abuses' )->with('message', '<div class="alert alert-success">Successfully deleted the links!</div>');
        }
        else
        {
            $abuse = Abuse::find( $data[ 'id' ] );
            $abuse->message = 'ignored';
            $abuse->resolved = 1;
            $abuse->reply_datetime = date('Y-m-d h:i:s');
            $abuse->save();
        }

        return Redirect::to( Config::get('constants.admin_url') . '/abuses' )->with('message', '<div class="alert alert-danger">Links Ignored!</div>');
    }
}
