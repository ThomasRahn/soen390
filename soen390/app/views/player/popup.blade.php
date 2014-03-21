<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>You Deliberate Player</title>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap/3.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//cdn.jsdelivr.net/fontawesome/4.0.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Cinzel|Roboto:300,300italic,400,400italic,500|Roboto+Condensed:300,400,700">
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
            textarea {
                resize: vertical;
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
                height: 320px;
                bottom: 10px;
                padding: 10px;
                margin: 15px 0;
                border-radius: 6px;
                background-color: rgba(255,255,255,0.5);
                overflow-y: scroll;
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
            .empty-comments {
                text-align: center;
            }
            .comment-post-result {
                padding-right: 20px;
            }
            .flag-link {
                margin-left: 5px;
                color: #555;
            }
            .flag-link:hover {
                color: #800;
            }
            .media-heading {
                text-transform: none;
                font-family: Roboto, "Helvetica Neue", Helvetica, Arial, sans-serif;
                font-weight: 500;
            }
            .media-heading small {
                font-family: "Roboto Condensed", "Arial Narrow", "Helvetica Neue", Helvetica, Arial, sans-serif;
                font-size: 80%;
                font-weight: 300;
                text-transform: uppercase;
                letter-spacing: 0.3px;
                margin-left: 5px;
                color: #aaa;
            }
            .media-footer {
                margin: 5px 0 10px;
                font-size: 12px;
                font-weight: 300;
                font-family: "Roboto Condensed", "Arial Narrow", "Helvetica Neue", Helvetica, Arial, sans-serif;
                text-transform: uppercase;
            }
            .media-footer a {
                margin: 0 6px;
                color: #aaa;
            }
            .media-footer a:first-of-type {
                margin-left: 0;
            }
            .media .media {
                margin: 10px 0 0 10px;
                padding: 10px 0 0 10px;
                border-left: 2px solid #e5e5e5;
            }
            .voted {
                color: #333 !important;
            }

            @media (max-width: 768px) {
                .comment-frame {
                    overflow-y: visible;
                    height: auto;
                }
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
                            <div class="btn-group vote-btn-group" data-toggle="tooltip" title="You may vote after viewing the narrative.">
                                <button type="button" class="btn btn-default agree-btn" id="agree" onclick="expressOpinion(1, this)" disabled="disabled" data-toggle="tooltip" title="Agree with this narrative.">
                                    <i class="fa fa-thumbs-up fa-fw"></i>
                                </button>
                                <button type="button" class="btn btn-default disagree-btn" id="disagree" onclick="expressOpinion(2, this)" disabled="disabled" data-toggle="tooltip" title="Disagree with this narrative.">
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

                            <div class="btn-group tertiary-btn-group" data-toggle="tooltip" title="You may report and/or share after viewing the narrative.">
                                <button type="button" class="btn btn-default flag-btn" disabled="disabled" title="Report this narrative." data-toggle="modal" data-target="#report-narrative">
                                    <i class="fa fa-flag fa-fw"></i>
                                </button>
                                <button type="button" class="btn btn-default share-btn" disabled="disabled" data-toggle="tooltip" title="Share this narrative.">
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
                                <div class="col-xs-12">
                                    {{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Name (Optional)')) }}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12">
                                    {{ Form::textarea('comment', null, array('class' => 'form-control', 'rows' => '3', 'placeholder' => 'Comments', 'required' => 'required')) }}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12">
                                    <div class="pull-right">
                                        <span class="comment-post-result"></span>
                                        {{ Form::submit('Post Comment', array('class' => 'btn btn-primary btn-sm')) }}
                                        {{ Form::button('Clear', array('type' => 'reset', 'class' => 'btn btn-default btn-sm')) }}
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    {{ Form::close() }}

                    <div class="comment-frame">
                        <div class="media placeholder-comment">
                            <div class="media-body">
                                <p class="lead"><i class="fa fa-spin fa-spinner"></i> Loading comments...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="report-narrative">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Report an inappropriate narrative</h4>
                    </div>

                    <div class="modal-body">
                        <form id="narrative-report-form">
                            {{ Form::token("crsf_token") }}

                            <div class="form-group">
                                {{ Form::label("report-comment", "I am reporting this narrative because,", array("class" => "control-label")) }}
                                {{ Form::textarea("report-comment", null, array("class" => "form-control", "required" => "required")) }}
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="report-submit-btn">Send Report</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="share-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Share this narrative</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <input type="text" class="form-control text-center" id="href-text">
                                <br>
                                <p class="text-center text-muted">You can share this narrative by giving out the link above.<br>Copy by selecting the link and pressing <code>Ctrl + C</code> or <code> &#8984; + C</code>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="subcomment-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Reply to comment</h4>
                    </div>

                    <div class="modal-body">
                        <blockquote class="parent-comment-content">
                            <div class="parent-comment-body">This is a sample comment.</div>
                            <footer class="parent-comment-name"><cite title="23 days ago">John Smith</cite></footer>
                        </blockquote>

                        <hr>

                        <form class="form-horizontal" id="subcomment-form">
                            {{ Form::token() }}
                            <input type="hidden" name="parent" value="">

                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1">
                                    <input type="text" name="name" class="form-control" placeholder="Nom/Name (Optionnel/Optional)">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1">
                                    <textarea name="comment" class="form-control" placeholder="Commentaire/Comments" rows="5"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1 text-right">
                                    <button type="submit" class="btn btn-primary">R&eacute;pondre/Reply</button>
                                    <button type="reset" class="btn btn-default">D&eacute;barrasser/Clear</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="//cdn.jsdelivr.net/jquery/2.1.0/jquery.min.js"></script>
        <script src="//cdn.jsdelivr.net/bootstrap/3.1.0/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-growl/1.0.0/jquery.bootstrap-growl.min.js"></script>
        <script src="{{ asset('js/player.js') }}"></script>
        <script src="{{ asset('js/player_comments.js') }}"></script>
        <script>
            var stance = "";

            function reportNarrative() {
                if(narrativeID != -1){
                    var form = $("#narrative-report-form").serialize() + "&NarrativeID="+narrativeID;
                    $.ajax({//
                        url:"/flag",
                        type:"POST",
                        data:form,
                        success: function() {
                            $.bootstrapGrowl("Report sent!", {type: "success"});
                        },
                        error: function() {
                            $.bootstrapGrowl("Could not send your report due to a server error. Please try again later!", {type: "error"});
                        }
                    });
                    $(".flag-btn").attr("disabled","disabled");
                    $("#report-narrative").modal("hide");
                }
            }

            function expressOpinion(id, elem) {
                if (narrativeID != -1) {
                    //ajax call with stance to increase agree or disagree or indifferent
                    var old = false

                    if (stance != "") {
                        var old = true;
                        $("#"+stance).removeAttr("disabled")
                        $("#"+stance).removeClass("btn-success");
                    }

                    var token = $("input[name=_token]").val();
                    
                    if(id == 1)
                        stance = "agree";
                    else
                        stance = "disagree";

                    $.ajax({
                        url:"/stance",
                        type:"POST",
                        data: {
                            NarrativeID: narrativeID,
                            _token : token,
                            stance: id,
                            old : old
                        },
                        success: function() {
                            $.bootstrapGrowl("Opinion saved!", {type: "success"});
                            $("#"+stance).attr("disabled","disabled")
                            $("#"+stance).addClass("btn-success");
                        },
                        error: function() {
                            $.bootstrapGrowl("Could not save your opinion due to a server error. Please try again later!", {type: "error"});
                        }
                    });
                }
            }

            $(document).ready(function() {
                // Enable tooltips
                $("div,button").tooltip();

                // Prepare the player with the JSON API path to the
                // narrative resource.
                preparePlayer("{{ $narrativeApiPath }}");

                // Prepare the comments with the JSON API path to the
                // comment resource.
                prepareComments("{{ $commentsApiPath }}");

                // Bind the share button action
                $(".share-btn").bind("click", function(e) {
                    $("#href-text").val(window.location.href);
                    $("#share-modal").modal("show");
                });

                $("#href-text").mouseenter(function(e){
                    $("#href-text").select();
                });

                // Bind the narrative report actions
                $("#report-submit-btn").click(function(e) {
                    reportNarrative();
                });
            });
        </script>
    </body>
</html>
