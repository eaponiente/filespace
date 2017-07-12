@extends('layouts.base')
@section('title', 'Site Code Check Results')
@section('content')
<div class='content-registered'>
    <div class='page-title'>
        <span class='code-checker-page-title'>
            Site Code results for code: <span clasS="red-txt">{{ $code->code }}</span>
        </span>
    </div>
    
    <div class="code-checker-top">
        <span class="code-span">Verified links: <span class="bold">{{ $verified_links }}</span></span>        
        <span class="code-span">Site code match:  <span class="bold">{{ $sitecodes_matched }}</span></span>        
        <span class="code-span">Site code mismatch: <span class="bold">{{ $mismatched }}</span></span>                
        <span class="code-span">Dead links: <span class="bold">{{ $dead_links }}</span></span>        
    </div>
    
    <div class="code-checker-table-holder">
        <table class="code-checker-table">
            @foreach( $new_uri as $uri )
                @if( $uri['verified'] )
                    <tr>
                        <td class="blue-bg">{{ $uri['uri'] }}</td>
                        <td><img src="{!! url('img/icons/success.png') !!}"></td>
                    </tr>
                @else
                    <tr>
                        <td class="blue-bg">{{ $uri['uri'] }}</td>
                        <td><img src="{!! url('img/icons/error.png') !!}"></td>
                    </tr>
                @endif
            @endforeach
        </table>
    </div>
    <div class="code-checker-btn-holder">
        <button class="btn btn-default">Check More Files</button>
    </div>
</div>
@stop