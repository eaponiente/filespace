<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="google-site-verification" content="L-rdG4kRohAhIAaZXqWfYhYsO43JRqy2d4A8p9V2heA" />
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8">            
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{ url('img/favicon.ico') }}">
    <title>Filespace - @yield('title')</title>
    <link rel="stylesheet" type="text/css" href="{!! url('css/bootstrap.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! url('css/filespace.css') !!}">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
          <![endif]-->
        <script type="text/javascript" src="{!! url('js/jquery-1.11.0.min.js') !!}"></script>
        <script type="text/javascript" src="{!! url('js/bootstrap.min.js') !!}"></script>

          @yield('metadata')
      </head>

        <body> 

        <div class="wrapper">
            <!-- HEADER -->
            <div class='header'>
                <div class='site-holder'>
                    <div class='header-top'>
                        <div class='logo pull-left'>
                            <a href="{!! url('/') !!}">
                            <img src="{!! url('img/logo-beta.png') !!}"></a>                           
                        </div>
                        @include('layouts.partials.info')

                        <div class='header-buttons pull-right'>
                            @include('layouts.partials.settings')
                        </div>
                        <div class='clearfix'></div>
                    </div>
                    <div class='header-bottom'>
                        <span>Upload</span> your files to the cloud and <span>retrieve</span> them any time you like
                    </div>
                </div>
            </div>
            <div class='site-holder'>

                

                    @include('layouts.partials.nav')

                <div class="clearfix"></div>

                @yield('content')

            </div>

            <div class="push"></div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="modal_tos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    @include('front.modals.tos')
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="modal_ipp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    @include('front.modals.ipp')
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal_pp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    @include('front.modals.pp')
                </div>
            </div>
        </div>

        <div class="footer">
            <div class='container'>
                <div class='footer-holder'>
                    <div class="footer-menu">
                        <ul>
                            <li><a data-toggle="modal" href="pages/new/tos.php" data-target="#modal_tos">Terms of Service</a></li>
                            <li><a data-toggle="modal" href="pages/new/ipp.php" data-target="#modal_ipp">Intellectual Property</a></li>
                            <li><a data-toggle="modal" href="pages/new/pp.php" data-target="#modal_pp">Privacy Policy</a></li>
                            <li><a href="{{ url('abuse') }}">Report Abuse</a></li>
                            <li><a href="{{ url('contact-us') }}">Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="footer-copyright">
                        © {!! date('Y') !!} FileSpace.io, All Rights Reserved.
                    </div>
                </div>
            </div>
        </div>
        <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-63158318-1', 'auto');
  ga('send', 'pageview');

</script>
        

    </body>
    </html>
