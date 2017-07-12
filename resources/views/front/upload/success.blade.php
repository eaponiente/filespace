@extends('layouts.base')
@section('title', 'Successfully Uploaded ' . $successful_files . ' ' . str_plural('file', $successful_files))
@section('metadata')
    <script type="text/javascript" src="{{ url('js/ZeroClipboard.min.js') }}"></script>
@stop
@section('content')

<style>
.clippy {
    *cursor: hand;
    cursor: pointer;
}
td:first-child + td +td +td {
 word-break: break-all; !important;
}
</style>
<div class='content'>
    <div class='page-title-success'>
        <span class='success-page-title'>
            Successfully uploaded {{ count($files) }}
            {{ count($files) > 1 ? ' files' : ' file' }}
            ( {{ $total_filesize <= 0 ? 0 : $formatted_data }} )
        </span>
    </div>

    <div class="upload-success-upl-btn-holder">
        <a href="{{ url( '/' ) }}" class="btn btn-upload">
            Upload more files
        </a>
    </div>
    
    @if ( count( $files ) > 1 )
    <div class="upload-success-small-buttons-holder">
        <button class="btn btn-default" title="Click me to copy to clipboard." data-clipboard-target="bulk_download">
           Copy Download Links
        </button>
        <button class="btn btn-default" title="Click me to copy to clipboard." data-clipboard-target="bulk_delete">
           Copy Delete Links
        </button>
        <button class="btn btn-default" title="Click me to copy to clipboard." data-clipboard-target="bulk_html">
           Copy HTML Codes
        </button>
        <button class="btn btn-default" title="Click me to copy to clipboard." data-clipboard-target="bulk_forum">
           Copy Forum Codes
        </button>
    </div>
    @endif
    
    <?php
        $bulk_download = '';
        $bulk_delete = '';
        $bulk_html = '';
        $bulk_forum = '';
        $i = 0
    ?>
    
    @foreach ( $files as $file )
        <?php
            $file_find = App\Models\FileUploads::find($file->file_id);

            $sitecode = App\Models\WebsiteCodes::where('user id', 0)->first();
            $file->krypt_id = syferEncode( $file->file_id, $sitecode->code );

            $bulk_download .= url('/') . '/file/' . $file->krypt_id . '&#13;&#10;';
            $bulk_delete .=url('/') . '/file/delete/' . $file->krypt_id . '/' . $file->delete_hash . '&#13;&#10;';
            $bulk_html .= '&lt;a href=&quot;' . url('/') . '/file/' . $file->krypt_id . '&quot; target=&quot;_blank&quot; title=&quot;Download From FileSpace&quot;&gt;Download &quot;' . $file->name . '&quot;&lt;/a&gt;&#13;&#10;';
            $bulk_forum .= '[url=&quot;' . url('/') . '/file/' . $file->krypt_id . '&quot;]Download From FileSpace[/url]&#13;&#10;';
        ?>
        <div class="uploaded-file-holder">
            <div clasS="uploaded-file-name">
                {{ $file->name }} ({{ formatBytes( $file->size ) }}) {{ $file->success ? '' : '&#8212; FAILED' }}
            </div>
            <div class="uploaded-file-info-hoder">
                <table class="table table-bordered">
                    @if ( $file->success )
                        <tr>
                            <td class="col-red" width="168">Download Link:</td>
                            <td id="b_1_{{ $i }}" class="b_1">{{ url( '/file/' . $file->krypt_id ) }}</td>
                            <td width="100" class="align-center valign-middle"><span id="c_1" class="clippy" data-text="{{ url( 'file/' . $file->krypt_id  ) }}" data-clipboard-target="b_1_{{ $i }}">COPY</span></td>
                        </tr>
                        <tr>
                            <td class="col-red">Delete Link::</td>
                            <td id="b_2_{{ $i }}" class="b_2">{{ url( '/file/delete/' . $file->krypt_id . '/' . $file->delete_hash ) }}</td>
                            <td class="align-center valign-middle"><span id="c_2" class="clippy" data-text="{{ url( '/file/delete/' . $file->krypt_id .'/'. $file->delete_hash ) }}" data-clipboard-target="b_2_{{ $i }}">COPY</span></td>
                        </tr>
                        <tr>
                            <td class="col-red">HTML Code:</td>
                            <td id="b_3_{{ $i }}" style="word-break: break-all !important;" class="b_3">&lt;a href=&quot;{{ url( '/file/' . $file->krypt_id ) }}&quot; target=&quot;_blank&quot; title=&quot;Download From FileSpace&quot;&gt;Download &quot;{{ $file->name }}&quot;&lt;/a&gt;</td>
                            <td class="align-center valign-middle"><span id="c_3" class="clippy" data-text='<a href="{{ url('/') }}/file/{{ $file->krypt_id }}" target="_blank" title="Download From FileSpace">Download "{{ $file->name }}"</a>' data-clipboard-target="b_3_{{ $i }}">COPY</span></td>
                        </tr>
                        <tr>
                            <td class="col-red">Forum Code:</td>
                            <td id="b_4_{{ $i }}" style="word-break: break-all !important;" class="b_4">[url=&quot;{{ url( '/file/' .$file->krypt_id ) }}&quot;]Download From FileSpace[/url]</td>
                            <td class="align-center valign-middle"><span id="c_4" class="clippy" data-text='[url="{{ url('/') }}/file/{{ $file->krypt_id }}"]Download From FileSpace[/url]' data-clipboard-target="b_4_{{ $i }}">COPY</span></td>
                        </tr>
                    @else
                        <tr>
                            <td class="col-red">{{ $file->message }}</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
        <?php ++$i ?>
    @endforeach
    
    @if ( count( $files ) > 1 )
    <input id="bulk_download" type="hidden" value="{{ $bulk_download }}" />
    <input id="bulk_delete" type="hidden" value="{{ $bulk_delete }}" />
    <input id="bulk_html" type="hidden" value="{{ $bulk_html }}" />
    <input id="bulk_forum" type="hidden" value="{{ $bulk_forum }}" />
    
    <div class="upload-success-small-buttons-holder">
        <button class="btn btn-default" title="Click me to copy to clipboard." data-clipboard-target="bulk_download">
           Copy Download Links
        </button>
        <button class="btn btn-default" title="Click me to copy to clipboard." data-clipboard-target="bulk_delete">
           Copy Delete Links
        </button>
        <button class="btn btn-default" title="Click me to copy to clipboard." data-clipboard-target="bulk_html">
           Copy HTML Codes
        </button>
        <button class="btn btn-default" title="Click me to copy to clipboard." data-clipboard-target="bulk_forum">
           Copy Forum Codes
        </button>
    </div>
    @endif

</div>
<style>
.copied
{
    position: absolute;
    margin-left: 10px;
    background: #e2f5e9;
    margin-top: -7px;
    padding: 5px;
}
.copied-x
{
    position: absolute;
    background: #e2f5e9;
    margin-top: 40px;
    padding: 5px;
}
</style>
<script>
$(function() {

    ZeroClipboard.config( {
        debug: true
    } );

    /*var els = [ 'c_1', 'c_2', 'c_3', 'c_4' ];
    for ( var i in els )
    {
        new ZeroClipboard( document.getElementById( els[ i ] ), {
            moviePath: '../assets/swf/ZeroClipboard.swf'
        } );
    }*/


    var client = new ZeroClipboard( $( '.clippy' ), {
        moviePath: '{!! url('js/plugins/swf/ZeroClipboard.swf') !!}'
    } );
    client.on( "load", function( client ) {
        client.on( "complete", function( client, args ) {
            var self = $( this ), id = 'lol_'+ (+new Date());
            $( '<span class="copied" id="'+ id +'">Copied to clipboard!</span>' ).insertAfter( self );
            $( '#'+ id ).fadeOut( 2000, function() {
                $( '#'+ id ).remove();
            } );
        } );
    } );
    
    // dustin added copy to buttons for bulk copies
    $('.btn-default').each(function() {
        var obj = $(this);
        var client = new ZeroClipboard( $(this), {
            moviePath: '{!! url('js/plugins/swf/ZeroClipboard.swf') !!}'
        });
        
        client.on( "load", function(client) {
            client.on( "complete", function(client, args) {
                var self = $( this ), id = 'rofl_'+ (+new Date());
                $( '<span class="copied-x" id="'+ id +'" style="margin-left: -'+ ( ( obj.width() / 2 ) + 90 ) +'px">Links copied to clipboard!</span>' ).insertAfter( self );
                $( '#'+ id ).fadeOut( 2000, function() {
                    $( '#'+ id ).remove();
                } );
            });
        });
    });
});
</script>
@stop