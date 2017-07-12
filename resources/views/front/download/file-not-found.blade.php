@extends('layouts.base')
@section('title', 'File not Found')
@section('content')
<div class='content'>
    <div class='page-title-error'>
        <span class='page-title-not-found'>
            File not found
        </span>
    </div>
    
    <div class="file-error-body">
        <div clasS="file-error-main-text">
            The file you were looking for could not be found, sorry for any inconvenience.
        </div>
        <div class="no-file-image">
            <img src="{{ url('img/file-404.png')}}" />
        </div>
        <div class="file-error-list">
            <div class="file-error-list-title">
                Possible causes of this error could be:
            </div>
            <div class="file-error-reasons">
                <span>•</span> The file expired<br />
                <span>•</span> The file was deleted by its owner<br />
                <span>•</span> The file was deleted by administration because it didn't comply with our “Terms of Use"
            </div>
           
        </div>
    </div>


   
</div>

@stop