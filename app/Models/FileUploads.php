<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileUploads extends Model
{
    protected $table = 'chs_file_uploads';

    protected $guarded = ['id'];

    public $timestamps = false;

    protected $dates = ['datetime_uploaded', 'last_download'];

    public function parent()
    {
    	return $this->belongsTo(FileUploads::class, 'parent_id');
    }

    public function folder()
    {
    	return $this->belongsTo(FileFolders::class, 'folder_id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function filenas()
    {
    	return $this->belongsTo(Filenas::class, 'filenas_id');
    }

    public function fileserver()
    {
    	return $this->belongsTo(Fileserver::class, 'fileserver_id');
    }

    public function ShowFiles( $start = 0, $limit = 50, $search = null, $columnSort, $order, $user_id, $folder_id)
    {
        
        $query = FileUploads::search( 'title', $search );

        if( !is_null( $folder_id ) )
        {
            $query = $query->where( 'folder_id', $folder_id );
        }
        $query = $query->whereUserId( $user_id );
        $query = $query->take( $limit )->skip( $start )->orderBy( $this->columnSort( $columnSort ), $order )->get();
        
        return $query;
    }

    public function get_max_pages( $search = null, $user_id, $folder_id )
    {
        $data = FileUploads::search( 'filename', $search );

        if( !is_null($folder_id) )
        {
            $data = $data->where( 'folder_id', $folder_id );
        }
        $data = $data->where( 'user_id', $user_id )->get();

        return $data->count();

    }

    public function columnSort( $value )
    {
        $column = null;
        switch ($value) 
        {
            case 1:
                $column = 'title';
                break;
            case 2:
                $column = 'filesize_bytes';
                break;
            case 3:
                $column = 'datetime_uploaded';
                break;
            case 4:
                $column = 'last_download';
                break;
            default:
                $column = 'datetime_uploaded';
                break;
        }

        return $column;
    }

    public function scopeSearch($query, $column, $value)
    {
        return $query->where( $column, 'LIKE', '%'.$value.'%' );
    }

    public function scopeOrSearch($query, $column, $value)
    {
        return $query->orWhere( $column, 'LIKE', '%'.$value.'%' );
    }

}
