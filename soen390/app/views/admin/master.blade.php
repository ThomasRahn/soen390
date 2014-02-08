<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
            h1,
            h2,
            h3,
            h4,
            h5,
            h6,
            .admin-int-text,
            .sidebar {
                font-family: "Roboto Condensed", "Helvetica Neue", Helvetica, "Arial Narrow", "Arial", sans-serif;
                letter-spacing: 0.3px;
                text-transform: uppercase;
            }
            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
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
                background-image: url('greyzz.png');
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
            }
            .nav-sidebar a:hover {
                color: #333;
                background-color: rgba(0,0,0,0.05) !important;
            }
            .nav-sidebar .active a, .nav-sidebar .active a:hover {
                color: #f5f5f5;
                background-color: rgba(0,0,0,0.5) !important;
                z-index: 1000;
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
                    <span class="navbar-right navbar-text admin-int-text">Hello, {{{ Auth::user()->name }}}! <i class="fa fa-rocket fa-fw"></i></span>
                </div>
            </nav>
        </header>

        <div class="container-fluid">
            <div class="row">
                <nav class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
                        <li{{ Request::is('admin/narrative/create') ? ' class="active"' : '' }}><a href="#"><i class="fa fa-upload fa-fw"></i> Upload Narrative(s)</a></li>
                    </ul>
                    <ul class="nav nav-sidebar">
                        <li{{ Request::is('admin') ? ' class="active"' : '' }}><a href="#"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
                        <li{{ Request::is('admin/narrative/*') ? ' class="active"' : '' }}><a href="#"><i class="fa fa-bullhorn fa-fw"></i> Narratives</a></li>
                        <li{{ Request::is('admin/category/*') ? ' class="active"' : '' }}><a href="#"><i class="fa fa-folder-open-o fa-fw"></i> Categories</a></li>
                        <li{{ Request::is('admin/flag/*') ? ' class="active"' : '' }}><a href="#"><i class="fa fa-flag-o fa-fw"></i> Flag Reports</a></li>
                        <li{{ Request::is('admin/configuration/*') ? ' class="active"' : '' }}><a href="#"><i class="fa fa-cogs fa-fw"></i> Configuration</a></li>
                    </ul>
                    <ul class="nav nav-sidebar">
                        <li><a href="{{ url('/') }}" target="_blank"><i class="fa fa-eye fa-fw"></i> Open Main Site</a></li>
                        <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out fa-fw"></i> Sign Out</a></li>
                    </ul>
                </nav>

                <section class="col-sm-9 col-md-10 col-sm-offset-3 col-md-offset-2">
                    <article>
                        @yield('content', '<h1>View not implemented.</h1>')
                    </article>

                    <footer>
                        <hr>
                        <p class="text-muted"><small>Copyright &copy; You Deliberate.</small></p>
                    </footer>
                </section>
            </div>
        </div>

        @yield('scripts')
    </body>
</html>