<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.6
Version: 4.5.6
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>Filespace - @yield('title')</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="{!! url('assets/global/plugins/font-awesome/css/font-awesome.min.css') !!}" rel="stylesheet" type="text/css" />
        <link href="{!! url('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') !!}" rel="stylesheet" type="text/css" />
        <link href="{!! url('assets/global/plugins/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet" type="text/css" />
        <link href="{!! url('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') !!}" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        @yield('page_css')
        <link rel="stylesheet" type="text/css" href="{!! url('assets/global/plugins/sweetalert/sweetalert.css') !!}">
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{!! url('assets/global/css/components.min.css') !!}" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{!! url('assets/global/css/plugins.min.css') !!}" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="{!! url('assets/layouts/layout3/css/layout.min.css') !!}" rel="stylesheet" type="text/css" />
        <link href="{!! url('assets/layouts/layout3/css/themes/default.min.css') !!}" rel="stylesheet" type="text/css" id="style_color" />
        <link href="{!! url('assets/layouts/layout3/css/custom.min.css') !!}" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> 
    <style type="text/css">
    .container {
        width: 100%;
    }
    .table-checkable tr > td:first-child, 
    .table-checkable tr > th:first-child {
        text-align: left;
        padding-left: 10px;
    }
    .form-control,
    .btn,
    .caption .caption-subject {
        font-size: 13px !important;
    }
    .admin-title {
        font-weight: 500;
    }
    .admin-date {
        font-size: 16px;
        text-transform: uppercase;
    }
    .admin-title,
    .admin-date {
        color: #55616F;
        margin-top: 8px;
    }
    .page-logo {
        width: 510px !important;
    }
    .form-inline {
        display: inline;
    } 
        
    </style>
    </head>
    <!-- END HEAD -->

    <body class="page-container-bg-solid">
        <!-- BEGIN HEADER -->
        <div class="page-header">
            <!-- BEGIN HEADER TOP -->
            <div class="page-header-top">
                <div class="container">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo">
                        <h2 class="admin-title">FILESPACE ADMIN PANEL</h2>
                        <h4 class="admin-date">{{ Carbon\Carbon::now('Asia/Bangkok')->format('l F j, Y - G:i') . ' BANGKOK' }}</h4>
                    </div>
                    <!-- END LOGO -->
                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a href="javascript:;" class="menu-toggler"></a>
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            
                            <li class="droddown dropdown-separator">
                                <span class="separator"></span>
                            </li>
                            
                            <!-- BEGIN USER LOGIN DROPDOWN -->
                            <li class="dropdown dropdown-user dropdown-dark">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <span class="username username-hide-mobile">{!! Auth::guard('admin')->user()->username !!}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
                                        <a href="{!! route('admin_logout') !!}">
                                            <i class="icon-key"></i> Log Out </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                            
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
            </div>
            <!-- END HEADER TOP -->
            <!-- BEGIN HEADER MENU -->
            <div class="page-header-menu">
                <div class="container" style="width: 100%;">
                    
                    <!-- BEGIN MEGA MENU -->
                    <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
                    <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
                    <div class="hor-menu  ">
                        <ul class="nav navbar-nav">
                            <li class="menu-dropdown classic-menu-dropdown {!! Request::segment(2) == 'agents' ? 'active' : '' !!}">
                                <a href=""> DASHBOARD
                                    <span class="arrow"></span>
                                </a>
                            </li>
                            <li class="menu-dropdown classic-menu-dropdown {!! Request::segment(2) == 'users' ? 'active' : '' !!}">
                                <a href="{!! route('admin.users.index') !!}"> USERS
                                    <span class="arrow"></span>
                                </a>
                            </li>

                            <li class="menu-dropdown classic-menu-dropdown {!! Request::segment(2) == 'ipbanned' ? 'active' : '' !!}">
                                <a href="{!! route('admin.ipbanned.index') !!}"> IP ADDRESS BANNED
                                    <span class="arrow"></span>
                                </a>
                            </li>

                            <li class="menu-dropdown classic-menu-dropdown {!! Request::segment(2) == 'countries-banned' ? 'active' : '' !!}">
                                <a href="{!! route('admin.countriesban.index') !!}"> COUNTRIES BANNED
                                    <span class="arrow"></span>
                                </a>
                            </li>


                            
                            <li class="menu-dropdown classic-menu-dropdown {!! Request::segment(2) == 'store-view' ? 'active' : '' !!}">
                                <a href="javascript:;"> VOUCHERS
                                    <span class="arrow"></span>
                                </a>
                                <ul class="dropdown-menu pull-left">
                                    <li class=" ">
                                        <a href="{!! route('admin.vouchers.index') !!}" class="nav-link"> VOUCHERS </a>
                                    </li>
                                    <li class=" ">
                                        <a href="{!! route('admin.resellers.index') !!}" class="nav-link"> RESELLERS </a>
                                    </li>
                                   
                                </ul>
                            </li>
                            <li class="menu-dropdown classic-menu-dropdown {!! Request::segment(2) == 'fileserver' ? 'active' : '' !!}">
                                <a href="{!! route('admin.fileserver.index') !!}"> FILE SERVERS
                                    <span class="arrow"></span>
                                </a>
                            </li>


                            <li class="menu-dropdown classic-menu-dropdown {!! Request::segment(2) == 'filenas' ? 'active' : '' !!}">
                                <a href="{!! route('admin.filenas.index') !!}"> FILE NAS
                                    <span class="arrow"></span>
                                </a>
                            </li>

                            <li class="menu-dropdown classic-menu-dropdown {!! Request::segment(2) == 'store-view' ? 'active' : '' !!}">
                                <a href="javascript:;"> UPLOADS
                                    <span class="arrow"></span>
                                </a>
                                <ul class="dropdown-menu pull-left">
                                    <li class=" ">
                                        <a href="{!! route('admin.fileuploads.index') !!}" class="nav-link"> UPLOADS </a>
                                    </li>
                                    <li class=" ">
                                        <a href="{!! route('admin.downloadlogs.index') !!}" class="nav-link"> DOWNLOAD LOGS </a>
                                    </li>
                                    <li class=" ">
                                        <a href="" class="nav-link"> GLOBAL STATS </a>
                                    </li>
                                   
                                </ul>
                            </li>

                            <li class="menu-dropdown classic-menu-dropdown {!! Request::segment(2) == 'store-view' ? 'active' : '' !!}">
                                <a href="javascript:;"> SETTINGS
                                    <span class="arrow"></span>
                                </a>
                                <ul class="dropdown-menu pull-left">
                                    <li class=" ">
                                        <a href="{!! route('admin_settings') !!}" class="nav-link"> USERS LIMIT </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="menu-dropdown classic-menu-dropdown {!! Request::segment(2) == 'agents' ? 'active' : '' !!}">
                                <a href="{!! route('admin.abuses.index') !!}"> ABUSES
                                    <span class="arrow"></span>
                                </a>
                            </li>

                        </ul>
                    </div>
                    <!-- END MEGA MENU -->
                </div>
            </div>
            <!-- END HEADER MENU -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <!-- BEGIN PAGE HEAD-->
                <div class="page-head">
                    <div class="container">
                        
                        <!-- BEGIN PAGE TOOLBAR -->
                        <div class="page-toolbar">
                            <!-- BEGIN THEME PANEL -->
                            <div class="btn-group btn-theme-panel">
                                
                            </div>
                            <!-- END THEME PANEL -->
                        </div>
                        <!-- END PAGE TOOLBAR -->
                    </div>
                </div>
                <!-- END PAGE HEAD-->
                <!-- BEGIN PAGE CONTENT BODY -->
                <div class="page-content">
                    <div class="container">
                        <!-- BEGIN PAGE BREADCRUMBS -->
                        <ul class="page-breadcrumb breadcrumb">
                            <li>
                                <a href="{!! route('admin_login') !!}">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>@yield('title')</span>
                            </li>
                        </ul>
                        <!-- END PAGE BREADCRUMBS -->
                        
                        <!-- BEGIN PAGE CONTENT INNER -->
                            @yield('content')
                        <!-- END PAGE CONTENT INNER -->
                    </div>
                </div>
                <!-- END PAGE CONTENT BODY -->
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
            
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        
        <!-- BEGIN INNER FOOTER -->
        <div class="page-footer">
            <div class="container"> {!! date('Y') !!} &copy; Filespace
            </div>
        </div>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
        <!-- END INNER FOOTER -->
        <!-- END FOOTER -->
        <!--[if lt IE 9]>
<script src="{!! url('assets/global/plugins/respond.min.js') !!}"></script>
<script src="{!! url('assets/global/plugins/excanvas.min.js') !!}"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="{!! url('assets/global/plugins/jquery.min.js') !!}" type="text/javascript"></script>
        <script src="{!! url('assets/global/plugins/bootstrap/js/bootstrap.min.js') !!}" type="text/javascript"></script>
        <script src="{!! url('assets/global/plugins/js.cookie.min.js') !!}" type="text/javascript"></script>
        <script src="{!! url('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') !!}" type="text/javascript"></script>
        <script src="{!! url('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') !!}" type="text/javascript"></script>
        <script src="{!! url('assets/global/plugins/jquery.blockui.min.js') !!}" type="text/javascript"></script>
        <script src="{!! url('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') !!}" type="text/javascript"></script>
        <script src="{!! url('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        @yield('page_plugin')
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{!! url('assets/global/scripts/app.min.js') !!}" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{!! url('assets/global/plugins/sweetalert/sweetalert.min.js') !!}" type="text/javascript"></script>
        @yield('page_script')
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{!! url('assets/layouts/layout3/scripts/layout.min.js') !!}" type="text/javascript"></script>
        <script src="{!! url('assets/layouts/layout3/scripts/demo.min.js') !!}" type="text/javascript"></script>
        <script src="{!! url('assets/layouts/global/scripts/quick-sidebar.min.js') !!}" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
    </body>

</html>