@extends('layouts.admin')
@section('page_css')
<link href="{!! url('assets/global/plugins/datatables/datatables.min.css') !!}" rel="stylesheet" type="text/css" />
<link href="{!! url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') !!}" rel="stylesheet" type="text/css" />
<link href="{!! url('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}" rel="stylesheet" type="text/css" />
@stop
@section('content')
@section('title', (isset($edit) ? 'Edit ' : 'Add ') . 'Resellers')
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

  <form role="form" method="POST" action="{!! isset($edit) ? route('admin.resellers.update', [$edit->id]) : route('admin.resellers.store') !!}">    
    
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
                                        <label>Username</label>
                                        <input type="text" class="form-control" name="username" value="{!! isset($edit) ? $edit->username : old('username') !!}"> 
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group col-md-12">
                                        <label>Email</label>
                                        <input type="text" class="form-control" name="email" value="{!! isset($edit) ? $edit->email : old('email') !!}"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group col-md-12">
                                        <label>Status</label>
                                        <select class="form-control" name="status">
                                            @foreach(config('constants.resellers.status') as $key => $val)
                                                <option value="{!! $val !!}"{!! isset($edit) && $val == $edit->status ? 'selected' : '' !!}>{!! ucfirst($val) !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group col-md-12">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="password" > 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group col-md-12">
                                        <label>Repeat Password</label>
                                        <input type="password" class="form-control" name="password_confirmation"> 
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group col-md-12">
                                        <label>Discount</label>
                                        <input type="text" class="form-control" name="discount_rate" value="{!! isset($edit) ? $edit->discount_rate : old('discount_rate') !!}"> 
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
                            <button type="button" onclick="window.location.href='{!! route('admin.resellers.index') !!}'" class="btn default">Cancel</button>
                            
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

@stop

