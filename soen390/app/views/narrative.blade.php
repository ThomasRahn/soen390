@extends('master')

@section('content')

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
	        jPlayer: "#jquery_jplayer_1", 
	        cssSelectorAncestor: "#jp_container_1"
	};
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
              	}
	};
	var myPlaylist = new jPlayerPlaylist(cssSelector, playlist, options);	
	$.getJSON("/jsonNarrative/1",function(data){  // get the JSON array produced by my PHP
	        $.each(data,function(index,value){
	            myPlaylist.add(value); // add each element in data in myPlaylist
	        })
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
