<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'chs_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    protected $dates = ['registration_date', 'last_visited', 'premium_expiration_date_and_time'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $timestamps = false;

    public function notes()
    {
        return $this->hasMany(Notes::class, 'user_id');
    }

    public function fileuploads()
    {
        return $this->hasMany(FileUploads::class, 'user_id');
    }

    public function filefolders()
    {
        return $this->hasMany(FileFolders::class, 'user_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transactions::class, 'user_id');
    }

    public function country()
    {
        return $this->belongsTo(Countries::class, 'registration_geocountry', 'code');
    }

    public function websitecodes()
    {
        return $this->hasMany(WebsiteCodes::class, 'user id');
    }

    public function scopeTotalStorage($query)
    {
        return $query->fileuploads()->sum('filesize_bytes');
    }

    public function ShowReferrals( $start = 0, $limit = 10, $search = null, $user_id )
    {

            $data = $this::where( 'username', 'LIKE', '%'.$search.'%' )
            ->where('referral_id', $user_id)->orderBy('username', 'DESC')           
            ->orderBy('registration_date', 'DESC')
            ->take( $limit )->skip( $start )->get();
        
        return $data;
    }

    public function getAllRefferals( $search = null, $user_id )
    {
        $data = $this::where( 'username', 'LIKE', '%'.$search.'%' )
        ->where('referral_id', $user_id)    
        ->orderBy('username', 'DESC')->get();
        return $data->count();
    }
}