@extends('layouts.banned')
@section('title', 'Banned')
@section('content')
<div class="banned-holder">
    <div><img src="{{ url('img/banned-logo.png') }}"></div>
    <div class="baned-smile"><img src="{{ url('img/icons/sad-face.png') }}"></div>
    <div clasS="banned-text">
        {!! $message !!}
    </div>
</div>
@stop