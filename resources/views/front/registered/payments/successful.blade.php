@extends('layouts.base')
@section('title', 'Transaction Successful')
@section('content')
    <div class='content'>
        <div class='page-title-success'>
        <span class='succ-transaction-page-title'>
            Successfull transaction
        </span>
        </div>
        <div class="change-center-text">
            Your status has been upgraded to premium till {!! date('d.m.Y', strtotime($premium_time)) !!}<br /><br />
            <form action="{!! url('/') !!}">
                {!! csrf_field() !!}
                <button type="submit" id='login-btn' class="btn btn-default">Continue</button>
            </form>
        </div>
    </div>
@stop
