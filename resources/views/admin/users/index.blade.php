@extends('layouts.admin')
@section('page_css')
<link href="{!! url('assets/global/plugins/datatables/datatables.min.css') !!}" rel="stylesheet" type="text/css" />
<link href="{!! url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') !!}" rel="stylesheet" type="text/css" />
<link href="{!! url('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}" rel="stylesheet" type="text/css" />
@stop
@section('title', 'Users')
@section('content')
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

    <div class="alert alert-success hide" id="main"></div>

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
                    <div class="table-container">
                        <div class="table-actions-wrapper">
                            <span> </span>
                            
                        </div>
                        <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax" data-source="{!! route('users_listings') !!}" data-token="{!! csrf_token() !!}">
                            <thead>
                                <tr role="row" class="heading">
                                    <th width="8%">Username</th>
                                    <th>Country</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Aff.Mode</th>
                                    <th>Funds</th>
                                    <th>Files</th>
                                    <th>Storage(GB)</th>
                                    <th>Reg.Date</th>
                                    <th>Last Visit</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody> 
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End: life time stats -->
        </div>
    </div>
</div>
 <div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add free days</h4>

            </div>
            <div class="modal-body">
                <div class="alert alert-danger hide"></div>
                <form class="form-horizontal" id="add_days">
                    {!! csrf_field() !!}
                    <label>Days to add</label>
                    <input type="text" class="form-control" name="amount">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="submit" id="submit_freedays" class="btn green">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- END PAGE CONTENT INNER -->
@stop

@section('page_plugin')
<script src="{!! url('assets/global/scripts/datatable.js') !!}" type="text/javascript"></script>
<script src="{!! url('assets/global/plugins/datatables/datatables.min.js') !!}" type="text/javascript"></script>
<script src="{!! url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') !!}" type="text/javascript"></script>
<script src="{!! url('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}" type="text/javascript"></script>
@stop


@section('page_script')
<script src="{!! url('assets/pages/scripts/table-datatables-ajax.min.js') !!}" type="text/javascript"></script>
<script src="{!! url('assets/scripts/form-validators.js') !!}" type="text/javascript"></script>
<script type="text/javascript">
function addFreeDays(self) {
    var self = $(self);
    $('#basic').modal('show');
    $('#basic .modal-title').html('Add free days to username: ' + self.data('name'));
    $('#add_days').attr('action', self.data('url'));
}
$('#submit_freedays').click(function(e) {
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: $('#add_days').attr('action'),
        data: $('#add_days').serialize()
    }).done( function(data) {
        if( data.success ) {
            $('#basic').modal('hide');
            $('#basic .alert-danger').removeClass('hide').addClass('hide');
            $('#main').removeClass('hide').html(data.msg);
        }
    }).error( function(jqXhr) {
        $('#basic .alert-danger').removeClass('hide');
        FormValidator.displayErrors(jqXhr, $('.alert-danger'));
    })
})
</script>
@stop

