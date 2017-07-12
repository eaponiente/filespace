@extends('layouts.base')
@section('title', 'Site Code Checker')
@section('content')
<style type="text/css">.alert{display:block;}</style>
<div class='content-registered'>
    <div class='page-title'>
        <span class='code-checker-page-title'>
            Site Code Cheker for code: <span clasS="red-txt">{{ $code->code }}</span>
        </span>
    </div><br>
    @if( Session::has('message'))
        {{ Session::get('message') }}
    @endif    

    <form method="POST" action="{!! route('sitecodes_checker', [$code->code]) !!}">
    {!! csrf_field() !!}
    <div class="code-checker-textarea-holder">
        <input type="hidden" name="sitecodes[code]" value="{{ $code }}">
        <textarea name="sitecodes[urls]" rows="13">Insert up to 100 urs</textarea>
    </div>
    <div class="code-checker-btn-holder">
        <button type="submit" class="btn btn-default">Check</button>
    </div>
    </form>
</div>
@stop