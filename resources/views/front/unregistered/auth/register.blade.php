@extends('layouts.base')
@section('title', 'Sign Up')
@section('metadata')
<link rel="stylesheet" type="text/css" href="{{ url('css/main.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('css/datepicker.css') }}">
<script type="text/javascript" src="{{ url('js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ url('js/parsley.js') }}"></script>
@stop
@section('content')
<div class="content">
  <div class="page-title">
    <span class="signup-page-title">
      User Registration
    </span>
  </div>
      <div class="sign-up-form-holder">
        <div class="sign-up-form">
          @foreach ($errors->all() as $message)
          {{ $message }}
          @endforeach
          <form class="form-horizontal"
          method="post"
          action="{{ url('signup/' . $affiliate_ash) }}"
          parsley-validate=""
          parsley-show-errors="true"
          class="form-horizontal"
          id="join_form"
          parsley-trigger="keyup" >

          {!! csrf_field() !!}
          
          <div class="form-group registration-form-group">
            <label class="col-sm-12 control-label registration-label" for="join_email">Email <span class="required">*</span></label>
            <div class="col-sm-8">
              <input parsley-type="email"
              type="text"
              maxlength="200"
              id="join_email"
              name="signup[email]"
              value="{{ old('email') }}"
              parsley-required="true"
              data-parsley-validate
              parsley-type="email"
              parsley-type-email-message="The email you entered is not valid"
              parsley-remote-method="GET"
              parsley-remote="{{ route('check_email') }}"
              parsley-remote-message="E-mail address is already taken."
              parsley-error-container="#email-parsley"
              class="form-control"
              data-complete="" >

            </div>
            <div class="col-sm-4 sign-up-success" id="email-parsley" style="display:block"></div>
          </div>

          <div class="form-group registration-form-group">
            <label class="col-sm-12 control-label registration-label" for="join_username">Username <span class="required">*</span></label>
            <div class="col-sm-8">
              <input type="text"
              maxlength="12"
              id="join_username"
              name="signup[username]"
              value="{{ old('username') }}"
              parsley-required="true"
              data-parsley-validate
              parsley-remote-method="GET"
              parsley-rangelength="[6,12]"
              parsley-rangelength-message="Username must be between 6 and 12 chars"
              parsley-remote="{{ route('check_username') }}"
              parsley-remote-message="Username is already taken."
              parsley-error-container="#username-parsley"
              parsley-validation-minlength="1"
              class="form-control"
              data-complete="" >
            </div>
            <div class="col-sm-4 sign-up-success" id="username-parsley" style="display:block"></div>
          </div>

          <div class="form-group registration-form-group">
            <label class="col-sm-12 control-label registration-label" for="join_password">Password <span class="required">*</span></label>
            <div class="col-sm-8">

              <input type="password"
              maxlength="12"
              id="join_password"
              name="signup[password]"
              parsley-validation-minlength="4"
              parsley-rangelength="[6,12]"
              parsley-rangelength-message="Password must be between 6 and 12 chars"
              parsley-required="true"
              parsley-error-container="#password-parsley"
              class="form-control"
              data-complete="" >

            </div>
            <div class="col-sm-4 sign-up-success" id="password-parsley" style="display:block"></div>
          </div>

          <div class="form-group registration-form-group">
            <label class="col-sm-12 control-label registration-label" for="join_password_confirm">Confirm Password <span class="required">*</span></label>
            <div class="col-sm-8">
              <input type="password"
              maxlength="12"
              id="join_password_confirm"
              parsley-validation-minlength="4"
              name="signup[password_confirmation]"
              parsley-required="true"
              parsley-rangelength="[6,12]"
              parsley-rangelength-message="Confirm Password must be between 6 and 12 chars"
              parsley-error-container="#cpass-parsley"
              class="form-control"
              data-complete="" >
            </div>
            <div class="col-sm-4 sign-up-success" id="cpass-parsley" style="display:block"></div>
          </div>

          <div class="form-group">
            <div class="col-sm-8">
              <div class="checkbox">
                <label style="font-size: 12px">
                  I agree with the Terms &amp; Conditions
                  
                  <input type="checkbox"
                  id="join_accept"
                  name="signup[accept]"
                  value="yes"
                  style="float: left; margin-right: 10px;"
                  parsley-required="true"
                  parsley-error-container="#accept-parsley"
                  parsley-error-message="You must agree to the T&C"
                  data-complete="" >
                </label>
                
              </div>
            </div>
            <div class="col-sm-4" id="accept-parsley">

            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <input type="submit" value="Join" class="btn btn-default disabled-dark" id="join_submit_btn" />
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-10">
              Already Registered? <a href="{{ route('user_login') }}" style="color:black;text-decoration:underline;">CLICK HERE</a>
            </div>
          </div>
        </form>
        
      </div>
      
      
    </div>
</div>

<script>
$( function() {
  var jp = $( '#join_password' ), jpc = $( '#join_password_confirm' );
  $( 'body' ).on( 'click', '.disabled-dark', function( evt ) {
    //evt.preventDefault();
      if ( ( jpc.val().length <= 12 && jpc.val().length >= 6 ) )
    {
      if ( jp.val() == jpc.val() )
      {
        $( jpc.attr( 'parsley-error-container' ) ).html( '<img src="{{ url('img/icons/success.png') }}"> Success' );
        $( jp.attr( 'parsley-error-container' ) ).html( '<img src="{{ url('img/icons/success.png') }}"> Success' );
        return true;
      }
      else
      {
        $( jpc.attr( 'parsley-error-container' ) ).html( '<ul class="parsley-error-list"><li style="display: list-item;">Passwords did not match.</li></ul>' );
        $( jp.attr( 'parsley-error-container' ) ).html( '<ul class="parsley-error-list"><li style="display: list-item;">Passwords did not match.</li></ul>' );
      }
    }
    else
    {
      $( jpc.attr( 'parsley-error-container' ) ).html( '<ul class="parsley-error-list"><li style="display: list-item;">Passwords must be between 6 and 12 chars.</li></ul>' );
    }
    
    jp_validate();



    return false;
  } );
  
  
  
  function jp_validate()
  {
    if ( ( jp.val().length <= 12 && jp.val().length >= 6 ) )
    {
      if ( jp.val() == jpc.val() )
      {
        $( jpc.attr( 'parsley-error-container' ) ).html( '<img src="{{ url('img/icons/success.png') }}"> Success' );
        $( jp.attr( 'parsley-error-container' ) ).html( '<img src="{{ url('img/icons/success.png') }}"> Success' );
      }
      else if ( jpc.val().length > 0 && jp.val() != jpc.val() )
      {
        $( jp.attr( 'parsley-error-container' ) ).html( '<ul class="parsley-error-list"><li style="display: list-item;">Passwords did not match.</li></ul>' );
      }
      else
      {
        $( jp.attr( 'parsley-error-container' ) ).html( '' );
      }
    }
    else
    {
      $( jp.attr( 'parsley-error-container' ) ).html( '<ul class="parsley-error-list"><li style="display: list-item;">Passwords must be between 6 and 12 chars.</li></ul>' );
    }
  }


  $( '#join_form' ).parsley( 'addListener', {
    onFieldError: function ( elem ) {
      var e = $( elem );
      var pec = $( e.attr( 'parsley-error-container' ) );
      
      pec.html( '' );
      return true;
    },
    
    onFieldSuccess: function ( elem, constraints, ParsleyField ) {
      var e = $( elem );
      var pec = $( e.attr( 'parsley-error-container' ) );
      
      if ( /parsley-success/.test( e.context.className ) )
      {
        if ( /password/.test( e.context.id ) )
        {
          if ( jpc.val() == jp.val() )
          {
            pec.html( '<img src="{{ url('img/icons/success.png') }}"> Success' );
          }
        }
        else
        {
          pec.html( '<img src="{{ url('img/icons/success.png') }}"> Success' );
        }
        
        return true;
      }
      
      if ( e.context.id == 'join_email' && !constraints.remote.valid && constraints.required.valid && constraints.type.valid )
      {
        pec.html( '<img src="{{ url('img/icons/success.png') }}"> Success' );
        return true;
      }
      
      return true;
    }
  } );
  
  $( '#join_form' ).on( 'blur keyup click', '[data-complete]', function() {
    var success = 0;  
    var a = $( $( '#join_username' ).attr( 'parsley-error-container' ) );
    
    if ( /Success/.test( a.text() ) )
    {
      success++;
    }
    
    var b = $( $( '#join_email' ).attr( 'parsley-error-container' ) );
    
    if ( /Success/.test( b.text() ) )
    {
      success++;
    }
    
    var c = $( '#join_accept' );
    if ( c.prop( 'checked' ) )
    {
      success++;
    }
    
    if ( success == 3 )
    {
      
    }
    else
    {
      $( '#join_submit_btn' ).addClass( 'disabled-dark' );
    }
  } );
} );
</script>
@stop 