<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>You Deliberate: @yield('view_title', 'Administrative Interface')</title>

        <link rel="stylesheet" href="http://cdn.jsdelivr.net/bootstrap/3.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="http://cdn.jsdelivr.net/fontawesome/4.0.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Cinzel|Roboto:300,300italic,400,400italic|Roboto+Condensed:300,400,700">

        <style>
            body {
                padding-top: 70px;
                min-width: 768px !important;
                font-family: Roboto, "Helvetica Neue", Helvetica, Arial, sans-serif;
                font-weight: 300;
                font-size: 16px;
            }
            i {
                font-size: 18px;
            }
            small {
                font-weight: 300;
            }
            .btn {
                font-weight: 300;
                font-size: 16px;
            }
            h1,
            h2,
            h3,
            h4,
            h5,
            h6,
            .admin-int-text,
            .sidebar,
            button,
            label,
            input[type=submit] {
                font-family: "Roboto Condensed", "Helvetica Neue", Helvetica, "Arial Narrow", "Arial", sans-serif;
                letter-spacing: 0.3px;
                text-transform: uppercase;
            }
            h1,
            h2,
            h3,
            h4,
            h5,
            h6,
            label,
            strong {
                font-weight: 400;
            }
            .brand {
                font-family: Cinzel, Garamond, "Times New Roman", serif;
                font-weight: 400;
                -webkit-text-stroke: 0.5px;
                text-stroke: 0.5px;
                text-transform: uppercase;
            }
            .navbar .brand {
                letter-spacing: 2px;
                line-height: 25px;
            }
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                padding: 70px 0 0;
                background-color: #f0f0f0;
                background-image: url('{{ asset('img/greyzz.png') }}');
                border-right: 1px solid #e5e5e5;
                font-weight: 300;
            }
            .nav-sidebar {
                margin-right: -1px;
                margin-bottom: 20px;
            }
            .nav-sidebar i {
                margin-right: 5px;
            }
            .nav-sidebar a {
                color: #777;
                transition: 0.2s;
            }
            .nav-sidebar a:hover {
                color: #333;
                background-color: rgba(0,0,0,0.1) !important;
            }
            .nav-sidebar .active a, .nav-sidebar .active a:hover {
                color: #f5f5f5;
                background-color: rgba(0,0,0,0.5) !important;
                z-index: 1000;
            }
            .navbar-brand {
                transition: 0.2s;
            }
        </style>

        @yield('styles')

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <header>
            <nav class="navbar navbar-default navbar-fixed-top">
                <div class="container-fluid">
                    <a href="#" class="navbar-brand brand">You <i class="fa fa-comments"></i> Deliberate</a>
                    <span class="navbar-right navbar-text admin-int-text">Hello, {{{ Auth::user()->Name }}}! <i class="fa fa-rocket fa-fw"></i></span>
                </div>
            </nav>
        </header>

        <div class="container-fluid">
            <div class="row">
                <nav class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
                        <li{{ Request::is('admin/narrative/upload') ? ' class="active"' : '' }}><a href="{{ action('AdminNarrativeController@getUpload') }}"><i class="fa fa-upload fa-fw"></i> {{ trans('admin.sidebar.uploadNarratives') }}</a></li>
                    </ul>
                    <ul class="nav nav-sidebar">
                        <li{{ Request::is('admin') ? ' class="active"' : '' }}><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard fa-fw"></i> {{ trans('admin.sidebar.dashboard') }}</a></li>
                        <li{{ (Request::is('admin/narrative') && ! Request::is('admin/narrative/upload')) ? ' class="active"' : '' }}><a href="{{ action('AdminNarrativeController@getIndex') }}"><i class="fa fa-bullhorn fa-fw"></i> {{ trans('admin.sidebar.narratives') }}</a></li>
                        <li{{ Request::is('admin/category*') ? ' class="active"' : '' }}><a href="#"><i class="fa fa-folder-open-o fa-fw"></i> {{ trans('admin.sidebar.categories') }}</a></li>
                        <li{{ Request::is('admin/narrative/flag*') ? ' class="active"' : '' }}><a href="{{ action('AdminFlagController@getIndex')}}"><i class="fa fa-flag-o fa-fw"></i> {{ trans('admin.sidebar.flagReports') }}</a></li>
                        <li{{ Request::is('admin/configuration*') ? ' class="active"' : '' }}><a href="{{ action('AdminConfigController@getIndex') }}"><i class="fa fa-cogs fa-fw"></i> {{ trans('admin.sidebar.configuration') }}</a></li>
                    </ul>
                    <ul class="nav nav-sidebar">
                        <li><a href="{{ url('/') }}" target="_blank"><i class="fa fa-eye fa-fw"></i> {{ trans('admin.sidebar.openMainSite') }}</a></li>
                        <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out fa-fw"></i> {{ trans('admin.sidebar.signOut') }}</a></li>
                    </ul>
                </nav>

                <section class="col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2">
                    <article>
                        @yield('content', '<h1>View not implemented.</h1>')
                    </article>
                </section>
            </div>
        </div>

        @yield('scripts')
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-48518812-1']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
        </script>
    </body>
</html>
