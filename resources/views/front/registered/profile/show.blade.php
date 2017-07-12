@extends('layouts.base')
@section('title', 'Profile')
@section('content')
<div class='content-registered'>
    <div class='page-title'>
        <span class='profile-page-title'>
           Profile: {{ $user->username }}
        </span>
    </div>

    <div class="profile-body">
        <table class="profile-body-table">
            <tr>
                <td class="profile-label">Email</td>
                <td>
                    <div class="pull-left">
                        <span class="profile-info">{{ $user->email }}</span>
                    </div>
                    <div class="pull-right">
                        <a href="{{ URL::to('profile/change-email') }}" class="profile-edit-link">Change Email</a>
                        <a href="{{ URL::to('profile/change-password') }}" class="profile-edit-link">Change Password</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="profile-label">Status</td>
                <td>
                    <div class="pull-left">
                        <span class="profile-info">
                             <?php 
                                    $is_premium = false;
                                    $date_premium = new DateTime(Auth::user()->premium_expiration_date_and_time);
                                    $date_now     = new DateTime( 'now');
                                ?>

                                @if($date_premium <= $date_now)
                                   {{ 'Registered' }}
                                @else
                                   {{ 'Premium until ' . $date_premium->format( 'F j, Y h:i A' ) }}
                                @endif
                        </span>
                    </div>
                    <div class="pull-right">
                        @if($date_premium <= $date_now)
                            <a href="{{ route('profile_upgrade') }}" class="upgrade-link">Upgrade</a>
                        @endif
                    </div>
                </td>
            </tr>
            <tr>
                <td class="profile-label">Used Space</td>
                <td><span class="profile-info">
                    {{ Auth::user()->fileuploads()->sum('filesize_bytes') == 0 ? 0 . ' KB out of ' . $storage : formatBytes( Auth::user()->fileuploads()->sum('filesize_bytes') ) . ' out of ' . $storage}}
                    
                    {{ ' ('. get_percentage( Auth::user()->fileuploads()->sum('filesize_bytes'), $custom ) .' available)' }}
                    </span></td>
            </tr>
            <tr>
                <td class="profile-label">Max Download Speed</td>
                <td><span class="profile-info">
                    @if($date_premium <= $date_now)
                        {{ $settings->register_user_max_download_speed }}
                    @else
                        {{ $settings->premium_user_max_download_speed }}
                    @endif 

                    KB/sec
                </span></td>
            </tr>
            <tr>
                <td class="profile-label">Interval Between Downloads</td>
                <td><span class="profile-info"> 
                    @if($date_premium <= $date_now)
                        {{ $settings->register_user_download_interval . ' minutes' }}
                    @else
                        {{ 'None' }}
                    @endif 

                </span></td>
            </tr>
            <tr>
                <td class="profile-label">Max Download transfer per Day</td>
                <td><span class="profile-info">
                    @if($date_premium <= $date_now)
                        {{ $settings->registered_user_max_download_transfer_per_day }}
                    @else
                        {{ $settings->premium_user_max_download_transfer_per_day }}
                    @endif 
                    GB
                </span></td>
            </tr>
        </table>
    </div>

</div>

@stop