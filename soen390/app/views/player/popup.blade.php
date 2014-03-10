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
                font-family: Roboto, "Helvetica Neue", Helvetica, Arial, sans-serif;
                font-weight: 400;
                padding: 10px;
                background-image: url("{{ asset('img/exclusive_paper.png') }}");
                overflow-x: hidden;
            }
            ::-webkit-scrollbar {
                width: 7px;
            }

            ::-webkit-scrollbar-track {
                -webkit-box-shadow: inset 0 0 6px rgb(96,96,96);
                background-color: #fff;
            }

            ::-webkit-scrollbar-thumb {
                background: rgba(0,0,0,0.6);
            }

            ::-webkit-scrollbar-thumb:hover {
                background: rgba(0,0,0,0.5);
            }

            ::-webkit-scrollbar-thumb:active {
                background: rgba(0,0,0,0.3);
            }
            h1,h2,h3,h4,legend,.btn {
                font-family: "Roboto Condensed", "Arial Narrow", "Helvetica Neue", Helvetica, Arial, sans-serif;
                font-weight: 300;
                text-transform: uppercase;
            }
            legend {
                font-size: 20px;
            }
            .brand {
                font-family: Cinzel, Garamond, "Times New Roman", serif;
                font-weight: 400;
                font-size: 18px;
                line-height: 25px;
                text-transform: uppercase;
                letter-spacing: 2px;
                padding-bottom: 5px;
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
                height: 450px;
                background-color: #888;
                background-image: url("{{ asset('img/default_narrative.jpg') }}");
                background-position: center center;
                background-size: contain;
                background-repeat: no-repeat;
                box-shadow: 0 0 3px 1px #333 inset;
                -webkit-transition-duration: 0.5s;
                -moz-transition-duration: 0.5s;
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
                position: relative;
                margin-top: 2px;
                margin-right: -15px;
                width: 100%;
                height: 15px;
                background-color: rgba(128,128,128,0.25);
                border-radius: 2px;
                box-shadow: 0 0 2px 0 #888 inset;
                z-index: 3;
            }
            .progress-bar {
                background-color: #555;
                border-radius: 2px;
                -webkit-transition-duration: 0.6s;
                -moz-transition-duration: 0.6s;
                transition-duration: 0.6s;
            }
            .progress-time {
                font-family: "Roboto Condensed", "Arial Narrow", "Helvetica Neue", Helvetica, Arial, sans-serif;
                font-size: 14px;
                font-weight: 400;
            }
            .end-time {
                position: absolute;
                right: 15px;
            }
            .controls {
                text-align: center;
                margin-top: 25px;
                margin-bottom: 20px;
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
                -moz-transition-duration: 1s;
                transition-duration: 1s;
                z-index: 3;
            }
            .player {
                display: none;
            }
            .progress-super-container {
                height: 22px;
            }
            .track-indicators {
                position: relative;
                top: -18px;
                height: 100%;
                border-radius: 5px;
                box-sizing: border-box;
                z-index: 2;
            }
            .track-indicator {
                height: 100%;
                padding: 0;
                margin: 0;
                margin-left: -1px;
                position: relative;
                float: left;
                border-left: 1px solid #8c8c8c;
                z-index: 2;
            }
            .comment-frame {
                width: 100%;
                min-height: 340px;
                bottom: 10px;
                padding: 0;
                margin: 15px 0;
                box-shadow: 0 0 3px 1px #555 inset;
            }
            .vote-btn-group, .tertiary-btn-group {
                margin-top: -8px;
                opacity: 0.2;
            }
            .player-control-btn-group {
                margin-left: 40px;
                margin-right: 40px;
            }
            .comments-fieldset legend {
                text-align: right;
            }
        </style>
    </head>

    <body>
        <div class="container-fluid">
            <div class="row">
                <header class="row brand-header">
                    <span class="brand">You <i class="fa fa-comments"></i> Deliberate</span>
                </header>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <article class="image-view">
                        <div class="overlay"></div>
                    </article>

                    <footer class="player-footer">
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
                            <div class="btn-group vote-btn-group" data-toggle="tooltip" title="You must view the narrative before you can vote.">
                                <button type="button" class="btn btn-default agree-btn" disabled="disabled">
                                    <i class="fa fa-thumbs-up fa-fw"></i>
                                </button>
                                <button type="button" class="btn btn-default disagree-btn" disabled="disabled">
                                    <i class="fa fa-thumbs-down fa-fw"></i>
                                </button>
                            </div>

                            <div class="btn-group player-control-btn-group">
                                <button type="button" class="btn btn-default back-btn">
                                    <i class="fa fa-backward fa-fw"></i>
                                </button>
                                <button type="button" class="btn btn-default playback-btn play-btn">
                                    <i class="fa fa-play fa-fw"></i>
                                </button>
                                <button type="button" class="btn btn-default forward-btn">
                                    <i class="fa fa-forward fa-fw"></i>
                                </button>
                            </div>

                            <div class="btn-group tertiary-btn-group" data-toggle="tooltip" title="You must view the narrative before you can report or share.">
                                <button type="button" class="btn btn-default flag-btn" disabled="disabled">
                                    <i class="fa fa-warning fa-fw"></i>
                                </button>
                                <button type="button" class="btn btn-default share-btn" disabled="disabled">
                                    <i class="fa fa-mail-forward fa-fw"></i>
                                </button>
                            </div>
                        </article>
                    </footer>

                    <audio id="player" class="player">
                        <source id="player-mp3-src" src="" type="audio/mpeg">
                        <source id="player-oga-src" src="" type="audio/vorbis">
                    </audio>
                </div>

                <div class="col-sm-6">
                    {{ Form::open(array('class' => 'form-horizontal comment-form')) }}
                        <fieldset class="comments-fieldset">
                            <legend>Discuss This Narrative</legend>

                            <div class="form-group">
                                <label for="name" class="col-xs-1 control-label"><i class="fa fa-fw fa-user"></i></label>

                                <div class="col-xs-11">
                                    {{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Your Name')) }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="comment" class="col-xs-1 control-label"><i class="fa fa-fw fa-comment"></i></label>

                                <div class="col-xs-11">
                                    {{ Form::textarea('comment', null, array('class' => 'form-control', 'rows' => '3', 'placeholder' => 'Your Comments')) }}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-11 col-xs-offset-1">
                                    {{ Form::submit('Post Comment', array('class' => 'btn btn-primary btn-sm')) }}
                                    {{ Form::button('Clear', array('type' => 'reset', 'class' => 'btn btn-default btn-sm')) }}
                                </div>
                            </div>
                        </fieldset>
                    {{ Form::close() }}

                    <iframe class="comment-frame" src="{{ $commentFramePath }}" seamless></iframe>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="//cdn.jsdelivr.net/jquery/2.1.0/jquery.min.js"></script>
        <script src="//cdn.jsdelivr.net/bootstrap/3.1.0/js/bootstrap.min.js"></script>
        <script src="{{ asset('js/player.js') }}"></script>
        <script>
            $(document).ready(function() {
                // Enable tooltips
                $("div").tooltip();

                // Prepare the player with the JSON API path to the
                // narrative resource.
                preparePlayer("{{ $apiPath }}");
            });
        </script>
    </body>
</html>