@extends('layouts.base')
@section('title', 'Site Codes')
@section('content')
<style type="text/css">
.empty_tb {
    border-left: 1px solid #c8c8c8 !important;
    border-right: 1px solid #c8c8c8 !important;
}
</style>
<div class='content-registered'>
    <div class='page-title'>
        <span class='code-checker-page-title'>
            Site Codes
        </span>
    </div>
    
    <div class="site-codes-table-holder">
        <table class="site-codes-table">
            @if( $codes->isEmpty() )
            <tr>
                <td colspan="2" class="empty_tb">You have no sitecodes</td>
            </tr>
            @else

                @foreach($codes as $code)
                <tr>
                    <td>{{ $code->code }}</td>
                    <td class="checker-link"><a href="{{ route('sitecodes_checker', [$code->code] ) }}">Checker</a></td>
                </tr>
                @endforeach
            @endif
        </table>
    </div>
</div>
@stop