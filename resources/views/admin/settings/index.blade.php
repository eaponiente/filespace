@extends('layouts.admin')
@section('page_css')
<link href="{!! url('assets/global/plugins/datatables/datatables.min.css') !!}" rel="stylesheet" type="text/css" />
<link href="{!! url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') !!}" rel="stylesheet" type="text/css" />
<link href="{!! url('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}" rel="stylesheet" type="text/css" />
@stop
@section('title', 'Settings')
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
                        <span class="caption-subject font-dark sbold uppercase">Settings</span>
                    </div>
                    <div class="actions">
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-container">
                        <div class="table-actions-wrapper">
                            <span> </span>
                            
                        </div>
                        <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Value</th>
                        <th>Free</th>
                        <th width="15%">Registered</th>
                        <th>Premium</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Max Storage (GB)</td>
                        <td>N/A</td>
                        <td><span style="color: #000; font-weight: bold;">{!! $setting->registered_user_storage / pow( 1024, 3 ) !!}</span></td>
                        <td><span style="color: #000; font-weight: bold;">{{ $setting->premium_user_storage / pow( 1024, 3 ) }}</span></td>
                        
                    </tr>
                    
                    <tr>
                        <td>Max DL Speed (Kb/sec)</td>
                        <td><span style="color: #000; font-weight: bold;">{{ $setting->free_user_max_download_speed }}</span></td>
                        <td><span style="color: #000; font-weight: bold;">{{ $setting->register_user_max_download_speed }}</span></td>
                        <td><span style="color: #000; font-weight: bold;">{{ $setting->premium_user_max_download_speed }}</span></td>
                    </tr>
                    
                    <tr>
                        <td>Download Interval (Minutes)</td>
                        <td><span style="color: #000; font-weight: bold;">{{ $setting->free_user_download_interval }}</span></td>
                        <td><span style="color: #000; font-weight: bold;">{{ $setting->register_user_download_interval }}</span></td>
                        <td>N/A</td>
                    </tr>
                    
                    <tr>
                        <td>Download Delay (Seconds)</td>
                        <td><span style="color: #000; font-weight: bold;">{{ $setting->free_users_delay }}</span></td>
                        <td><span style="color: #000; font-weight: bold;">{{ $setting->register_users_delay }}</span></td>
                        <td>N/A</td>
                    </tr>
                    <tr>
                        <td>Download Token Expire ( Hours )</td>
                        <td><span style="color: #000; font-weight: bold;">{{ $setting->free_download_token_expire_datetime }}</span></td>
                        <td><span style="color: #000; font-weight: bold;">{{ $setting->registered_download_token_expire_datetime }}</span></td>
                        <td><span style="color: #000; font-weight: bold;">{{ $setting->premium_download_token_expire_datetime }}</span></td>
                    </tr>
                </tbody>
            </table>
                        
                        <a href="{!! route('admin_settings_edit') !!}" class="btn btn-success">Edit</a>
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

