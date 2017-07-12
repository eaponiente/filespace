@extends('layouts.base')
@section('title', 'Report Abuse')
@section('content')
<div class='content-registered'>
    <div class='page-title'>
        <span class='abuse-page-title'>
            Report Abuse
        </span>
    </div>

    <div class="report-abuse-hoder">

            <div class="abuse-info-holder">       
                @if( session('status') )
                <div id="abuse-message" class="{{ Session::get('status') }}" style="display:block;">{{ Session::get('message') }}</div>
                @endif
            </div>
            @foreach( $errors->all() as $m )
                <div>{{ $m }}</div>
            @endforeach

            <form method="POST" action="{!! route('abuse.store') !!}" enctype="multipart/form-data" id="abuse-form">
                {!! csrf_field() . method_field('POST') !!}
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" required="required" class="form-control" id="login_username"value="{{ old('name') }}" style="">
            </div>
            <div class="form-group">
                <label>Organization</label>
                <input type="text" name="organization" required="required" class="form-control" id="login_password" value="{{ old('organization') }}" style="">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required="required" class="form-control" id="login_password" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label >Links to report (one per line, max 50) </label>
                <textarea class="form-control" required="required" required="required" rows="10" name="links">{{ old('links') }}</textarea>
            </div>

            <div class="form-group">
                <label>Reason of report</label>
                <textarea class="form-control" required="required" rows="10" name="reason" style="">{{ old('reason') }}</textarea>
            </div>
            <div class="form-group">
                <label >Doc Upload( pdf or image only )( optional ) </label>
                <input type="file" name="file">
            </div>
            <div class="form-group align-center">
                <div class="checkbox toscb">
                    <label for="terms">
                    <input type="checkbox" name="accept" value="yes" id="terms">
                        I accept the abuse report terms and conditions
                    </label>
                </div>
            </div>
            
            <div class="form-group align-center">
                <div class="checkbox toscb">
                    <script src='https://www.google.com/recaptcha/api.js'></script>
                    <div class="g-recaptcha" data-sitekey="6Ldi9fcSAAAAAP8H3xOJmJR0z-bX5yOIWo-7iDrv"></div>
                </div>
            </div>
                

                

            <div class='align-center login-btn-holder'>
                <input type="button" id='login-btn' class="btn btn-default" value="Submit" />
            </div>
        </form>

        
    </div>



</div>
<script>
$(document).ready(function () {
    @if( Session::has('message') )
        //$(window).load(function() {
            //$("html, body").animate({ scrollTop: 0 }, 1000);
        //});
    @endif

    $('#login-btn').click(function (e) {
        e.preventDefault();
        if ($("#terms").is(':checked')) {
            //$("#abuse-message").removeClass('error-message').addClass('success-message').text('Your repoort is submited').show();  // checked
            $('#abuse-form').submit();
        }
        else
            $("#abuse-message").removeClass('success-message').addClass('error-message').text('Please accept Terms and conditions').show();  
    });
})

</script>
@stop