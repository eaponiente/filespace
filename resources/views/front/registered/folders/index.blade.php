@extends('layouts.base')
@section('title', 'Folders')
@section('metadata')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
@stop
@section('content')
<style type="text/css">
.dataTable thead th{
    background: none repeat scroll 0% 0% #EFF1F8 !important;
    border: 1px solid #CACEDD !important;
    font-size: 13px !important;
    padding: 9px !important;
}
tbody td a {
    margin: 0 5px
}
</style>
<div class='content-registered'>
    {!! Session::get( '_folder_status' ) !!}
    {!! Session::get( '_multi_select_action' ) !!}
    <div style="height: 15px;"></div>
    <div class="page-title">
        <span class="folder-edit-page-title">
            {!! session('message') ? session('message') : 'Folders' !!}
        </span>
    </div>
    <div class="folders-body">
        <div class="row folders-nav">
            <div class="col-sm-6">
                <div class="pull-left">
                    
                </div>
                <div class="pull-left folders-nav-records-label">
                   
                </div>
            </div>
            <div class="col-sm-6">
                <div class="pull-right">
                    
                    
                    <div class="pull-left folders-nav-btn-holder-new">
                        <a href="{{ route('folders.create') }}" class="btn btn-default btn-sm">New Folder</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="folder-table-holder">
            <form method="POST" action="{!! route('files_multi_select_action') !!}" id="multi_action_form_file">
            {!! csrf_field() !!}
            <input type="hidden" name="file[multi_type]" value="folder" />
                <input type="hidden" name="file[action]" id="file_action" />
            <table class="table-folders" id="sample_1" data-source="{{ route('user_folders_listings') . $querystring }}">
                <thead>
                    <tr>
                        <th class="align-center" width="80"><a href="#" class="select-all">Select All</a></th>
                        <th class="align-center" ><i class="glyphicon glyphicon-chevron-down"></i> Folder Name</th>
                        <th class="align-center"><i class="glyphicon glyphicon-chevron-down"></i> Files</th>
                        <th class="align-center">Created On</th>

                        <th class="align-center" width="200">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    
                </tbody>
            </table>
           </form>
        </div>

        <div class="folder-actions-links" id="multi_action_links">
            Actions for selected folders:
            <a href="#" id="mass_delete">Delete</a>
            <!-- <a href="#" data-action="make_public">Make Public</a>
            <a href="#" data-action="make_private">Make Private</a>
            <a href="#" data-action="premium_only">Premium Only: YES</a>
            <a href="#" data-action="not_premium_only">Premium Only: NO</a>
            <a href="#" data-toggle="modal" data-target="#setPasswordModal">Set Password</a>
            <a href="#" data-action="unset_password">Unset Password</a> -->
        </div>
    </div>

</div>
<!-- Modal delete-->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog small-modal">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-delete-title">
                    Delete <span id="num_delete_files"></span> folder(s)?
                </div>

                <div class="modal-delete-body">
                    <a href="javascript:;" onclick="mass_delete()" clasS="btn btn-default" id="delete_confirm_btn">Confirm</a><button clasS="btn btn-cancel-delete" data-dismiss="modal" onclick="$( '.all' ).prop( 'checked', false )">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$( function() {

    var fileids = [];

    $('.error').css({'color' : 'red'});

    $( '[data-delete-confirm]' ).on( 'click', function( evt ) {
        evt.preventDefault();
        
        if ( confirm( 'Are you sure you want to delete this? Deleting this will cause all files and its sub-folders to be deleted PERMANENTLY!' ) )
        {
            top.location.href = this.href;
            return true;
        }
        
        return false;
    } );
    
    var maff = $( '#multi_action_form_file' ), file_action = $( '#file_action' );
    
    $( '#multi_action_links' ).on( 'click', '[data-action]', function( evt ) {
        evt.preventDefault();
        
        file_action.val( $( this ).data( 'action' ) );
        
        maff.submit();
    } );
    $(".select-all").click(function(e) {
        e.preventDefault()
        if ( $(".all").length == $('.all:checked').length ) {
            $(".all").prop("checked", false);
        } else {
            $(".all").prop("checked", true);
        }
    });
    
    $( 'body' ).on( 'click', '[data-folder-id]', function ( evt ) {
        evt.preventDefault();
        
        var self = $( this ), img = self.find( 'img' ).eq( 0 );
        var old_img = img.attr( 'src' );
           
        var http = $.ajax( {
            url: self.attr( 'href' ),
            data: {
                type: 'folder',
                id: self.data( 'folder-id' ),
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
                            new_img_src = ( is_x ? '{!! url('img/icons/success.png') !!}' : '{!! url('/img/icons/error.png') !!}' ),
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
        if ( $('.all:checked').length > 0 )
        {
            num_delete_files.text( $('.all:checked').length );
            delete_modal.modal( 'show' );
        }
        else
        {
            alert( 'No Selected Folder' );
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
    $( '[data-sort]' ).on( 'click', function( evt ) {
        evt.preventDefault();
        var self = $( this ), sort = 'ASC';
        
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
        
        search();
    } );
} );
</script>

<script type="text/javascript" src="{{ url('js/plugins/data-tables/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ url('js/plugins/data-tables/DT_bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ url('js/plugins/data-tables/table-ajax.js') }}"></script>

<script type="text/javascript">
jQuery(document).ready(function() {       
   FilesManagerTable.init();
});
</script>


@stop