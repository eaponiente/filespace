@extends('layouts.base')
@section('title', 'Folder Editor')
@section('content')
<style type="text/css">
.file-edit-input-pass {
    width: 100%;
}
</style>
<div class="content">
	<div class="page-title">
        <span class="folder-edit-page-title">
            {!! session('message') ?: 'Folder Editor' !!}
        </span>
    </div>
	
	<br />
	
	<div class="file-edit-body">
		
		<form method="POST" id="folder_form" class="form-horizontal" action="{!! isset($edit) ? route('folders.update', [$edit->id]) : route('folders.store') !!}">
		{!! csrf_field() . ( isset($edit) ? method_field('PUT') : method_field('POST') ) !!}
        <table class="file-edit-table">
            <tbody>
				<tr>
					<td class="file-edit-label"><label for="folder_folder_name">Folder Name:</label></td>
					<td>
						<div class="pull-left file-edit-input-pass" style="width: 250px;">
							<input type="text" id="folder_folder_name" class="form-control" name="folder_name" value="{!! isset($edit) ? $edit->folder_name : old('name') !!}" />
						</div>
						<div class="pull-left file-edit-pass-error hide" id="file_password_error">
	                        Password must be between 4 and 6 chars
	                    </div>
	                    <div class="sign-up-success hide" id="file_password_check">&nbsp;&nbsp;<img src="{!! url('/img/icons/success.png') !!}"> Success</div>   
						
					</td>
				</tr>
				@if (count($errors) > 0)
				<tr>
					<td colspan="2">
						
					    <div class="alert alert-danger">
					        <ul class="parsley-error-list">
					            @foreach ($errors->all() as $error)
					                <li style="display: block">{{ $error }}</li>
					            @endforeach
					        </ul>
					    </div>
							
					</td>
				</tr>
				@endif
				@if(isset($edit))
				<tr>
	                <td class="file-edit-label">Total Files:</td>
	                <td><span class="filename-info">{{ $edit->fileuploads()->count() }}</span></td>
	            </tr>
	            <tr>
	                <td class="file-edit-label">Created on:</td>
	                <td><span class="filename-info">{{ $edit->date_created }}</span></td>
	            </tr>
				@endif
				

				<tr>
					<td class="file-edit-label">&nbsp;</td>
					<td>
						<input type="submit" class="btn btn-default" value="Create Folder" />
					</td>
				</tr>
			</tbody>
		</table>
		
		</form>
		
    </div>
</div>

<script>
var delay = ( function(){
	var timer = 0;
	return function( callback, ms ){
		clearTimeout( timer );
		timer = setTimeout( callback, ms );
	};
} )();
function folder_password_length()
{
	var e = $( '#folder_password' );
	return !e.val().length || ( e.val().length >= 4 && e.val().length <= 6 );
}

function folder_name_error( text )
{
	return '<ul class="parsley-error-list"><li style="display: list-item;">'+ text +'</li></ul>';
}
var fne = false;
$( function() {

	var folder_name = $( '#folder_folder_name' ), ec = $( '#folder_name_ec' );
	
	folder_name.on( 'change keyup', function ( evt ) {
		delay( function() {
			$.ajax( {
				url: '{{ route( 'check_folder_name' ) }}',
				type: 'POST',
				data: {
					folder_name: folder_name.val(),
					_token: '{!! csrf_token() !!}'
				},
				success: function( data, ts, xhr ) {
					if ( data.success )
					{
						$('#file_password_error').addClass('hide');
						$('#file_password_check').removeClass('hide').css('display', 'block');

						fne = true;
					}
					else
					{
						$('#file_password_check').addClass('hide');
						$('#file_password_error').removeClass('hide').html( 'Folder name already exists.' );
						fne = false;
					}
				}
			} );
		}, 600 );
	} );
	
	$( '#folder_form' ).on( 'submit', function() {
		if ( !$.trim( folder_name.val() ).length )
		{
			ec.html( folder_name_error( 'Folder name cannot be empty.' ) );
			return false;
		}
		else
		{
			if ( fne )
			{
				return true;
			}
		}
		
		return false;
	} );
} );
</script>
@stop