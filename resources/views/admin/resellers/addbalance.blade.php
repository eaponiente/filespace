@extends('layouts.admin')
@section('page_css')
<link href="{!! url('assets/global/plugins/datatables/datatables.min.css') !!}" rel="stylesheet" type="text/css" />
<link href="{!! url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') !!}" rel="stylesheet" type="text/css" />
<link href="{!! url('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}" rel="stylesheet" type="text/css" />
@stop
@section('content')
@section('title',  'Add Balance')
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

  <form role="form" method="POST" action="{!! route('reseller_add_balance', [$edit->id]) !!}">    
    
    {!! csrf_field() !!}
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light ">
                
                <div class="portlet-body form">
                        <div class="form-body">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group col-md-12">
                                        <label>Amount</label>
                                        <input type="text" class="form-control" name="amount" value="{!! old('amount') !!}"> 
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group col-md-12">
                                        <label>Status</label>
                                        <select class="form-control" name="funding_note">
                                            @foreach(config('constants.resellers.funding_note') as $key => $val)
                                                <option value="{!! $val !!}">{!! $val !!}</option>
                                            @endforeach
                                        </select>
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


