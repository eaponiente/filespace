@extends('layouts.base')
@section('title', 'File Manager')
@section('metadata')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css">
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<script type="text/javascript" src="{{ url('js/ZeroClipboard.min.js') }}"></script>

@stop
@section('content')
<style>
.dataTable thead th{
    background: none repeat scroll 0% 0% #EFF1F8 !important;
    border: 1px solid #CACEDD !important;
    font-size: 13px !important;
    padding: 9px !important;
}
.jkl,
.clippy
{
    *cursor: hand;
    cursor: pointer;
}
td:first-child + td {
 word-break: break-all; !important;
}
td:last-child a{
    margin: 12px 7px 0 !important;
}
.delete_btn {
    color: #fff;
    background: #414350;
    border: 2px solid #2b2e3c;
    font-size: 14px;
    padding: 6px 15px;
    font-family: 'segoe_uiregular';
}
.pagination li.active a{ background: #E1472C; border-color: #E1472C }
</style>

<div class="content-registered">
    @if ( session( '_multi_select_action' ) )
        {!! session( '_multi_select_action' ) !!}
    @endif
    <div style="height: 15px;"></div>
    <div class="page-title">
        <span class="file-edit-page-title">
            File Manager for Folder: {{ is_null( $folder ) ? ' Root' : $folder->folder_name }}
        </span>
    </div>
    <div class="folders-body">
        
        <div class="folder-table-holder">
            <form method="POST" action="{!! route('files_multi_select_action') !!}" id="multi_action_form_file">
            {!! csrf_field() !!}
            <input type="hidden" name="file[folder_id]" value="{{ isset($folder_id) && $folder_id != '' ? $folder_id : 0 }}">
            <input type="hidden" name="file[multi_type]" value="file" />
            <input type="hidden" name="file[action]" id="file_action" />
            
            <table class="table-folders" id="sample_1" data-source="{{ route('user_files_listings') . $querystring }}">
                <thead>
                    <tr>
                        <th width="120" class="text-center">
                            <a href="#" class="select-all">Select All</a>
                        </th>
                        <th class="text-center" width="15%">
                            <a href="#" data-sort='title'><i class="glyphicon glyphicon-chevron-down"></i></a> 
                            File Name
                        </th>
                        <th width="100" class="text-center">
                            <a href="#" data-sort='filesize_bytes'><i class="glyphicon glyphicon-chevron-down"></i></a> 
                            Size
                        </th>
                        <th width="140" class="text-center">
                            <a href="#" data-sort='datetime_uploaded'><i class="glyphicon glyphicon-chevron-down"></i></a> 
                            Uploaded On
                        </th>
                        <th width="150" class="text-center">
                            <a href="#" data-sort='last_visited'><i class="glyphicon glyphicon-chevron-down"></i></a> 
                            Last Download
                        </th>
                        <th width="80" class="text-center">Public</th>
                        <th width="120" class="text-center">Premium Only</th>
                        <th width="80" class="text-center">Password</th>
                        <th width="195" class="text-center" >Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    
                </tbody>
            </table>
            
            </form>
            
        </div>
        Actions for selected files:
        <div class="folder-actions-links" id="multi_action_links">
            
            <a href="#" data-toggle="modal" data-target="#myModal2" id="mass_show_links">Show Links</a>
            <a href="#" data-toggle="modal" data-target="#modalMultiRefLink" id="mass_show_reflinks">Show Reference Links</a>
            <a href="#" id="mass_delete">Delete</a>
            <a href="#" data-action="make_public">Make Public</a>
            <a href="#" data-action="make_private">Make Private</a>
            <a href="#" data-action="premium_only">Premium Only: YES</a>
            <a href="#" data-action="not_premium_only">Premium Only: NO</a>
            <a href="#" data-toggle="modal" data-target="#setPasswordModal">Set Password</a>
            <a href="#" data-action="unset_password">Unset Password</a>
        </div>

        <div class="folder-move-holder">
            Or move to folder 
            <form action="{!! route('move_to_folder') !!}" method="POST" id="move_folder_form" class="form-horizontal" style="display: inline;">
                {!! csrf_field() !!}
                <input type="hidden" name="files" value="" id="files_container" />

                <select name="move_to_folder" id="move_folder_id">
                    <option value="" selected="selected">Select Folder...</option>
                    <option value="0">Root</option>
                    @foreach( $folders as $folder )
                        @if( $folder->id != $folder_id )
                            <option value="{{ $folder->id }}">{{ $folder->folder_name }}</option>
                        @endif
                    @endforeach
                </select>
                
                <a href="javascript:;" onclick="$( '#move_folder_form' ).submit()">Move</a>
            </form>
        </div>
    </div>

</div>
<!-- Modal Share-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="uploaded-file-popup-holder">
                    <div class="uploaded-file-name">
                        VeryNiceImage.jpeg (24.42 Mb)
                    </div>
                    <div class="uploaded-file-info-hoder">
                        <table class="table table-bordered">
                            <tr>
                                <td class="col-red" width="168">Download Link:</td>
                                <td id="link_download">http://domain.com/files/23423dsvcsdiesfesfsec</td>
                                <td class="align-center valign-middle"><span id="s_1" class="clippy" data-text="" data-clipboard-target="link_download">COPY</span></td>
                            </tr>
                            <tr>
                                <td class="col-red">Delete Link::</td>
                                <td id="link_delete">http://domain.com/file/23423dsvcsdiesfesfsec</td>
                                <td width="100" class="align-center valign-middle"><span id="s_2" class="clippy" data-text="" data-clipboard-target="link_delete">COPY</span></td>
                            </tr>
                            <tr>
                                <td class="col-red">HTML Code:</td>
                                <td id="link_html">
                                    &lt;a href=&quot;http://optimalesoft.com/file/download/60f0e707cWEOGJ1Zz3IeQuq2h&quot; target=&quot;_blank&quot; title=&quot;Download From File Upload Script&quot;&gt;download filehosting.rp 
                                </td>
                                <td class="align-center valign-middle"><span id="s_3" class="clippy" data-text="" data-clipboard-target="link_html">COPY</span></td>
                            </tr>
                            <tr>
                                <td class="col-red">Forum Code:</td>
                                <td id="link_forum">
                                    &lt;a href=&quot;http://optimalesoft.com/file/download/aYwoV1QWEOGJ1Zz3IeQuq2h&quot; target=&quot;_blank&quot; title=&quot;Download From File Upload Script&quot;&gt;download filehosting.rp 
                                </td>
                                <td class="align-center valign-middle"><span id="s_4" class="clippy" data-text="" data-clipboard-target="link_forum">COPY</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Multiple Selection Show links-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
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
            <div class="modal-body" id="holder">
                
            </div>
            <div class="upload-success-small-buttons-holder" style="margin-bottom: 15px;">
                <button class="btn btn-default btn-default-bottom" title="Click me to copy to clipboard." data-clipboard-target="bulk_download">
                   Copy Download Links
                </button>
                <button class="btn btn-default btn-default-bottom" title="Click me to copy to clipboard." data-clipboard-target="bulk_delete">
                   Copy Delete Links
                </button>
                <button class="btn btn-default btn-default-bottom" title="Click me to copy to clipboard." data-clipboard-target="bulk_html">
                   Copy HTML Codes
                </button>
                <button class="btn btn-default btn-default-bottom" title="Click me to copy to clipboard." data-clipboard-target="bulk_forum">
                   Copy Forum Codes
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal delete-->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog small-modal">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-delete-title">
                    Delete <span id="num_delete_files"></span> file(s)?
                </div>

                <div class="modal-delete-body">
                    <button href="javascript:;" onclick="mass_delete()" clasS="btn delete_btn" id="delete_confirm_btn">Confirm</button>
                    <button clasS="btn btn-cancel-delete" data-dismiss="modal" onclick="$( '.all' ).prop( 'checked', false )">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Set Password-->
<div class="modal fade" id="setPasswordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog small-modal">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-delete-title">
                    Set Password
                </div>

                <div class="modal-delete-body">
                    <form id="setpassword_form">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="data[password]" id="pass" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="data[confirmpassword]" id="cpass" class="form-control">
                        </div>
                        <div class="error hidden">Pass</div>

                        <input type="button" class="btn btn-primary" id="set_password_btn" disabled value="Submit">
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Set SiteCode Links -->
<div class="modal fade" id="modalRefLink" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog small-modal">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-delete-title">
                    Set Referral Link
                </div>

                <div class="modal-delete-body">
                    <form id="setpassword_forms">
                        <div class="form-group">
                            <input type="text" name="data[sitecode]" id="sitecode" class="form-control">
                            <input type="hidden" id="fileid">
                        </div>
                        <div class="sitecode_error hidden">Pass</div>

                        <input type="button" class="btn btn-primary" style="background: #E1472C; border-color: #E1472C" id="set_reference_btn" value="Submit">
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal View Reference Links -->
<div class="modal fade" id="referenceLinks" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="uploaded-file-popup-holder">
                    <div class="uploaded-file-name">
                        VeryNiceImage.jpeg (24.42 Mb)
                    </div>
                    <div class="uploaded-file-info-hoder">
                        <table class="table table-bordered">
                            <tr>
                                <td class="col-red" width="168">Download Link:</td>
                                <td id="ref_download">http://domain.com/file/23423dsvcsdiesfesfsec</td>
                                <td class="align-center valign-middle"><span id="e_1" class="clippy" data-text="" data-clipboard-target="link_download">COPY</span></td>
                            </tr>
                            <tr>
                                <td class="col-red">Delete Link:</td>
                                <td id="ref_delete">http://domain.com/file/23423dsvcsdiesfesfsec</td>
                                <td width="100" class="align-center valign-middle"><span id="e_2" class="clippy" data-text="" data-clipboard-target="link_delete">COPY</span></td>
                            </tr>
                            <tr>
                                <td class="col-red">HTML Code:</td>
                                <td id="ref_html">
                                    &lt;a href=&quot;http://optimalesoft.com/file/download/60f0e707cWEOGJ1Zz3IeQuq2h&quot; target=&quot;_blank&quot; title=&quot;Download From File Upload Script&quot;&gt;download filehosting.rp 
                                </td>
                                <td class="align-center valign-middle"><span id="e_3" class="clippy" data-text="" data-clipboard-target="link_html">COPY</span></td>
                            </tr>
                            <tr>
                                <td class="col-red">Forum Code:</td>
                                <td id="ref_forum">
                                    &lt;a href=&quot;http://optimalesoft.com/file/download/aYwoV1QWEOGJ1Zz3IeQuq2h&quot; target=&quot;_blank&quot; title=&quot;Download From File Upload Script&quot;&gt;download filehosting.rp 
                                </td>
                                <td class="align-center valign-middle"><span id="e_4" class="clippy" data-text="" data-clipboard-target="link_forum">COPY</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Multiple Selection Show Ref Links-->
<div class="modal fade" id="multiRefLink" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
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
            <div class="modal-body" id="holders">
                
            </div>
            <div class="upload-success-small-buttons-holder" style="margin-bottom: 15px;">
                <button class="btn btn-default btn-default-bottom" title="Click me to copy to clipboard." data-clipboard-target="bulk_download">
                   Copy Download Links
                </button>
                <button class="btn btn-default btn-default-bottom" title="Click me to copy to clipboard." data-clipboard-target="bulk_delete">
                   Copy Delete Links
                </button>
                <button class="btn btn-default btn-default-bottom" title="Click me to copy to clipboard." data-clipboard-target="bulk_html">
                   Copy HTML Codes
                </button>
                <button class="btn btn-default btn-default-bottom" title="Click me to copy to clipboard." data-clipboard-target="bulk_forum">
                   Copy Forum Codes
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Set Multi SiteCode Links -->
<div class="modal fade" id="modalMultiRefLink" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog small-modal">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-delete-title">
                    Set Reference Link
                </div>

                <div class="modal-delete-body">
                    <form id="setpassword_forms">
                        <div class="form-group">
                            <input type="text" name="data[sitecode]" id="multi_sitecode" class="form-control">
                        </div>
                        <div class="multi_sitecode_error hidden">Pass</div>

                        <input type="button" class="btn btn-primary" style="background: #E1472C; border-color: #E1472C" id="set_multi_reference_btn" value="Submit">
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<input id="bulk_download" type="hidden" value="" />
<input id="bulk_delete" type="hidden" value="" />
<input id="bulk_html" type="hidden" value="" />
<input id="bulk_forum" type="hidden" value="" />
{!! csrf_field() !!}
<script type="text/javascript">
$( function() {

    $('body').on('click', '[data-btn="reflink"]', function( e ) {
        $('#fileid').val( $(this).attr('data-id') );
    });

    $('#set_reference_btn').click( function( e ) 
    {
        if( $('#sitecode').val().length != 4 ) {
            $('.sitecode_error').removeClass('hidden').css({'color' : 'red'}).html('Site Code must be 4 chars');
        } else {
            $.ajax({
                type: 'POST',
                url : '{{ url('reference-link') }}',
                data: { 
                    fileid : $('#fileid').val(),
                    sitecode : $('#sitecode').val().toLowerCase(),
                    _token: '{!! csrf_token() !!}'
                },
                success:function( data ) {
                    if( data.success )
                    {
                        $('#referenceLinks').modal('show');
                        $('#referenceLinks .uploaded-file-name').html('').html(data.title);
                        $('#ref_download').html('').html(data.download);
                        $('#ref_delete').html('').html(data.delete);
                        $('#ref_html').html('').html(data.html);
                        $('#ref_forum').html('').html(data.forum);
                        $('#e_1').attr('data-text', data.download);
                        $('#e_2').attr('data-text', data.delete);
                        $('#e_3').attr('data-text', data.html);
                        $('#e_4').attr('data-text', data.forum);
                        $('#sitecode').val('');
                        $('.sitecode_error').addClass('hidden')
                    } else {
                        $('.sitecode_error').removeClass('hidden').css({'color' : 'red'}).html('Site Code does not exist!');
                    }
                    
                }
            });

            
        }
    });

    var fileids = [];

    $('#set_password_btn').click( function( e ) {
        var pword = $('#pass').val(), cpword = $('#cpass').val(); 

        $('.all:checked').each( function( e ) {
            fileids.push( $(this).val() );
        });

        if( fileids.length > 0 )
        {

            $.ajax({
                type: 'POST',
                url: '{{ url('set-password') }}',
                data: { 
                    ids: fileids,
                    pass: pword,
                    cpass: cpword,
                    _token: '{!! csrf_token() !!}'
                },
                success: function( data ) {
                    if( data.success == true ) {
                        window.location.href = '{{ route('user_files') }}';
                    }
                    console.info( data );
                }
            });
        } else { alert('You haven\'t selected a file to set password'); }
    });

    $('.error').css({'color' : 'red'});
    var pass = $('#pass'), cpass = $('#cpass'), self = $(this);

    pass.on( 'blur', function( e ) {
        if( cpass.val() == pass.val() && pass.val().length >= 3 )
        {
            $('#set_password_btn').removeAttr('disabled');
            $('.error').addClass('hidden');
        }
        else {
            $('#set_password_btn').attr('disabled', 'disabled');
            $('.error').removeClass('hidden');
            $('.error').html('Passwords are not matched / Password less than 3');
        }
    } );

    cpass.on( 'blur', function( e ) {
        if( pass.val() === cpass.val() && cpass.val().length >= 3 ) {
            $('#set_password_btn').removeAttr('disabled');
            $('.error').addClass('hidden');
        }
        else {
            $('#set_password_btn').attr('disabled', 'disabled');
            $('.error').removeClass('hidden');
            $('.error').html('Passwords are not matched / Password less than 3');
        }

    } );

    var maff = $( '#multi_action_form_file' ), file_action = $( '#file_action' );
    
    $( '#multi_action_links' ).on( 'click', '[data-action]', function( evt ) {
        evt.preventDefault();
        
        file_action.val( $( this ).data( 'action' ) );
        
        if ( ( maff.serializeArray() ).length > 2 && !!( file_action.val() ).length )
        {
            maff.submit();
        }
        
        return false;
    } );
    
    
    var fc = $( '#files_container' ), mvdir = $( '#move_folder_id' );
    $( '#move_folder_form' ).on( 'submit', function ( evt ) {
        if( $('.all:checked').length < 1 )
        {
            evt.preventDefault();
        }

        var s = $( '#move_folder_id' ), form_data = $( '#multi_action_form_file' ).serializeArray();

        if ( form_data.length > 2 && mvdir.val() != '' )
        {
            var a = [];
            
            for ( var i in form_data )
            {
                var e = form_data[ i ];
                
                if ( e.name == "file[selected][]" )
                {
                    a.push( e.value );
                }
            }
            
            fc.val( a.join( ',' ) );
            
            return true;
        }
        
        return false;
    } );
    
    $(".select-all").click(function(e) {
        //alert($(this).attr('id'))
        e.preventDefault()
        if ( $(".all").length == $('.all:checked').length ) {
            $(".all").prop("checked", false);
        } else {
            $(".all").prop("checked", true);
        }
    });
    
    $( 'body' ).on( 'click', '[data-file-id]', function ( evt ) {
        evt.preventDefault();

        var self = $( this ), img = self.find( 'img' ).eq( 0 );
        var old_img = img.attr( 'src' );
        

        var http = $.ajax( {
            url: self.attr( 'href' ),
            data: {
                type: 'file',
                id: self.data( 'file-id' ),
                ajax: true,
                _token: '{!! csrf_token() !!}'
            },
            type: 'POST',
            
            beforeSend: function() {
                img.attr( 'src', '{{ url('img/loaders/17.gif') }}' );
            },
            
            success: function ( data, ts, xhr ) {
                if ( xhr.readyState == 4 && xhr.status == 200 )
                {
                    if ( data.success )
                    {
                        var is_x        = /1$/.test( self.attr( 'href' ) ),
                        new_img_src = '{{ url('') }}'+ ( is_x ? '/img/icons/success.png' : '/img/icons/error.png' ),
                        new_a_href  = ( self.attr( 'href' ) ).replace( /.$/, '' ) + ( is_x ? '0' : '1' );
                        
                        img.attr( 'src', new_img_src );
                        self.attr( 'href', new_a_href );
                    }
                    else
                    {
                        alert( 'Missing passed data.' );
                        img.attr( 'src', old_img );
                    }
                }
            },
            
            error: function() {
                alert( 'AJAX Http Error, kindly refresh.' );
                img.attr( 'src', old_img );
            }
        } );

return false;
} );

var sq = $( '#search_query' ), search_form = $( '#search' ), search_result = $( '#search-result' );

var delete_modal = $( '#myModal1' ), num_delete_files = $( '#num_delete_files' );
$( '#sample_1' ).on( 'click', '[data-delete-file]', function ( evt ) {
    evt.preventDefault();
    
    delete_modal.modal( 'show' );
    num_delete_files.text( '1' );
    $( this ).parent().parent().find( '.all' ).prop( 'checked', true );
} );


$( '#mass_delete' ).on( 'click', function ( evt ) {
    evt.preventDefault();

    var count = $('.all:checked').length;

    if ( ( maff.serializeArray() ).length > 2 )
    {
        num_delete_files.text( count );
        delete_modal.modal( 'show' );
    }
    else
    {
        alert( 'No Selected Files' );
    }
    
    return false;
} );

window.mass_delete = function()
{
    var maff = $( '#multi_action_form_file' ), file_action = $( '#file_action' ), form_data = maff.serializeArray();
    
    file_action.val( 'mass_delete' );
    
    if ( ( maff.serializeArray() ).length > 2 && !!( file_action.val() ).length )
    {
        maff.submit();
    }
}

var data_sort_icon = [ 'glyphicon glyphicon-chevron-down', 'glyphicon glyphicon-chevron-up' ], sort_type = $( '#sort_type' );
$( 'th' ).on( 'click', function( evt ) {
        evt.preventDefault();
        var self = $( this ).children('[data-sort]'), sort = 'ASC';
        
        var i = self.find( 'i' );
        if ( i.hasClass( data_sort_icon[ 0 ] ) )
        {
            sort = 'DESC';
            i.removeClass( data_sort_icon[ 0 ] ).addClass( data_sort_icon[ 1 ] );
        }
        else
        {
            sort = 'ASC';
            i.removeClass( data_sort_icon[ 1 ] ).addClass( data_sort_icon[ 0 ] );
        }
        
        sort_type.val( self.data( 'sort' ) +','+ sort );
        
        //search();
    } );
} );

$('#sample_1').on('click', '[data-btn="share"]', function( e ) {
    var download = $('#link_download'), del = $('#link_delete'), page = $('#link_html'), forum = $('#link_forum');
    var self = $(this);    

    download.html('');
    del.html( '' );  
    page.html('');
    forum.html('');

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '{{ url('single-showlink')}}',
        type: 'POST',
        data: {
            id: self.data('id'),
            _token: '{!! csrf_token() !!}'
        },
        success:function( resp ) {


            download.html(resp.url_download);
            $('#s_1').attr('data-text', resp.url_download);  
            del.html( resp.url_delete );  
            $('#s_2').attr('data-text', resp.url_delete); 
            page.html('&lt;a href=&quot;'+ resp.url_download +'&quot; target=&quot;_blank&quot; title=&quot;Download From File Upload Script&quot;&gt;' + resp.title +'&lt;a&gt;');
            $('#s_3').attr('data-text', '&lt;a href=&quot;'+ resp.url_download +'&quot; target=&quot;_blank&quot; title=&quot;Download From File Upload Script&quot;&gt;' + resp.title +'&lt;a&gt;');  
            forum.html('[url=&quot;' + resp.url_download + '&quot;]Download From FileSpace[/url]');
            $('#s_4').attr('data-text', '[url=&quot;' + '{{ url( '/file/') }}'+ '/' + self.data('id') + '&quot;]Download From FileSpace[/url]'); 
            $('.uploaded-file-name').html( resp.main_title );
        } 

    });
});

$('#mass_show_links').on( 'click', function( e ) {
    var val = [];

    $('#sample_1 .all:checked').each( function( i ) {
        val[i] = $(this).val();
    } );

    if( $('.all:checked').length > 0 )
    {
        $.ajax({
            type: 'POST',
            url: '{{ url('multiple-show-links') }}',
            data: { ids: val, _token: '{!! csrf_token() !!}' },
            beforeSend: function() {
                $('#holder').html('<h3>Loading.....</h3>');
            }, 
            success: function( i ) {
                $('#holder').html('');

                var html = '', datos = [], ctr = 0;

                var download = '';
                var del = '';
                var html_link = '';
                var forum = '';

                $.each( i, function ( x ) {

                    download += i[x].url_download + '\n';
                    del += i[x].url_delete + '\n';
                    html_link += '&lt;a href=&quot;' + i[x].url_download + '&quot; target=&quot;_blank&quot; title=&quot;Download From File Upload Script&quot;&gt;download ' + i[x].title + '&lt;/a&gt;' + '\n';
                    forum += '[url=&quot;' + i[x].url_download + '&quot;]' + i[x].title + '[/url]' + '\n';

                    html += '<div class="uploaded-file-popup-holder">' +
                                '<div class="uploaded-file-name">' +
                                    i[x].main_title +
                                '</div>' +
                            '<div class="uploaded-file-info-hoder">' +
                            '<table class="table table-bordered showlinks">' +

                            '<tr>' +
                                '<td class="col-red" width="168">Download Link:</td>' +
                                '<td class="b_1" id="link_download_' + ctr +'">' + i[x].url_download + '</td>' +
                                '<td id="copy_download" class="align-center valign-middle"><span id="c_1" class="clippy" data-text="' + i[x].url_download + '" data-clipboard-target="link_download_' + ctr +'">COPY</span></td>' +
                            '</tr>' +
                            '<tr>' +
                                '<td class="col-red">Delete Link::</td>' +
                                '<td class="b_2" id="link_delete_' + ctr +'">' + i[x].url_delete + '</td>' +
                                '<td id="copy_delete" width="100" class="align-center valign-middle"><span id="c_1" class="clippy" data-text="' + i[x].url_delete + '" data-clipboard-target="link_delete_' + ctr +'">COPY</span></td>' +
                            '</tr>' +
                            '<tr>' +
                                '<td class="col-red">HTML Code:</td>' +
                                '<td class="b_3" id="link_html_' + ctr +'">' +
                                    '&lt;a href=&quot;' + i[x].url_download + '&quot; target=&quot;_blank&quot; title=&quot;Download From File Upload Script&quot;&gt;download ' + i[x].title + '&lt;/a&gt;' +
                                '</td>' +
                                '<td id="copy_html" class="align-center valign-middle"><span id="c_1" class="clippy" data-text="' + '&lt;a href=&quot;' + i[x].url_download + '&quot; target=&quot;_blank&quot; title=&quot;Download From File Upload Script&quot;&gt;download ' + i[x].title  + '" data-clipboard-target="link_html_' + ctr +'">COPY</span></td>' +
                            '</tr>' +
                            '<tr>' +
                                '<td class="col-red">Forum Code:</td>' +
                                '<td class="b_4" id="link_forum_' + ctr +'">' +
                                    '[url=&quot;' + i[x].url_download + '&quot;]' + i[x].title + '[/url]' +
                                '</td>' + 
                                '<td id="copy_forum" class="align-center valign-middle"><span id="c_1" class="clippy" data-text="' + '[url=&quot;' + i[x].url_download + '&quot;]' + i[x].title + '[/url]' + '" data-clipboard-target="link_forum_' + ctr +'">COPY</span></td>' +
                            '</tr>' +
                            '</table></div></div>';
                    ctr++;        
                });

                $('#bulk_download').val( download );
                $('#bulk_delete').val( del );
                $('#bulk_html').val( html_link );
                $('#bulk_forum').val( forum );

                $('#holder').html(html);

                var client = new ZeroClipboard( $('.clippy'), {
                    moviePath: '{{ url('js/plugins/swf/ZeroClipboard.swf')}}'
                } );
                client.on( "load", function( client ) {
                    client.on( "complete", function( client, args ) {
                        var self = $( this ), id = 'lol_'+ (+new Date());
                        $( '<span style="background: #E2F5E9;position: absolute;width: 11em;" class="copied" id="'+ id +'">Copied to clipboard!</span>' ).insertAfter( self );
                        $( '#'+ id ).fadeOut( 2000, function() {
                            $( '#'+ id ).remove();
                        } );
                    } );
                } );

                
            }

        });
    }
    else {
        $('#holder').html('<h3>No Files Selected</h3>');
    }
} );

$('#set_multi_reference_btn').on( 'click', function( e ) {
    var val = [];

    $('#sample_1 .all:checked').each( function( i ) {
        val[i] = $(this).val();
    } );

    if( $('#multi_sitecode').val().length != 4 ) {
        $('.multi_sitecode_error').removeClass('hidden').css({'color' : 'red'}).html('Site Code must be 4 chars');
    } else {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: '{{ url('multi-reference-link') }}',
            data: { 
                ids: val,
                sitecode : $('#multi_sitecode').val() 
            },
            beforeSend: function() {
                $('#holders').html('<h3>Loading.....</h3>');
            },
            success:function( data ){
                if( data.success )
                {
                    var html = '', ctr = 0;
                    $('#multiRefLink').modal('show');
                    $('#modalMultiRefLink').modal('hide');

                    var download = '';
                    var del = '';
                    var html_link = '';
                    var forum = '';

                    $.each( data.files, function( x ) {

                        download += data.files[x].download + '\n';
                        del += data.files[x].delete + '\n';
                        html_link += '&lt;a href=&quot;' + data.files[x].download + '&quot; target=&quot;_blank&quot; title=&quot;Download From File Upload Script&quot;&gt;download ' + data.files[x].title + '&lt;/a&gt;' + '\n';
                        forum += '[url=&quot;' + data.files[x].download + '&quot;]' + data.files[x].title + '[/url]' + '\n';

                        html += '<div class="uploaded-file-popup-holder">' +
                                '<div class="uploaded-file-name">' +
                                    data.files[x].title +
                                '</div>' +
                            '<div class="uploaded-file-info-hoder">' +
                            '<table class="table table-bordered showlinks">' +

                            '<tr>' +
                                '<td class="col-red" width="168">Download Link:</td>' +
                                '<td class="b_1" id="ref_download_' + ctr +'">' + data.files[x].download + '</td>' +
                                '<td id="copy_download" class="align-center valign-middle"><span id="d_1" class="clippy" data-text="' + data.files[x].download + '" data-clipboard-target="ref_download_' + ctr +'">COPY</span></td>' +
                            '</tr>' +
                            '<tr>' +
                                '<td class="col-red">Delete Link::</td>' +
                                '<td class="b_2" id="ref_delete_' + ctr +'">' + data.files[x].delete + '</td>' +
                                '<td id="copy_delete" width="100" class="align-center valign-middle"><span id="d_2" class="clippy" data-text="' + data.files[x].delete + '" data-clipboard-target="ref_delete_' + ctr +'">COPY</span></td>' +
                            '</tr>' +
                            '<tr>' +
                                '<td class="col-red">HTML Code:</td>' +
                                '<td class="b_3" id="ref_html_' + ctr +'">' +
                                    '&lt;a href=&quot;' + data.files[x].download + '&quot; target=&quot;_blank&quot; title=&quot;Download From File Upload Script&quot;&gt;download ' + data.files[x].title + '&lt;/a&gt;' +
                                '</td>' +
                                '<td id="copy_html" class="align-center valign-middle"><span id="d_3" class="clippy" data-text="' + '&lt;a href=&quot;' + data.files[x].download + '&quot; target=&quot;_blank&quot; title=&quot;Download From File Upload Script&quot;&gt;download ' + data.files[x].title  + '" data-clipboard-target="ref_html_' + ctr +'">COPY</span></td>' +
                            '</tr>' +
                            '<tr>' +
                                '<td class="col-red">Forum Code:</td>' +
                                '<td class="b_4" id="ref_forum_' + ctr +'">' +
                                    '[url=&quot;' + data.files[x].download + '&quot;]' + data.files[x].title + '[/url]' +
                                '</td>' + 
                                '<td id="copy_forum" class="align-center valign-middle"><span id="d_4" class="clippy" data-text="' + '[url=&quot;' + data.files[x].download + '&quot;]' + data.files[x].title + '[/url]' + '" data-clipboard-target="ref_forum_' + ctr +'">COPY</span></td>' +
                            '</tr>' +
                            '</table></div></div>';
                        
                        ctr++;
                    });

                    $('#bulk_download').val( download );
                    $('#bulk_delete').val( del );
                    $('#bulk_html').val( html_link );
                    $('#bulk_forum').val( forum );

                    $('#holders').html(html);

                    var client = new ZeroClipboard( $('.clippy'), {
                        moviePath: '{{ url('js/plugins/swf/ZeroClipboard.swf')}}'
                    } );
                    client.on( "load", function( client ) {
                        client.on( "complete", function( client, args ) {
                            var self = $( this ), id = 'lol_'+ (+new Date());
                            $( '<span style="background: #E2F5E9;position: absolute;width: 11em;" class="copied" id="'+ id +'">Copied to clipboard!</span>' ).insertAfter( self );
                            $( '#'+ id ).fadeOut( 2000, function() {
                                $( '#'+ id ).remove();
                            } );
                        } );
                    } );
                }
            }

        });
    }
} );


</script>

<script type="text/javascript" src="{{ url('js/plugins/data-tables/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ url('js/plugins/data-tables/DT_bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ url('js/plugins/data-tables/table-ajax.js') }}"></script>

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


    var client = new ZeroClipboard( $('.clippy'), {
        moviePath: '{{ url('js/plugins/swf/ZeroClipboard.swf')}}'
    } );
    client.on( "load", function( client ) {
        client.on( "complete", function( client, args ) {
            var self = $( this ), id = 'lol_'+ (+new Date());
            $( '<span style="background: #E2F5E9;position: absolute;width: 11em;" class="copied" id="'+ id +'">Copied to clipboard!</span>' ).insertAfter( self );
            $( '#'+ id ).fadeOut( 2000, function() {
                $( '#'+ id ).remove();
            } );
        } );
    } );
    
    // dustin added copy to buttons for bulk copies

    $('.btn-default').each(function() {
        var obj = $(this);
        var client = new ZeroClipboard( $(this), {
            moviePath: '../js/plugins/swf/ZeroClipboard.swf'
        });
        
        client.on( "load", function(client) {
            client.on( "complete", function(client, args) {
                var self = $( this ), id = 'rofl_'+ (+new Date());
                $( '<span class="copied-x" id="'+ id +'" style="margin-left: -'+ ( ( obj.width() / 2 ) + 90 ) +'px; position: absolute;top: 69px;background: #E2F5E9;padding: 0 13px;">Links copied to clipboard!</span>' ).insertAfter( self );
                $( '#'+ id ).fadeOut( 2000, function() {
                    $( '#'+ id ).remove();
                } );
            });
        });
    });

    $('.btn-default-bottom').each(function() {
        var obj = $(this);
        var client = new ZeroClipboard( $(this), {
            moviePath: '../js/plugins/swf/ZeroClipboard.swf'
        });
        
        client.on( "load", function(client) {
            client.on( "complete", function(client, args) {
                var self = $( this ), id = 'rofl_'+ (+new Date());
                $( '<span class="copied-x" id="'+ id +'" style="margin-left: -'+ ( ( obj.width() / 2 ) + 90 ) +'px; position: absolute;bottom: 4px;background: #E2F5E9;padding: 0 13px;">Links copied to clipboard!</span>' ).insertAfter( self );
                $( '#'+ id ).fadeOut( 2000, function() {
                    $( '#'+ id ).remove();
                } );
            });
        });
    });
});
</script>

<script type="text/javascript">
jQuery(document).ready(function() {       
 UserFilesManagerTable.init();
});
</script>


@stop