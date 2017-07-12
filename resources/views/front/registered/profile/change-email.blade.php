@extends('layouts.base')
@section('title', 'Change Email')
@section('content')
<div class="content-registered">

    
    <div class="page-title">
        <span class="login-page-title">
            Change email
        </span>
    </div>
    
    <div style="height: 30px"></div>
    
    <div class="sign-up-form-holder">
        <div class="sign-up-form">
            <form class="form-horizontal" role="form" method="POST" id="change-form">
                {!! csrf_field() !!}
                <div class="form-group registration-form-group">
                    <label class="col-sm-12 control-label registration-label">New Email</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="user[email]" placeholder="Enter new email" id="user_email">
                    </div>
                    <div id="success_email">
                        
                    </div>
                </div>


                <div class="form-group email-submit-holder">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" id="registration-submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>

        </div>

    </div>
    <div class="alert alert-success email-success" id="success-message">
        To complete the change please confirm the link on the email we just sent to <span id="email_x"></span>
    </div>
</div>

<script>
var success_html = '<div class="col-sm-4 sign-up-success" style="display:block"><img src="{!! url('img/icons/success.png') !!}"> Succesfull</div>',
    error_html = '<div class="col-sm-4 "><ul class="parsley-error-list"><li style="display: list-item;">@{{text}}</li></ul></div>';
var delay = ( function(){
    var timer = 0;
    return function( callback, ms ){
        clearTimeout( timer );
        timer = setTimeout( callback, ms );
    };
} )();
function check_email()
{
    var email = $( '#user_email' ).val();
    
    $.ajax( {
        url: '{!! route('profile_check_email') !!}',
        data: {
            email: email,
            _token: '{!! csrf_token() !!}'
        },
        type: 'POST',
        success: function( data, ts, xhr )
        {
            if ( data.success )
            {
                $( '#success_email' ).html( success_html );
                proceed = true;
            }
            else
            {
                $( '#success_email' ).html( error_html.replace( /@{{text}}/, data.message ) );
            }
        }
    } );
}
var proceed = false;
$( function() {
    $( '#user_email' ).on( 'keyup blur', function() {
        delay( check_email, 900 );
    } );
    
    $( '#change-form' ).on( 'submit', function () {
        var form_data = $( this ).serialize();
        
        if ( proceed )
        {
            $.ajax( {
                url: '{!! route( 'profile_change_email' )!!}',
                type: 'POST',
                data: form_data,
                beforeSend: function() {
                    $( '#success-message' ).hide();
                },
                
                success: function ( data, ts, xhr ) {
                    if ( data.success )
                    {
                        $( '#email_x' ).text( $( '#user_email' ).val() );
                        $( '#success-message' ).show();
                    }
                    else
                    {
                        alert( data.message );
                    }
                }
            } );
        }
        return false;
    } );
} );
</script>
@stop