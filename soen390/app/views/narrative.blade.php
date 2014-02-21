@extends('master')

@section('content')
 <style>
    body {
        padding-top: 50px;
        padding-bottom: 70px;
        min-width: 1000px;
    }
    .navbar .progress {
        background-color: #5a5a5a;
    }
    .jp-controls {
        padding-left: 8px;
    }
    .jp-pause {
        display: none;
    }
    .jp-playlist-current {
        font-weight: 600;
    }

    #uploadModal {
        padding-top: 50px;
        background: rgba(255,255,255,0.3);
    }
</style>

<script type="text/javascript">
function printObject(o) {
  var out = '';
  for (var p in o) {
    out += p + ': ' + o[p] + '\n';
  }
  alert(out);
}
 $(document).ready(function(){
	var cssSelector = {
	        jPlayer: '#jquery_jplayer',
            cssSelectorAncestor: '#jp-container'

	};
    var total_duration = 0;
    var durations = new Array();
	var playlist = []; // Empty playlist
	var options = {
	        swfPath: "./js", 
	        supplied: "oga, mp3",
		play: function(element){
			var current  = myPlaylist.current;	
			var temp = myPlaylist.playlist;
            jQuery.each(temp, function (index, obj){
  	       	    if (index == current){
 	       	     	$(".audio_poster").attr("src",obj.poster);
            	} // if condition end
         	});
         	$(".jp-title").html(myPlaylist.playlist[current].title);
            $('.jp-play').hide();
            
            $('.jp-pause').show();
        },
  	  	timeupdate: function(event) {
            var progress = event.jPlayer.status.currentPercentAbsolute;

            var current_time = 0;
            for(var i = 0; i < myPlaylist.current; i++){
                current_time += durations[i]
            }

            current_time += progress * (durations[myPlaylist.current] / 100);
	       var minutes = Math.floor((parseInt(current_time) / 60));
                if(minutes < 10)
                        minutues =  "0"+minutes;
            var seconds = current_time.toFixed(0) % 60;
                if(seconds < 10)
                        seconds = "0"+seconds;

            var current_str = minutes + ":" + seconds;

            $("#jp-current").html(current_str);
            current_perc = (current_time / total_duration)*100;
            current_perc = (current_perc/100) * parseInt($(".personal_prog_bar").css("width"));
            $(".temp_progress").css("width", current_perc+"px");


            //$('.jp-progress').css('width', (progress + '%'));
        },
        ended: function(event){
            var progress_bar = parseInt($(".personal_prog_bar").css("width"));
            var total = parseInt($(".temp_progress").css("width"));
            if( total > (progress_bar * 0.95)){
                myPlaylist.play(0);
                myPlaylist.pause();

                //show upvote, downvote     
                $(".option-bar").show();
            }
        },
        pause: function(event) {
           $('.jp-play').show();
           $('.jp-pause').hide();
        }


	};
	var myPlaylist = new jPlayerPlaylist(cssSelector, playlist, options);	
	$.getJSON("{{ action('ApiNarrativeController@show', array('id' => $narrative->NarrativeID)) }}",function(data){  // get the JSON array produced by my PHP

		data = data.return.audio;

	        $.each(data,function(index,value){
	        	if(index == 1){
	        		$(".audio_poster").attr("src", value.poster);
	        	}
                total_duration += parseFloat(value.duration);
                durations.push(parseFloat(value.duration));
	            myPlaylist.add(value); // add each element in data in myPlaylist
	        });
	    var minutes = Math.floor((parseInt(total_duration) / 60));
		if(minutes < 10)
			minutues =  "0"+minutes; 
	    var seconds = total_duration.toFixed(0) % 60;
		if(seconds < 10)
			seconds = "0"+seconds;

	    var total_str = minutes + ":" + seconds;
            $("#jp-total").html(total_str);
            var len = durations.length;
            $.each(durations, function(index,value){
                    var element = $(".clone").clone();

                    element.removeClass("clone");
                    element.addClass("pull-left");
                   

                    percentage = (value / total_duration) * 100;
                    element.css("width", (percentage)+"%");
                   
                    element.css("border", "solid black 1px");
                    element.css("display","block");
                    element.data("jpp-index",index);
                    $(".personal_prog_bar").append(element);
            });

	}); 

	$('.jp-play').click(function(e) {
        myPlaylist.play();
    });

    $('.jp-pause').click(function(e) {
        myPlaylist.pause();
    });

    $('.jp-previous').click(function() {
        myPlaylist.previous();
    });

    $('.jp-next').click(function() {
        myPlaylist.next();
    });

	$('.progress').click(function(e) {
        var posX = $(this).position().left;
	    var relPosX = e.pageX - posX;
	    var elemWidth = $(this).width();
	    var seekPercent = (relPosX / elemWidth) * 100;
        var total_time = total_duration * (seekPercent/100);
        var remaning_time = 0;
        var done = false;
        $.each(durations, function(index,value){
            if(!done){
                if(total_time >= value){
                    total_time -= value;
                }else{
                    remaning_time = 100-(((value - total_time) / value) * 100);
                    myPlaylist.play(index);
                    done = true;   
                }
            } 
        });

       
       // $('.progress-bar').css('-webkit-transition-duration', '0');
	    //$('.progress-bar').css('transition-duration', '0');
        //var playlistIndex = $(this).data('jpp-index');
        //myPlaylist.play(playlistIndex);
	    $('#jquery_jplayer').jPlayer("playHead", (remaning_time - 10));
	});
});

function reportNarrative(){
    var form = $("#reported-narrative").serialize();
    $.ajax({//
        url:"/flag",
        type:"POST",
        data:form,
        success:function(data){//
            alert("Thank you for the report, we will be looking into it shortly.");
        }

    });
    $("#report-narrative").modal("hide");
   
}
function expressOpinion(stance){
    //ajax call with stance to increase agree or disagree or indifferent
    var token = $("#crsf_token").val();
    var NarrativeID = $("#NarrativeID").val();
    $.ajax({//
        url:"/stance",
        type:"POST",
        data:{//
            NarrativeID: NarrativeID,
            _token : token,
            stance: stance
        },
        success:function(data){//
                $(".opinion").hide();
               alert("Thank you for opinion.");
        }
    });
}
</script>
<img class="audio_poster" height="500px" width="500px" src=""/>
   <!-- Playlist -->
        <div id="jp-container" class="container pull-right" style="right:0px; width:200px;">
            <section class="jp-playlist">
                <ul class="nav nav-pills nav-stacked">
                    <li></li>
                </ul>
            </section>
        </div>
        <!-- Player -->
        <div id="jquery_jplayer" class="jp-jplayer"></div>

        <!-- Player Control -->
        <footer class="navbar navbar-inverse navbar-fixed-bottom">
            <div class="jp-current-time"></div>
            <div class="jp-duration"></div>

            <div class="navbar-header">
                <ul class="nav navbar-nav">
                    <li>
                        <div class="btn-group navbar-btn jp-controls">
                            <button type="button" class="btn btn-primary jp-previous"><i class="fa fa-step-backward"></i></button>
                            <button type="button" class="btn btn-success jp-play"><i class="fa fa-play"></i></button>
                            <button type="button" class="btn btn-warning jp-pause"><i class="fa fa-pause"></i></button>
                            <button type="button" class="btn btn-primary jp-next"><i class="fa fa-step-forward"></i></button>
                        </div>
                    </li>
                </ul>

                <div class="nav navbar-text" style="width:110px;">
                    <i id="spinner" class="fa fa-spinner fa-spin" style="display:none"></i>
                    <span class="jp-title">Play something.</span>
                </div>
                
                <div class="nav navbar-text" style="width:20px;">
                    <span id="jp-current"></span>
                </div>
                <div class="nav navbar-text personal_prog_bar progress" style="width:600px;background-color:#5a5a5a;height:30px;">
                    
                    <div class="temp_progress" style="width:0%;background-color:lime;z-index:0;height:30px;position:absolute;transition-duration: 0.6s;"></div>
                    <div class="progress_container clone" style="display:none;height:30px;z-index:5;position:relative;"></div>
                </div>
                <div class="nav navbar-text">
                    <span id="jp-total"></span>
                </div>
                <div class="nav navbar-text option-bar" style="display:none; width:200px;">
                    <div class="opinion pull-left">
                        <form id='narrative-stance'>    
                            <input type="hidden" name="NarrativeID" id="NarrativeID" value="{{ $narrative->NarrativeID}}"/>
                            <input type="hidden" name="_token" id="crsf_token" value="<?php echo csrf_token(); ?>">
                            <button type="button" class="btn btn-default" onclick="expressOpinion(1);" ><i class="fa fa-hand-o-up fa-fw"></i></button>
                            <button type="button" class="btn btn-default" onclick="expressOpinion(2);" ><i class="fa fa-hand-o-down fa-fw"></i></button>
                            <button type="button" class="btn btn-default" onclick="expressOpinion(3);" ><i class="fa fa-hand-o-right fa-fw"></i></button>
                        </form>
                    </div>
                    <div class="report pull-right">
                        <button type="button" class="btn btn-default" onclick="" data-toggle="modal" data-target="#report-narrative"><i class="fa fa-exclamation fa-fw"></i></button>
                    </div>
                </div>

            </div>
    </footer>
      <div class="modal" id="report-narrative">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Report Narrative</h4>
              </div>
              <div class="modal-body">
                <p>You are currently reporting this narrative, tell us why</p>
                <form class="reported-Narrative">
            
                </form>
                <form id='reported-narrative'>
                    {{ Form::token()}}
                    {{ Form::textarea('report-comment')}}
                    <input type="hidden" name="NarrativeID" value="{{ $narrative->NarrativeID}}"/>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="reportNarrative()">Report</button>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
@stop
