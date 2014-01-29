@extends('master')

@section('content')
 <style>
            body {
                padding-top: 50px;
                padding-bottom: 70px;
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
	        supplied: "mp3",
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
          //  $('#prog_'+myPlaylist.current).css('width', (progress + '%'));
           // $('#container_'+myPlaylist.current).css('width', ((100-progress) + '%'));
            var current_time = 0;
            for(var i = 0; i < myPlaylist.current; i++){
                current_time += durations[i]
            }
            current_time += progress * (durations[myPlaylist.current] / 100);

            current_perc = (current_time / total_duration)*100;
            current_perc = (current_perc/100) * parseInt($(".personal_prog_bar").css("width"));
            $(".temp_progress").css("width", current_perc+"px");
            //$('.jp-progress').css('width', (progress + '%'));
        },
        pause: function(event) {
           	$('.jp-play').show();
            $('.jp-pause').hide();
        }


	};
	var myPlaylist = new jPlayerPlaylist(cssSelector, playlist, options);	
	$.getJSON("/jsonNarrative/1",function(data){  // get the JSON array produced by my PHP
	        $.each(data,function(index,value){
	        	if(index == 1){
	        		$(".audio_poster").attr("src", value.poster);
	        	}
                total_duration += parseFloat(value.duration);
                durations.push(parseFloat(value.duration));
	            myPlaylist.add(value); // add each element in data in myPlaylist
	        }); 
            var len = durations.length;
            $.each(durations, function(index,value){
                    var element = $(".clone").clone();
                 //   var container = element.find(".progress_clone");
                  //  var progress = element.find(".temp");

                    element.removeClass("clone");
                  //  container.removeClass("progress_clone");
                   // progress.removeClass("temp");

                    element.addClass("pull-left");
                    //container.addClass("pull-left");
                    //progress.addClass("pull-left");


                    percentage = (value / total_duration) * 100;
                    element.css("width", (percentage)+"%");
                   // container.css("width","100%");
                   // progress.css("width","0%");

                    element.css("border", "solid black 1px");
                    element.css("display","block");
                    //container.css("display","block");
                    //progress.css("display","block");
                    
                    //container.attr("id", "container_"+index);
                    //progress.attr("id", "prog_"+index);
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
           //         $("#container_"+index).css("width","0%");
        //        $("#prog_"+index).css("width","100%");
                }else{
                    remaning_time = 100-(((value - total_time) / value) * 100);
            //        $("#container_"+index).css("width",remaning_time+"%");
             //       $("#prog_"+index).css("width",(100-remaning_time)+"%");
                    myPlaylist.play(index);
                    done = true;   
                }
            }else{//
          //      $("#container_"+index).css("width","100%");
           //     $("#prog_"+index).css("width","0%");
            }   
        });

       
       // $('.progress-bar').css('-webkit-transition-duration', '0');
	    //$('.progress-bar').css('transition-duration', '0');
        //var playlistIndex = $(this).data('jpp-index');
        //myPlaylist.play(playlistIndex);
	    $('#jquery_jplayer').jPlayer("playHead", (remaning_time - 10));
	});
});

</script>
<img class="audio_poster" height="500px" width="500px" src=""/>
<!-- 
<div id="jquery_jplayer_1" class="jp-jplayer"></div>
		
		<div id="jp_container_1" class="jp-audio">
		    <div class="jp-type-playlist">
			<div id="jquery_jplayer_N" class="jp-jplayer"></div>

		        <div class="jp-gui jp-interface">
				<div class="jp-title">
							<ul>
								<li></li>
							</ul>
						</div>

		            <ul class="jp-controls">
		                <li><a href="javascript:;" class="jp-previous" tabindex="1">Previous</a></li>
		                <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
		                <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
		                <li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
		                <li><a href="javascript:;" class="jp-next" tabindex="1">next</a></li>
		                <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
		                <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
		                <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
		            </ul>
		            
		            
		            <div class="jp-progress">
		                <div class="jp-seek-bar">
		                    <div class="jp-play-bar"></div>
		                </div>
		            </div>
		            <div class="jp-volume-bar">
		                <div class="jp-volume-bar-value"></div>
		            </div>
		            <div class="jp-current-time"></div>
		            <div class="jp-duration"></div>                   
		        </div>
			<div class="jp-playlist">
					<ul>
						<li></li>
					</ul>
				</div>

		        <div class="jp-title">
		            <ul>
		                <li>T Swift BABY!!!!</li>
		            </ul>
		        </div>
		    </div>
		</div>
	-->

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

                <div class="nav navbar-text" style="width:100px;">
                    <i id="spinner" class="fa fa-spinner fa-spin" style="display:none"></i>
                    <span class="jp-title">Play something.</span>
                </div>

                <div class="nav navbar-text personal_prog_bar progress" style="width:600px;background-color:#5a5a5a;height:30px;">
                    
                      <!--  <div class="progress-bar progress-bar-warning jp-progress temp" style="width:0%"></div>
                        <div class="jp-progress jp-load-progress progress_clone" style="width:0%"></div>-->
                    
                    <div class="temp_progress" style="width:0%;background-color:lime;z-index:0;height:30px;position:absolute;"></div>
                    <div class="progress_container clone" style="display:none;height:30px;z-index:5;position:relative;"></div>
                </div>
                   
            <!--
                    <div class="nav navbar-text progress" style="width:400px;margin-bottom:-10px;">
                        <div class="progress-bar progress-bar-warning jp-progress" style="width:0%"></div>
                        <div class="progress-bar jp-load-progress" style="width:0%"></div>
                    </div>
                -->
                <div class="nav navbar-text">
                    <span id="jp-msg"></span>
                </div>

            </div>

@stop
