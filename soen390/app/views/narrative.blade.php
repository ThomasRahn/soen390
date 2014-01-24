@extends('master')

@section('content')

<script type="text/javascript">
var playlist;
 $(document).ready(function(){
	playlist = new jPlayerPlaylist({
		jPlayer: "#jquery_jplayer_1",
		cssSelectorAncestor: "#jp_container_1"
		}, [
		{
			title:"Tswift",
			mp3:"audio/Tswift.mp3",
			poster: "https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcQrkkouUIfWXRIRhKVKp5UN1cbR1U_gKgAr50TvvQpr4sFKUHm8"
		},
		{
			title:"Breaking Ben",
			mp3:"audio/untilTheEnd.mp3",
			poster: "http://freefever.com/stock/latest-funny-jokes-for-kids-picture-of-a-funny-joke-kids-who-were.jpg",
		}], {
		swfPath: "jplayer/",
		supplied: " mp3",
		wmode: "window",
		smoothPlayBar: true,
		keyEnabled: true,
		play: function(element){
	         var current  = playlist.current, playlist1 = playlist.playlist;
	       	 jQuery.each(playlist1, function (index, obj){
	       		if (index == current){
				$(".audio_poster").attr("src",obj.poster);
	        	    } // if condition end
	        	});
		}
	});


	});
</script>

<div id="jquery_jplayer_1" class="jp-jplayer"></div>
		<img  height="350px" width="425px" class="audio_poster" src=""/>
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
		                <!-- comment out any of the following <li>s to remove these buttons -->
		                <li><a href="javascript:;" class="jp-previous" tabindex="1">Previous</a></li>
		                <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
		                <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
		                <li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
		                <li><a href="javascript:;" class="jp-next" tabindex="1">next</a></li>
		                <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
		                <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
		                <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
		            </ul>
		            
		            <!-- you can comment out any of the following <div>s too -->
		            
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

@stop
