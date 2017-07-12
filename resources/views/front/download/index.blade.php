@extends('layouts.base')
@section('title', 'Download ' . $file->title . '.'. $file->file_ext)
@section('content')
<?php
    $user = (object) $user;
    
    
    $is_premium = Auth::check() ? isPremium( $user ) : false;
    $file = (object) $file;
    $width = 0;
    if( Auth::check() && Auth::id() == $file->user_id ) {
        $width = '300px';
    } elseif( ! Auth::check() || ! $is_premium && Auth::id() != $file->user_id ) {
            $width = '820px'; 
    } else {
        $width = '600px';
    }
    $own = false;
    if( Auth::check() )
    {
        $own = check_if_own_file( $file->user_id );
    }
?>
<div class="content">
    @if( $seconds_interval === false )
        <div class="page-title">
            <span class="download-page-title">
                Download <span style="color: #E15A48">{{ $file->title .'.'. $file->file_ext }}</span> ( {{ formatBytesNumber( $file->filesize_bytes, 2 ) }} )
            </span>
        </div>

        @if( $own == FALSE )
        <div class="download-table">
            <table class="table table-bordered table-download">
                <tbody><tr>
                    <td class="title">Feature</td>
                    <td class="title">Unregistered</td>
                    <td class="title">Registered</td>
                    <td class="title">Premium</td>
                </tr>
                <tr>
                    <td class="red-bg">MAX DOWNLOAD SPEED</td>
                    <td>{{ number_format($settings->free_user_max_download_speed, 0, '.', ',') }} KB/Sec</td>
                    <td>{{ number_format($settings->register_user_max_download_speed, 0, '.', ',') }} KB/Sec</td>
                    <td>{{ number_format($settings->premium_user_max_download_speed, 0, '.', ',') }} KB/Sec</td>

                </tr>
                <tr>
                    <td class="red-bg">PARALLEL DOWNLOADS</td>
                    <td><img src="{{ url( '/img/icons/error.png' ) }}"></td>
                    <td><img src="{{ url( '/img/icons/error.png' ) }}"></td>
                    <td><img src="{{ url( '/img/icons/success.png') }}"></td>
                </tr>
                <tr>
                    <td class="red-bg">DOWNLOAD COUNTDOWN</td>
                    <td>{{ $settings->free_users_delay }} Secs</td>
                    <td>{{ $settings->register_users_delay }} Secs</td>
                    <td>0 Secs</td>
                </tr>
                <tr>
                    <td class="red-bg">ALLOWED DOWNLOADS PER HOUR</td>
                    <td>Only 1</td>
                    <td>Only 1</td>
                    <td>Unlimited</td>
                </tr>
                <tr>
                    <td class="red-bg">FILES IMPORT</td>
                    <td><img src="{{ url( '/img/icons/error.png' ) }}"></td>
                    <td><img src="{{ url( '/img/icons/error.png' ) }}"></td>
                    <td><img src="{{ url( '/img/icons/success.png' ) }}"></td>
                </tr>
                <tr>
                    <td class="red-bg">ADVERTISING</td>
                    <td><img src="{{ url( '/img/icons/success.png' ) }}"></td>
                    <td><img src="{{ url( '/img/icons/success.png' ) }}"></td>
                    <td><img src="{{ url( '/img/icons/error.png' ) }}"></td>
                </tr>
            </tbody></table>
        </div>
        @else
            <style type="text/css">
                .content {
                    height: 500px;
                }
                .download-buttons{
                   margin-top: 10%;
                }
            </style>
        @endif

        @if ( $is_premium && Auth::check() && Auth::id() != $file->user_id )
            <style type="text/css">
                .download-buttons{
                    width: 600px !important;
                }
            </style>

        @endif        
        
        @if ( !$server_off )
            <div class="download-buttons" id="dbtn" style="width:{{ $width }}">
                @if ( ! Auth::check() || ! $is_premium && Auth::id() != $file->user_id)
                    <div class="low-speed-holder">

                        <button class="btn btn-low-speed-download" id="slow-download-btn" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Sorry, not available for this file &lt;br /&gt;Please uopgrade to premium">
                            Low Speed Download
                        </button>
                    </div>
                    <div class="high-speed-holder">
                        <a class="btn btn-high-speed-download" href="{{ url( 'files/premium-download' ) }}">
                            High Speed Download
                        </a>
                    </div>
                @else
                    <div class="high-speed-holder" style="text-align:center;">
                        <a class="btn btn-high-speed-download" target="_blank" id="fast-download-btn" href="{{ url( 'files/premium-download' ) }}">
                            High Speed Download
                        </a>
                    </div>
                @endif
                <div class="inport-to-cloud-holder" style="@if( Auth::check() ) {{ Auth::id() != $file->user_id ? '' : 'display:none'}} @endif">
                    <a href="{{ url('files/import-cloud') }}" class="btn btn-inport-to-cloud">
                        Import to Your Cloud
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="download-enter-password" id="password_field">
                <div class="download-password-title">
                    A password is required to download this file
                </div>
                <div class="download-password-form">
                        <form id="password_form" class="form-inline" role="form">
                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label class="sr-only" for="file_password">Password</label>
                            <input type="password" class="form-control" id="file_password" placeholder="Enter the password">
                        </div>
                        <button type="submit" class="btn btn-default" id="submit-pass">Submit</button>
                    </form>
                    <div class="alert alert-danger download-password-alert" id="password-alert">
                        Sorry, wrong password please try again
                    </div>
                </div>
            </div>
            
        @else
            <div id="server-off">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert-block">
                            <h4>Can't download this file at the moment.</h4>
                            Sorry the file you are trying to download is not available because of maintenance on this server, please try again later.
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        <div id="disp-timer" style="display:none; margin: 10px auto; width: 250px"></div>
        
        <div class="download-capcha-holder">
            <form id="capcha-form" method="post">
            {!! csrf_field() !!}
           
            <script src='https://www.google.com/recaptcha/api.js'></script>
            <div class="g-recaptcha" data-sitekey="6Ldi9fcSAAAAAP8H3xOJmJR0z-bX5yOIWo-7iDrv"></div>
            <div class="align-center login-btn-holder">
                <button type="submit" id="login-btn" class="btn btn-default">Submit</button>
            </div>

            </form>
            <span class="loader" style="display:none;"><img src="{{ url('assets/img/loaders/1.gif') }}"></span>
            <span class="capcha-error alert alert-danger" style="text-align:center;">Wrong Captcha!</span>
        </div>
        
    @else
        <div class='page-title-error'>
            <span class='download-time'>
                Download {{ $file->title .'.'. $file->file_ext }} ( {{ formatBytesNumber( $file->filesize_bytes, 0 ) }} )
            </span>
        </div>
        
        <?php
            $interval_display = '';
            $minutes = floor( $seconds_interval / 60 );
            $seconds = $seconds_interval % 60;

            if ( $minutes > 1 )
            {
                $interval_display = '<span id="minutes"> %d </span> minutes, ';
            }
            else if ( $minutes == 1 )
            {
                $interval_display = '<span id="minutes"> %d </span> minute, ';
            }

            if ( $seconds > 1 )
            {
                $interval_display .= '<span id="seconds"> %d </span> seconds'; 
            }
            else
            {
                $interval_display .= ' %d second';
            }
        ?>
        <div class="download-time-body">
            <div class="download-time-icon">
                <img src="../img/icons/download-clock.png" />
            </div>
            <!-- <div class="download-time-text">
                    You need to wait <span style="font-size: 24px">{{ $minutes <= 0 ? sprintf( $interval_display, $seconds ) : sprintf( $interval_display, $minutes, $seconds ) }}</span> before you can download a file again.
                    You can remove this restriction by upgrading to a <a href="{{ url('upgrade') }}">premium account</a>.
            </div> -->
            <div class="download-time-text">
                You need <span class="download-timer">{!! $minutes <= 0 ? sprintf( $interval_display, $seconds ) : sprintf( $interval_display, $minutes, $seconds ) !!}</span><br />
                    before you can download a file again.
            </div>
            <div class="download-time-upgrader">
                You can remove this restriction by upgrading to a <a href="{{ url('upgrade') }}">PREMIUM ACCOUNT</a>.
            </div>
        </div>
    @endif
</div>
<div id="frame-container"></div>
<style type="text/css">
.alert{margin-top: 15px;}
    .alert-danger {
    color: #FF1800;
    background-color: #FBEBE9;
    border-color: #FBEBE9;
}
</style>
<script>
$( function() {

    $min = $('#minutes').text();
    $sec = $('#seconds').text();

    setInterval(function(){
        if($sec == 0){
            $sec = 60;
            $min = $min -1;
        }
    $sec = $sec -1;

    $('#seconds').text($sec)
    $('#minutes').text($min)
    }, 1000);
    
    @if ( $file->is_premium_only )
        $( '#slow-download-btn' ).on( 'click', function ( evt ) {
            return false;
        } );
        
        $( '#slow-download-btn' ).tooltip( {
            html: true
        } );
    @endif
    
    $( '#frame-container' ).append( '<iframe id="dl-frame" style="width: 1px; height: 1px; position: absolute; left: -9999px;"></iframe>' );
    
    
    var dt = $( '#countdown' ), dnval = null, has_file_password = {{ $has_passwd ? 1 : 0 }};
    
    function get_timer()
    {
        
        $.ajax( {
            type: 'POST',
            url: '{{ route( 'file_download_boot' ) }}',
            data: {
                send: 1,
                _token: '{!! csrf_token() !!}'
            },
            success: function( data, ts, xhr ) {
               
                if ( data.success )
                {
                    var delay = parseInt( data.delay, 10 );
                
                    dt.text( delay );
                    
                    dnval = setInterval( function() {
                        delay -= 1;
                        dt.text( delay );
                        
                        if ( delay <= 0 )
                        {
                            clearInterval( dnval );
                            dnval = null;
                            $( '#dl-frame' ).attr( 'src', '{{ route( 'stream_file', [$enc_file] ) }}?token='+ data.download_token );
                        }
                    }, 1000 );
                }
            }
        } );
    }
    
    @if ( ! $file->is_premium_only )
        $( '#slow-download-btn' ).on( 'click', function ( evt ) {
            evt.preventDefault();
            
            $('.download-capcha-holder').css('display', 'block');
            
            
            return false;
        } );

        $('#capcha-form').submit(function( evt ){
            evt.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'post',
                cache:false,
                url:'{{ route('download_capcha') }}',
                data: $('#capcha-form').serialize(),
                beforeSend: function(request) {
                    $('.alert').css('display', 'none');
                    $('.loader').css('display', 'block');
                },
                success:function( data, ts, xhr ){
                    $('.loader').css('display', 'none');
                    if( data.success )
                    {
                        $('.capcha-error').css('display', 'none');
                        var chkPasswordHttp = null;
                        if ( !has_file_password )
                        {
                            
                            $( '.low-speed-holder' ).append( '<div class="download-countdown-timer">Please wait <span id="countdown"></span> seconds<br>or upgrade to premium</div>' );
                            dt = $( '#countdown' );
                            $( '#slow-download-btn' ).fadeOut( function() {
                                $( '.download-countdown-timer' ).fadeIn( 200 );
                                get_timer();
                            } );
                            $('.download-capcha-holder').css('display', 'none');
                        }
                        else
                        {
                            $( '#disp-timer' ).html( '<div class="download-countdown-timer">Please wait <span id="countdown"></span> seconds<br>or upgrade to premium</div>' );
                            $( '#dbtn' ).hide();
                            $( '#password_field' ).show();
                            dt = $( '#countdown' );
                        }
                    }
                    else
                    {
                        $('.capcha-error').css('display', 'block');
                    }
                }
            });
        });
    @endif
    $( '#password_form' ).on( 'submit', function() {
        var sp_val = $( '#submit-pass' ).text();
        $.ajax( {
            url: '{{ route( 'file_check_password' ) }}',
            type: 'POST',
            data: {
                password: $( '#file_password' ).val(),
                file_id: '{{ $file->id }}',
                _token: '{!! csrf_token() !!}'
            },
            beforeSend: function() {
                $( '#submit-pass' ).removeClass( 'btn-default' ).attr( 'disabled', 'disabled' ).text( 'Loading...' );
            },
            
            success: function( data, ts, xhr ) {
                if ( data.success )
                {
                    $( '#password-alert' ).hide();
                    $( '#submit-pass' ).removeAttr( 'disabled' ).addClass( 'btn-default' ).text( sp_val );
                    $( '#disp-timer' ).show();
                    $( '.download-countdown-timer' ).show();
                    get_timer();
                }
                else
                {
                    $( '#submit-pass' ).removeAttr( 'disabled' ).addClass( 'btn-default' ).text( sp_val );
                    $( '#password-alert' ).show();
                }
            },
            error: function() {
                $( '#submit-pass' ).removeAttr( 'disabled' ).addClass( 'btn-default' ).text( sp_val );
            }
        } );
        return false;
    } );
    
    var pa_default = $( '#password-alert' ).html();
    $( '#file_password' ).on( 'keyup', function ( evt ) {
        if ( this.value.length < 4 || this.value.length > 6 )
        {
            $( '#password-alert' ).html( 'Password length is between 4 to 6 characters' ).show();
        }
        else
        {
            $( '#password-alert' ).html( pa_default ).hide();
        }
    } );
    
    @if ( Auth::check() && ( $is_premium || Auth::user()->id == $file->user_id ) )
        $( '#fast-download-btn' ).on( 'click', function ( evt ) {
            evt.preventDefault();

            $.ajax( {
                url: '{{ route( 'file_download_boot' ) }}',
                type: 'POST',
                data: {
                    send: 1,
                    _token: '{!! csrf_token() !!}'
                },
                success: function( data, ts, xhr )
                {
                    if ( data.success )
                    {
                        $( '#dl-frame' ).attr( 'src', '{{ rote( 'stream_file', [$enc_file] ) }}?token='+ data.download_token );
                    }
                }
            } );
            
            return false;
        } );
    @endif
} );
</script>
@stop