<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>You Deliberate: @yield('view_title', 'Authentication')</title>

        <link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap/3.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//cdn.jsdelivr.net/fontawesome/4.0.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Cinzel|Roboto:300,400|Roboto+Condensed:300">

        <style>
            body {
                background-color: #f8f8f8;
                font-family: Roboto, "Helvetica Neue", Helvetica, Arial, sans-serif;
                font-weight: 300;
            }
            header {
                text-align: center;
            }
            .brand {
                letter-spacing: 2px;
                font-family: Cinzel, Garamond, "Times New Roman", serif;
                font-weight: 400;
                font-size: 32px;
                -webkit-text-stroke: 0.5px;
                text-stroke: 0.5px;
                text-transform: uppercase;
                color: #777;
            }
            .auth-container {
                position: absolute;
                width: 386px;
                min-height: 316px;
                top: 48%;
                left: 50%;
                margin-top: -158px;
                margin-left: -193px;
            }
            .auth-container header {
                padding: 0 20px 5px 20px;
                margin-bottom: 20px;
                border-bottom: 1px solid #e7e7e7;
            }
            .auth-container section {
                padding-left: 20px;
                padding-right: 20px;
            }
            button {
                font-family: "Roboto Condensed", "Helvetica Neue", Helvetica, "Arial Narrow", "Arial", sans-serif;
                font-size: 16px;
                text-transform: uppercase;
                font-weight: 300;
            }
            label {
                font-weight: 300;
            }
        </style>
        
        @yield('styles')
    </head>

    <body>
        <article class="auth-container">
            <header>
                <h1 class="brand">You <i class="fa fa-comments"></i> Deliberate</h1>
            </header>

            <section>
                @yield('content')
            </section>
        </article>

        <script src="//cdn.jsdelivr.net/jquery/2.1.0/jquery.min.js"></script>
        <script src="//cdn.jsdelivr.net/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    </body>
</html>
