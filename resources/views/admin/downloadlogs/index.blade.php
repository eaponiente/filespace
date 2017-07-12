@extends('layouts.admin')
@section('page_css')
<link href="{!! url('assets/global/plugins/datatables/datatables.min.css') !!}" rel="stylesheet" type="text/css" />
<link href="{!! url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') !!}" rel="stylesheet" type="text/css" />
<link href="{!! url('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}" rel="stylesheet" type="text/css" />
@stop
@section('title', 'Downloads')
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
                        <span class="caption-subject font-dark sbold uppercase">Downloads</span>
                    </div>
                    <div class="actions">
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-container">
                        <div class="table-actions-wrapper">
                            <span> </span>
                            
                        </div>
                        <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax" data-source="{!! route('downloadlogs_listings') !!}" data-token="{!! csrf_token() !!}">
                            <thead>
                                <tr role="row" class="heading">
                                    <th width="12%">Date and Time</th>
                                    <th width="18%">Filename</th>
                                    <th>Uploaded By</th>
                                    <th>Downloaded By</th>
                                    <th>Download IP(Country)</th>
                                    <th>Completed(KB/sec)</th>
                                    <th width="15%">Referring URL</th>
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

@stop

