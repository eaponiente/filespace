@extends('layouts.admin')
@section('page_css')
<link href="{!! url('assets/global/plugins/datatables/datatables.min.css') !!}" rel="stylesheet" type="text/css" />
<link href="{!! url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') !!}" rel="stylesheet" type="text/css" />
@stop
@section('title', 'Users')
@section('content')
<style type="text/css">
.inline {
    display: inline;
}
</style>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">

    @if (session('msg'))
        <div class="alert alert-success">
            {!! session('msg') !!}
        </div>
    @endif 

    @if (session('fail'))
        <div class="alert alert-danger">
            {!! session('fail') !!}
        </div>
    @endif 

    <div class="row">
        <div class="col-md-12">
            
            <!-- Begin: life time stats -->
            <div class="portlet light portlet-fit portlet-datatable ">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-dark sbold uppercase">Users</span>
                    </div>
                    <div class="actions">
                            
                            <a href="{!! route('admin.users.create') !!}" class="btn btn-transparent grey-salsa btn-outline btn-circle btn-sm active">Add New</a>
                            <!-- <label class="btn btn-transparent grey-salsa btn-outline btn-circle btn-sm">
                                <input type="radio" name="options" class="toggle" id="option2">Settings</label> -->
                        
                    </div>
                </div>
                <div class="portlet-body">
                    <form name="edit_details" method="post" action="">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Username:</td>
                                    <td>{{ $user->username }}</td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                
                                <tr>
                                    <td>Status:</td>
                                    <td>
                                        {!! isPremium($user) ? 'Free' : 'Premium until ' . $user->premium_expiration_date_and_time->format('F j, Y h:i A') !!}
                                        
                                        <a href="{{ url( Config::get('constants.admin_url') . '/users/transactions/' . Request::segment(3) ) }}" class="btn btn-success btn-xs">View Transactions</a>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>Files:</td>
                                    <td>{{ $user->files }}</td>
                                </tr>
                                <tr>
                                    <td>Storage:</td>
                                    <td>
<?php 
$c = $user->custom_storage > 0 ? 'C ' : ' '; 
$storage = '';
if( isPremium($user) ) {
    $storage = str_replace(' ', $c, formatBytes($settings->premium_user_storage, 6));
} else {
    $storage = str_replace(' ', $c, formatBytes($settings->registered_user_storage, 6));
}
if( $user->custom_storage > 0 ) 
    $storage = str_replace(' ', $c, formatBytes($user->custom_storage, 6) );
?>
{!! formatBytes($user->storage_used) . '/' . $storage !!}

                                        <a href="#" class="btn btn-success btn-xs" data-toggle="modal" data-target="#basic">Set Custom Storage</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Balance:</td>
                                    <td>{{ number_format( $user->balance_amount, 2 ) }}</td>
                                </tr>
                                <tr>
                                    <td>Affiliate:</td>
                                    <td>{{ $user->is_affiliate }}</td>
                                </tr>
                                <tr>
                                    <td>Bonus %:</td>
                                    <td>{{ $user->bonus }}</td>
                                </tr>
                                <tr>
                                    <td>Referring user:</td>
                                    <td>N/A</td>
                                </tr>
                                <tr>
                                    <td>Registration date:</td>
                                    <td>{{ date( 'F j, Y', strtotime( $user->registration_date ) ) }} ({{ $user->registration_ip }})</td>
                                </tr>
                                <tr>
                                    <td>Confirmation date:</td>
                                    <td>{{ date( 'F j, Y', strtotime( $user->confirmation_date ) ) }}  ( {{ $user->confirmation_ip }})</td>
                                </tr>
                                <tr>
                                    <td>Last premium transaction:</td>
                                    <td>Credit Card / Complimentary / Voucher / Webmoney / Paypal</td>
                                </tr>
                                <tr>
                                    <td>Last transaction verified:</td>
                                    <td>No / Auto / Manual</td>
                                </tr>
                                <tr>
                                    <td>Last CC transaction country:</td>
                                    <td>N/A</td>
                                </tr>
                                <tr>
                                    <td>1st Download after transaction:</td>
                                    <td>N/A</td>
                                </tr>
                                <tr>
                                    <td>2nd Download after transaction:</td>
                                    <td>N/A</td>
                                </tr>
                                <tr>
                                    <td>3rd Download after transaction:</td>
                                    <td>N/A</td>
                                </tr>
                                <tr>
                                    <td>4th Download after transaction:</td>
                                    <td>N/A</td>
                                </tr>
                                <tr>
                                    <td>5th Download after transaction:</td>
                                    <td>N/A</td>
                                </tr>
                            </table>
                            <p>
                                <a href="{{ route('admin.users.edit', [$user->id]) }}" class="btn btn-default">EDIT</a>
                            </p>
                        </form>

                        <h3>Notes</h3>
                        <a href="javascript:;" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#note_modal">Add new</a>

                        <table id="notes_table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date Noted</th>
                                    <th>Message</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach( $user->notes as $notes )
                            <tr>
                                <td>{!! $notes->note_date->format('Y-m-d') !!}</td>
                                <td>{!! $notes->notes !!}</td>
                                <td>
                                    <a href="javascript:;" data-update="{!! route('admin.notes.update', [$notes->id]) !!}" data-destroy="{!! route('admin.notes.destroy', [$notes->id]) !!}" data-note="{!! $notes->notes !!}" class="btn btn-xs btn-primary" onclick="editNote(this);">Edit</a>
                                    {!! delete_method( route('admin.notes.destroy', [$notes->id]), 'inline' ) !!}
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
            <!-- End: life time stats -->
        </div>
    </div>
</div>
<!-- END PAGE CONTENT INNER -->

<!-- start modal -->
 <div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Set Custom Storage (GB)</h4>

            </div>
            <div class="modal-body">
                <div class="alert alert-danger hide"></div>
                <form class="form-horizontal" id="set_customstorage">
                    {!! csrf_field() !!}
                    <input type="text" class="form-control" name="storage">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="submit" id="submit_freedays" class="btn green">Update Storage</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- start modal -->
 <div class="modal fade" id="note_modal" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add Note</h4>

            </div>
            <div class="modal-body">
                <div class="alert alert-danger hide"></div>
                <form class="form-horizontal" id="set_note">
                    {!! csrf_field() . method_field('POST') !!}
                    <input type="hidden" name="user_id" value="{!! $user->id !!}">
                    <textarea class="form-control" name="notes"></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="submit" id="submit_note" class="btn green">Add Note</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@stop


@section('page_script')
<script src="{!! url('assets/scripts/form-validators.js') !!}" type="text/javascript"></script>
<script type="text/javascript">

$('#submit_freedays').click(function(e) {
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: '{!! route('set_custom_storage', [$user->id]) !!}',
        data: $('#set_customstorage').serialize()
    }).done( function(data) {
        if( data.success ) {
            $('#basic').modal('hide');
            swal("Excellent!", data.msg, "success")
            window.location.reload();
        }
    }).error( function(jqXhr) {
        $('#basic .alert-danger').removeClass('hide');
        FormValidator.displayErrors(jqXhr, $('.alert-danger'));
    })
})

$('#submit_note').click(function(e) {
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: '{!! route('admin.notes.store') !!}',
        data: $('#set_note').serialize()
    }).done( function(data) {
        if( data.success ) {
            $('#note_modal').modal('hide');
            swal("Excellent!", data.msg, "success")
            var html = '<tr><td>' + data.value.date + '</td><td>' + data.value.notes + '</td></tr>';
            $('#notes_table tbody').prepend(html);
            $('#note_modal .alert-danger').addClass('hide');
            $('textarea').val('');
        }
    }).error( function(jqXhr) {
        $('#note_modal .alert-danger').removeClass('hide');
        FormValidator.displayErrors(jqXhr, $('.alert-danger'));
    })
});

function editNote(self) {
    var self = $(self);

    var find = self.closest('tr').find('td:nth-child(2)').text();
    var route = self.data('update');
    var button = '<button type="button" data-route="'+route+'" onclick="updateNote(this);" class="btn btn-default">Update</button>'+
                 '<button type="button" class="btn btn-default" data-value="'+find+'" onclick="cancel(this);">Cancel</button>';
    var replace = self.closest('tr').find('td:nth-child(2)').html( '<textarea cols="3" class="form-control">' + find + '</textarea>' + button );
}

function cancel(self){
    var me = $(self);
    me.parent().children().html('');
    me.parent().html( me.data('value') );
}

function updateNote(self) {
    var me = $(self);
    var textarea = me.closest('tr').find('td:nth-child(2) textarea').val();
    $.ajax({
        type: 'POST',
        url: me.data('route'),
        data: {
            _token : '{!! csrf_token() !!}',
            _method: 'PUT',
            notes: textarea
        }
    }).done(function(data) {
        me.parent().children().html('');
        me.parent().html( data.msg );
    });
}
 
</script>
@stop

