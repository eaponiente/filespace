@extends('layouts.admin')
@section('page_css')
<link href="{!! url('assets/global/plugins/datatables/datatables.min.css') !!}" rel="stylesheet" type="text/css" />
<link href="{!! url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') !!}" rel="stylesheet" type="text/css" />
<link href="{!! url('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}" rel="stylesheet" type="text/css" />
@stop
@section('title', (isset($edit) ? 'Edit ' : 'Add ') . 'Ban Country')
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

  <form role="form" method="POST" action="{!! isset($edit) ? route('admin.countriesban.update', [$edit->id]) : route('admin.countriesban.store') !!}">    
    
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
                                        <label>Country</label>
                                        <select class="form-control" name="id">
                                            @foreach($countries as $country)
                                            <option value="{!! $country->id !!}">{!! $country->full_name !!}</option>
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
                            <button type="button" onclick="window.location.href='{!! route('admin.countriesban.index') !!}'" class="btn default">Cancel</button>
                            
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

@if(isset($edit))
$(document).ready(function() {
    $('#delete').click(function(){
        bootbox.confirm("Are you sure?", function(result) {
           if( result ) {
            window.location.href = '{!! route('location_area_delete', [$edit->id]) !!}';
           }
        }); 
    });
})
@endif


</script>
@stop

