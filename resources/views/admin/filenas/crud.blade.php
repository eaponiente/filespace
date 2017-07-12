@extends('layouts.admin')
@section('page_css')
<link href="{!! url('assets/global/plugins/datatables/datatables.min.css') !!}" rel="stylesheet" type="text/css" />
<link href="{!! url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') !!}" rel="stylesheet" type="text/css" />
<link href="{!! url('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}" rel="stylesheet" type="text/css" />
@stop
@section('title', (isset($edit) ? 'Edit ' : 'Add ') . 'Filenas')
@section('content')
<style type="text/css">
.type_row {
    display: none;
}
</style>
<div class="page-content-inner">

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif 

    @if( session('fail') )
        <div class="alert alert-danger">
            {!! session('fail') !!}
        </div>
    @endif

    @if( session('msg') )
        <div class="alert alert-danger">
            {!! session('msg') !!}
        </div>
    @endif

  <form role="form" method="POST" action="{!! isset($edit) ? route('admin.filenas.update', [$edit->id]) : route('admin.filenas.store') !!}">    
    
    {!! csrf_field() !!}
{!! isset($edit) ? method_field('PUT') : method_field('POST') !!}
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light ">
                
                <div class="portlet-body form">
                        <div class="form-body">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group col-md-12">
                                        <label>Server Label</label>
                                        <input type="text" class="form-control" name="serverLabel" value="{!! isset($edit) ? $edit->serverLabel : old('serverLabel') !!}"> 
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group col-md-12">
                                        <label>Status</label>
                                        <select class="form-control" name="statusId" >
                                            @foreach( $status as $s => $value)
                                            <option value="{!! $value->id !!}" {!! isset($edit) && $value->id == $edit->statusId ? 'selected' : '' !!}>{!! $value->label !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                

                                <div class="form-group">
                                    <div class="input-group col-md-12">
                                        <label>Storage Path</label>
                                        <input type="text" class="form-control" name="storagePath" value="{!! isset($edit) ? $edit->storagePath : old('storagePath') !!}"> 
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group col-md-12">
                                        <label>Total Space</label>
                                        <input type="text" class="form-control" name="total_space" value="{!! isset($edit) ? $edit->total_space : old('total_space') !!}"> 
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group col-md-12">
                                        <label>Server Type</label>
                                        <select class="form-control" id="servertype" name="serverType" onchange="toggleType($(this));">
                                            <option value="">Select Server Type: </option>
                                            @foreach(config('constants.filenas.type') as $type => $val)
                                                <option value="{!! $val !!}" {!! isset($edit) && $val == $edit->serverType ? 'selected' : '' !!}>{!! ucfirst($val) !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">

                                <div id="remote" style="display: none;">
                                    <div class="form-group">
                                        <div class="input-group col-md-12">
                                            <label>File Server Domain Name</label>
                                            <input type="text" class="form-control" name="fileServerDomainName" value="{!! isset($edit) ? $edit->fileServerDomainName : old('fileServerDomainName') !!}"> 
                                        </div>
                                    </div>
                                </div>

                                <div id="ftp" style="display: none;">
                                    <div class="form-group">
                                        <div class="input-group col-md-12">
                                            <label>IP Address</label>
                                            <input type="text" class="form-control" name="ipAddress" value="{!! isset($edit) ? $edit->ipAddress : old('ipAddress') !!}"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group col-md-12">
                                            <label>FTP Port</label>
                                            <input type="text" class="form-control" onkeypress="isNumber(event)" name="ftpPort" value="{!! isset($edit) ? $edit->ftpPort : old('ftpPort') !!}"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group col-md-12">
                                            <label>FTP Username</label>
                                            <input type="text" class="form-control" name="ftpUsername" value="{!! isset($edit) ? $edit->ftpUsername : old('ftpUsername') !!}"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group col-md-12">
                                            <label>FTP Password</label>
                                            <input type="text" class="form-control" name="ftpPassword" value="{!! isset($edit) ? $edit->ftpPassword : old('ftpPassword') !!}"> 
                                        </div>
                                    </div>
                                </div>

                                <div id="direct" style="display: none;">
                                    <div class="form-group">
                                        <div class="input-group col-md-12">
                                            <label>Upload Script Path</label>
                                            <input type="text" class="form-control" name="scriptPath" value="{!! isset($edit) ? $edit->scriptPath : old('scriptPath') !!}"> 
                                        </div>
                                    </div>
                                </div>

                            </div>

                            
                        </div>

                        <div class="form-actions" style="border: 0; padding: 0;"></div>
                        
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->
        </div>
    </div>

   

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light ">
                
                <div class="portlet-body form">
                        <div class="form-actions">
                            <button type="submit" class="btn blue">Submit</button>
                            <button type="button" onclick="window.location.href='{!! route('admin.filenas.index') !!}'" class="btn default">Cancel</button>
                            
                        </div>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->
            
            
        </div>
        
    </div>
    
</div>
</form>
<!-- END PAGE CONTENT INNER -->
@stop

@section('page_plugin')
<script src="{!! url('assets/global/scripts/datatable.js') !!}" type="text/javascript"></script>
<script src="{!! url('assets/global/plugins/datatables/datatables.min.js') !!}" type="text/javascript"></script>
<script src="{!! url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') !!}" type="text/javascript"></script>
<script src="{!! url('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}" type="text/javascript"></script>
<script src="{!! url('/assets/global/plugins/bootbox/bootbox.min.js') !!}" type="text/javascript"></script>
@stop


@section('page_script')
<script src="{!! url('assets/pages/scripts/table-datatables-ajax.min.js') !!}" type="text/javascript"></script>
<script type="text/javascript">

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function toggleType(me){

    if( me.val() == 'remote' || me.val() == 'local' ){
        $('#remote').css('display', 'block');
        $('#ftp, #direct').css('display', 'none')

        $('#ftp input, #direct input').val('');
    } else if( me.val() == 'ftp' || me.val() == 'sftp') {
        $('#ftp').css('display', 'block');
        $('#remote, #direct').css('display', 'none')
        $('#ftp input, #remote input').val('');
    } else if( me.val() == 'direct' ) {
        $('#remote, #direct').css('display', 'block')
        $('#ftp').css('display', 'none');

        $('#ftp input').val('');
    }
}
@if( isset($edit) )
if( $('#servertype').val() != '' ) {
    toggleType($('#servertype'));
} 
@endif
</script>
@stop

