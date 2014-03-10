<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap/3.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//cdn.jsdelivr.net/fontawesome/4.0.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Cinzel|Roboto:300,300italic,400,400italic|Roboto+Condensed:300,400,700">
        <style>
            body {
                padding: 10px;
                background-color: rgba(255,255,255,0.5);
                font-family: Roboto, "Helvetica Neue", Helvetica, Arial, sans-serif;
                font-weight: 400;
            }
            h1,h2,h3,h4,legend,.btn {
                font-family: "Roboto Condensed", "Arial Narrow", "Helvetica Neue", Helvetica, Arial, sans-serif;
                font-weight: 300;
                text-transform: uppercase;
            }
            .media-heading {
                font-weight: 400;
            }
        </style>
    </head>
    <body>
        <ul class="media-list empty-comment">
            <li class="media">
                <div class="media-body">
                    <p>There are currently no comments on this narrative.</p>
                </div>
            </li>
        </ul>

        <!-- Scripts -->
        <script src="//cdn.jsdelivr.net/jquery/2.1.0/jquery.min.js"></script>
        <script src="//cdn.jsdelivr.net/bootstrap/3.1.0/js/bootstrap.min.js"></script>
        <script src="{{ asset('js/player_comments.js') }}"></script>
        <script>
            $(document).ready(function() {
                prepareComments("{{ $apiPath }}");
            });
        </script>
    </body>
</html>