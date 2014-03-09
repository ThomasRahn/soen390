<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>You Deliberate Player</title>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap/3.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//cdn.jsdelivr.net/fontawesome/4.0.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Cinzel|Roboto:300,300italic,400,400italic|Roboto+Condensed:300,400,700">
        <style>
            body {
                width: 640px;
                height: 650px;
                font-family: Roboto, "Helvetica Neue", Helvetica, Arial, sans-serif;
                font-weight: 400;
                padding: 10px 40px;
                background-image: url("{{ asset('img/exclusive_paper.png') }}");
            }
            .brand {
                font-family: Cinzel, Garamond, "Times New Roman", serif;
                font-weight: 400;
                font-size: 18px;
                line-height: 25px;
                text-transform: uppercase;
                letter-spacing: 2px;
                padding-bottom: 10px;
                color: #5e5e5e;
                -webkit-text-stroke: 0.5px;
                text-stroke: 0.5px;
            }
            .brand-header {
                text-align: center;
                padding-top: 5px;
                padding-bottom: 15px;
            }
            .image-view {
                height: 480px;
                background-color: #888;
                background-image: url("http://i.imgur.com/g3pReUF.png");
                background-position: center center;
                background-size: contain;
                background-repeat: no-repeat;
                box-shadow: 0 0 3px 1px #333 inset;
                -webkit-transition-duration: 0.5s;
                transition-duration: 0.5s;
            }
            .overlay {
                width: 100%;
                height: 100%;
                background-image: url("{{ asset('img/filt.png') }}");
                opacity: 0.07;
            }
            .player-footer {
                margin-top: 15px;
            }
            .progress-container {
                position: absolute;
                margin-top: 3px;
                width: 560px;
                height: 10px;
                background-color: rgba(128,128,128,0.25);
                border-radius: 2px;
                box-shadow: 0 0 2px 0 #888 inset;
                z-index: 3;
            }
            .progress-bar {
                background-color: #555;
                border-radius: 2px;
                -webkit-transition-duration: 0.6s;
                transition-duration: 0.6s;
            }
            .progress-time {
                font-family: "Roboto Condensed", "Arial Narrow", "Helvetica Neue", Helvetica, Arial, sans-serif;
                font-size: 14px;
                font-weight: 400;
            }
            .end-time {
                position: absolute;
                right: 40px;
            }
            .controls {
                text-align: center;
                margin-top: 25px;
            }
            .btn-group {
                padding-top: 3px;
            }
            .playback-btn {
                width: 50px;
                height: 50px;
                margin-top: -8px;
                border-radius: 6px !important;
                -webkit-transition-duration: 1s;
                transition-duration: 1s;
                z-index: 3;
            }
            .player {
                display: none;
            }
            .progress-super-container {
                height: 17px;
            }
            .track-indicators {
                height: 100%;
                border-radius: 5px;
                box-sizing: border-box;
            }
            .track-indicator {
                height: 100%;
                padding: 0;
                margin: 0;
                margin-left: -1px;
                position: relative;
                float: left;
                border-left: 2px solid #888;
            }
        </style>
    </head>

    <body>
        <div class="container-fluid polaroid">
            <header class="row brand-header">
                <span class="brand">You <i class="fa fa-comments"></i> Deliberate</span>
            </header>

            <article class="row image-view">
                <div class="overlay"></div>
            </article>

            <footer class="row player-footer">
                <span class="begin-time progress-time">0:00</span>
                <span class="end-time progress-time">0:00</span>

                <div class="progress-super-container">
                    <div class="progress-container">
                        <div class="progress-bar"></div>
                    </div>
                    <div class="track-indicators">
                    </div>
                </div>

                <article class="controls">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default back-btn"><i class="fa fa-backward fa-fw"></i></button>
                        <button type="button" class="btn btn-default playback-btn play-btn"><i class="fa fa-play fa-fw"></i></button>
                        <button type="button" class="btn btn-default forward-btn"><i class="fa fa-forward fa-fw"></i></button>
                    </div>
                </article>
            </footer>

            <audio id="player" class="player">
                <source id="player-mp3-src" src="" type="audio/mpeg">
                <source id="player-oga-src" src="" type="audio/vorbis">
            </audio>
        </div>

        <!-- Scripts -->
        <script src="//cdn.jsdelivr.net/jquery/2.1.0/jquery.min.js"></script>
        <script src="//cdn.jsdelivr.net/bootstrap/3.1.0/js/bootstrap.min.js"></script>
        <script src="{{ asset('js/player.js') }}"></script>
        <script>
            $(document).ready(function() {
                // Prepare the player with the JSON API path to the
                // narrative resource.

                preparePlayer("{{ $apiPath }}");
            });
        </script>
    </body>
</html>