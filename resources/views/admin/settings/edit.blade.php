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
                        <form method="POST" action="{!! route('admin_settings_edit') !!}">
                        {!! csrf_field() !!}
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Value</th>
                                    <th>Free</th>
                                    <th>Registered</th>
                                    <th>Premium</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Max Storage (<strong><em>GB</em></strong>)</td>
                                    <td>N/A</td>
                                    <td><input type="text" class="form-control" name="settings[registered_user_storage]" value="{{ $settings->registered_user_storage / pow( 1024, 3 ) }}"></td>
                                    <td><input type="text" class="form-control" name="settings[premium_user_storage]" value="{{ $settings->premium_user_storage / pow( 1024, 3 ) }}"></td>
                                </tr>
                                
                                <tr>
                                    <td>Max DL Speed (<strong><em>Kb/sec</em></strong>)</td>
                                    <td><input type="text" class="form-control" name="settings[free_user_max_download_speed]" value="{{ $settings->free_user_max_download_speed }}"></td>
                                    <td><input type="text" class="form-control" name="settings[register_user_max_download_speed]" value="{{ $settings->register_user_max_download_speed }}"></td>
                                    <td><input type="text" class="form-control" name="settings[premium_user_max_download_speed]" value="{{ $settings->premium_user_max_download_speed }}"></td>
                                </tr>
                                
                                <tr>
                                    <td>Download Interval (<strong><em>Minutes</em></strong>)</td>
                                    <td><input type="text" class="form-control" name="settings[free_user_download_interval]" value="{{ $settings->free_user_download_interval }}"></td>
                                    <td><input type="text" class="form-control" name="settings[register_user_download_interval]" value="{{ $settings->register_user_download_interval }}"></td>
                                    <td>N/A</td>
                                </tr>
                                
                                <tr>
                                    <td>Download Delay (<strong><em>Seconds</em></strong>)</td>
                                    <td><input type="text" class="form-control" name="settings[free_users_delay]" value="{{ $settings->free_users_delay }}"></td>
                                    <td><input type="text" class="form-control" name="settings[register_users_delay]" value="{{ $settings->register_users_delay }}"></td>
                                    <td>N/A</td>
                                </tr>
                                <tr>
                                    <td>Download Token Expire (<strong><em>Hours</em></strong>)</td>
                                    <td><input type="text" class="form-control" name="settings[free_download_token_expire_datetime]" value="{{ $settings->free_download_token_expire_datetime }}"></td>
                                    <td><input type="text" class="form-control" name="settings[registered_download_token_expire_datetime]" value="{{ $settings->registered_download_token_expire_datetime }}"></td>
                                    <td><input type="text" class="form-control" name="settings[premium_download_token_expire_datetime]" value="{{ $settings->premium_download_token_expire_datetime }}"></td>
                                </tr>   
                            </tbody>
                        </table>
                        <input type="submit" value="Update Settings" class="btn btn-success" />
                        </form>
                        
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

