@extends('layouts.base')
@section('title', 'Login')
@section('content')
<div class='content'>
    <div class='page-title'>
        <span class='login-page-title'>
            {{ Request::segment(1) != 'resellers' ? 'User login' : 'Reseller Login' }}
        </span>
    </div>
      
    <div class='login-form'>
        
        @if( Request::segment(1) != 'resellers' )
            <form role="form" action="{{ route('user_login') }}" method="post" id="login-form">
             {!! csrf_field() !!}
                <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" name="login[username]" class="form-control" id="login_username" placeholder="Username" maxlength="12">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="login[password]" class="form-control" id="login_password" placeholder="Password" maxlength="12">
                </div>
                <div class="checkbox" style="margin-left:20px;">
                    <label>
                      <input type="checkbox" name="login[remember]" value="yes"> Remember Me
                    </label>
                  </div>
                <div class='forgot-password-text'>
                    Forgot password? <a href="{!! url('/forgot-password') !!}">Click here</a>
                </div>
                <div class='align-center login-btn-holder'>
                    <input type="submit" id='login-btn' class="btn btn-default" value="Submit" />
                </div>
                <br />
                <div class='forgot-password-text'>
                    Not Registered Yet? <a href="{{ url('/signup') }}">CLICK HERE</a>
                </div>
            </form>

            <div class="login-alert-holder">
                <div class="alert alert-danger " style="display: {!! session('error') ? 'block' : 'none' !!}" id="login-alert">
                    @if ( session('error') )
                       {!! session('error') !!}
                    @endif
                </div>
            </div>
        @else
            <form role="form" action="{{ route('reseller_login') }}" method="POST" id="login-forms">
             {!! csrf_field() !!}
                <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" name="login[username]" class="form-control" id="login_username" placeholder="Username" maxlength="12">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="login[password]" class="form-control" id="login_password" placeholder="Password" maxlength="12">
                </div>
                <div class='align-center login-btn-holder'>
                    <input type="submit" id='login-btn' class="btn btn-default" value="Submit" />
                </div>
            </form>
            @if ( session('error') )
            <div class="login-alert-holder">
                <div class="alert alert-danger " style="display: block;" id="login-alert">
                    
                       {!! session('error') !!}
                    
                </div>
            </div>
            @endif
        @endif
    </div>
</div>
<script>
$( function() {
    $( '#login-form' ).on( 'submit', function ( evt ) {
        var user = $( '#login_username' ).val();
        var pwd =  $( '#login_password' ).val();
        
        if (!user.length || !pwd.length) {
            $( '#login-alert' ).html( 'Please fill in all fields' ).show();
            return false;
        } else if (user.length < 6 && pwd.length < 6) {
            $( '#login-alert' ).html( 'Username or password field\'s minimum length is 6' ).show();
            return false;
        } else if (user.length < 6) {
            $( '#login-alert' ).html( 'Username field\'s minimum length is 6' ).show();
            return false;
        } else if (pwd.length < 6) {
            $( '#login-alert' ).html( 'Password field\'s minimum length is 6' ).show();
            return false;
        } else {
            $.ajax({
                url: _saveDeviceUrl,
                type: 'POST',
                contentType: 'application/json',
                dataType: 'json',
                data: {'login[username]': user, 'login[password]' : pwd},
                success: function (data) {
                    if (!data) {
                        $( '#login-alert' ).html( 'Incorrect Username or Password' ).show();
                        return false;
                    }
                }
            });
        }    
        return true;
    } );
} );
</script>

@stop