@extends('layouts.base')
@section('title', 'Validate Voucher')
@section('content')
<div class='content'>
    <div class='page-title'>
        <span class='login-page-title'>
            Vouchers
        </span>
    </div>
      
    <div class='login-form'>
        <form role="form" action="" method="post" id="login-forms">
         {{ csrf_field() }}
            <div class="form-group">
                <label for="exampleInputEmail1">Voucher</label>
                <input type="text" name="data[voucher]" class="form-control" id="login_username" placeholder="Voucher" maxlength="12">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">PIN</label>
                <input type="password" name="data[pin]" class="form-control" id="login_password" placeholder="PIN" maxlength="12">
            </div>
            <div class='align-center login-btn-holder'>
                <input type="submit" id='login-btn' class="btn btn-default" value="Submit" />
            </div>
        </form>
    </div>
</div>


@stop