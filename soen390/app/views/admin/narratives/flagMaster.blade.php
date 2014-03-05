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
            label {
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
            th {
                font-weight: 400;
            }
            .table-spinner td {
                text-align: center;
            }
            .flag-table{
                table-layout: fixed;
                word-wrap:break-word;
            }
        </style>

        @yield('styles')
    </head>
    <body>
        <header>
            <nav class="navbar navbar-default navbar-fixed-top">
                <div class="container-fluid">
                    <a href="#" class="navbar-brand brand">You <i class="fa fa-comments"></i> Deliberate</a>
                    
                </div>
            </nav>
        </header>

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
        @yield('content')
    </body>
</html>
