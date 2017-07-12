@extends('layouts.base')
@section('title', 'Edit File ' . $file->title)
@section('content')
<style type="text/css">
.file-edit-input-pass {
    width: auto;
}
</style>
<div class='content-registered'>
    <div class='page-title'>
        <span class='file-edit-page-title'>
            {{ session('message') ? session('message') : 'File Editor' }}
        </span>
    </div>

    <form action="{{ route('user_file_edit', [$file->id] ) }}" method="POST" >
        {!! csrf_field() !!}
        <div class="file-edit-body">
        <table clasS="file-edit-table">
            <tr>
                <td class="file-edit-label">File name:</td>
                <td>
                    <div class="file-edit-input-pass">
                        <input type="text" class="form-control" name="file[title]" placeholder="File name" value="{{ $file->title }}" />
                    </div>
                </td>
            </tr>
            <tr>
                <td class="file-edit-label">Size:</td>
                <td><span class="filename-info">{{ formatBytes($file->filesize_bytes, 2) }}</span></td>
            </tr>
            <tr>
                <td class="file-edit-label">Uploaded on:</td>
                <td><span class="filename-info">{{ $file->datetime_uploaded }}</span></td>
            </tr>
            <tr>
                <td class="file-edit-label">Last downloaded on:</td>
                <td><span class="filename-info">{{ $file->last_download }}</span></td>
            </tr>
            <tr>
                <td class="file-edit-label">Public:</td>
                <td><span class="filename-info"><input type="checkbox" name="file[is_public]" {{ $file->is_public == 1 ? 'checked="checked"' : '' }}/></span></td>
            </tr>
            <tr>
                <td class="file-edit-label">Premium Only:</td>
                <td><span class="filename-info"><input type="checkbox" name="file[is_premium_only]" {{ $file->is_premium_only == 1 ? 'checked="checked"' : '' }}/></span></td>
            </tr>
            <tr>
                <td class="file-edit-label">Password:</td>
                <td>
                    <div class="pull-left file-edit-input-pass" style="width: 70px;">
                         <input type="text" class="form-control" id="file_password" maxlength="6" name="file[password]" value="{{ $file->password }}"  />
                    </div>
                    <div class="pull-left file-edit-pass-error hide" id="file_password_error">
                        Password must be between 4 and 6 chars
                    </div>
                    <div class="sign-up-success hide" id="file_password_check">&nbsp;&nbsp;<img src="{!! url('img/icons/success.png') !!}"> Success</div>   
                </td>
            </tr>
            </table>
            <div class="row">
                <div class="col-md-offset-4 col-md-6" style="padding-left: 40px; padding-top: 20px;">
                    <input type="submit" value="Update" class="btn btn-default disabled-dark" id="update_btn">
                </div>
            </div>
        </div>
    </form>
</div>
<style>
.disabled-dark
{
    /* IE 8 */
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";

  /* IE 5-7 */
  filter: alpha(opacity=50);

  /* Netscape */
  -moz-opacity: 0.5;

  /* Safari 1.x */
  -khtml-opacity: 0.5;

  /* Good browsers */
  opacity: 0.5;
}
</style>
<script>
$( function() {
    $( 'body' ).on( 'click', '.disabled-dark', function( evt ) {
        evt.preventDefault();
        return false;
    } );
    
    // $( '#file_password' ).on( 'keyup', function ( evt ) {
        // if ( this.value.length < 4 || this.value.length > 6 )
        // {
            // $( '#file_password_error' ).removeClass( 'hide' ).addClass( 'show' );
        // }
        // else
        // {
            // $( '#file_password_error' ).removeClass( 'show' ).addClass( 'hide' );
        // }
    // } );
    
    var b = $( '#file_password_error' ).html();
    $( '#file_password' ).on( 'keyup keypress blur', function() {
        var fp = $( this );
        if ( $.trim( fp.val() ).length )
        {
            if ( fp.val().length < 4 || fp.val().length > 6 )
            {
                $( '#file_password_error' ).removeClass( 'hide' ).html( b ).addClass( 'show' );
                $( '#file_password_check' ).removeClass( 'show' ).addClass( 'hide' );
                $( '#update_btn' ).addClass( 'disabled-dark' );
            }
            else
            {
                $( '#file_password_error' ).removeClass( 'show' ).addClass( 'hide' );
                $( '#file_password_check' ).removeClass( 'hide' ).addClass( 'show' );
                $( '#update_btn' ).removeClass( 'disabled-dark' );
            }
        }
    } );
    $( '#file-edit' ).on( 'submit', function() {
        var fp = $( '#file_password' );
        
        if ( $.trim( fp.val() ).length )
        {
            if ( fp.val().length < 4 || fp.val().length > 6 )
            {
                $( '#file_password_error' ).removeClass( 'hide' ).html( b ).addClass( 'show' );
                return false;
            }
        }
        return true;
    } );
    
    var fc = $( '#files_container' ), mvdir = $( '#move_folder_id' );
    $( '#move_folder_form' ).on( 'submit', function ( evt ) {
        
        if ( mvdir.val() != '' )
        {
            var a = [];
            a.push( <?php echo $file->id; ?> );
            fc.val( a.join( ',' ) );
            return true;
        }
        
        return false;
    } );
} );
</script>
@stop
