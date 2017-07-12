@extends('layouts.base')
@section('title', 'Change Password')
@section('content')
<div class='content-registered'>
<div class='page-title'>
    <span class='signup-page-title'>
        @if(Session::has('message'))
            {{ Session::get('message') }}
        @else
            {{ 'Change Password' }}
        @endif
    </span>
</div>
<div class='sign-up-form-holder'>
    <div class='sign-up-form'>
        <form class="form-horizontal" role="form" action="{{ route('profile_change_password') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group registration-form-group">
                <label  class="col-sm-12 control-label registration-label">Password</label>
                <div class="col-sm-8">
                    <input type="password" name="changepass[oldpassword]" class="form-control" placeholder="Password">
                </div>
                @if($errors->has('oldpassword'))
                   <div class="col-sm-8 sign-up-error" style="color:red;">
                         {!! $errors->first('oldpassword', '<span class="error">:message</span>') !!}
                   </div>
                @endif
                <div class="col-sm-4 sign-up-success" >
                    <img src="{!! url('img/icons/success.png') !!}">Successful
                </div>
            </div>
            <div class="form-group registration-form-group">
                <label  class="col-sm-12 control-label registration-label">New Password</label>
                <div class="col-sm-8">
                    <input type="password" name="changepass[password]" class="form-control" placeholder="Password">
                </div>
                @if($errors->has('password'))
                   <div class="col-sm-8 sign-up-error" style="color:red;">
                         {!! $errors->first('password', '<span class="error">:message</span>') !!}
                   </div>
                @endif
                <div class="col-sm-4 sign-up-success" >
                    <img src="{!! url('img/icons/success.png') !!}"> Succesfull
                </div>
            </div>
            <div class="form-group registration-form-group">
                <label  class="col-sm-12 control-label registration-label">Confirm New Password</label>
                <div class="col-sm-8">
                    <input type="password" name="changepass[password_confirmation]" class="form-control" placeholder="Password">
                </div>
                <div class="col-sm-4 sign-up-success" >
                    <img src="{!! url('img/icons/success.png') !!}"> Succesfull
                </div>
            </div>
           
            <div class="form-group email-submit-holder">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" id='registration-submit' class="btn btn-default" value="Submit" />
                </div>
            </div>
        </form>
        
    </div>
    
</div>
<div class='alert alert-success password-success'>
            Password changed successfully
        </div>
</div>

@stop