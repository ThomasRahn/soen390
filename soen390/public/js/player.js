var currentTime = 0,
    totalTime   = 0,
    player      = null,
    playing     = false,
    targetTime  = -1;

var currentTrack  = 0,
    trackList     = new Array(),
    blinkerInter  = null,
    progressInter = null;

function preparePlayer(jsonApiPath) {
    // Fetch the narrative details from the API.
    $.getJSON(
        jsonApiPath,
        function(data) {
            // Store the tracklist.
            trackList = data.return.audio;

            // Tally up the total duration.
            setTotalTime(trackList);

            // Figure out the start-percent of each track in relation to the
            // playlist total.
            determineStartPercent(trackList);

            // Get the player reference
            player = $(".player");

            // Set the player's current track to 0
            setCurrentTrack(0);

            // Bind player events
            bindPlayerEvents(player);

            // Bind player control events
            bindPlayerControlHandlers();

            // Blink the play button while it's not playing.
            blinkPlayBtn("btn-success");
        }
    );
}

function setPoster(src) {
    $(".image-view").css("background-image", "url(\"" + src + "\")");
}

function convertSecondsToTimeString(time) {
    time += "";

    var timeStrToken = time.split("."),
        parseSeconds = parseInt(timeStrToken[0]);

    if (parseSeconds === 0) return "0:00";

    var minutes = parseInt(parseSeconds / 60),
        seconds = parseInt(parseSeconds % 60);

    if (seconds < 10) seconds = "0" + seconds;

    return minutes + ":" + seconds;
}

function setTotalTime(tracks) {
    $.each(tracks, function(index, obj) {
        totalTime += parseFloat(obj.duration);
    });

    var formattedTimeString = convertSecondsToTimeString(totalTime);

    $(".end-time").html(formattedTimeString);
}

function blinkPlayBtn(cssClass) {
    blinkerInter = window.setInterval(function() {
        $(".playback-btn").addClass(cssClass);

        window.setTimeout(function() {
            $(".playback-btn").removeClass(cssClass);
        }, 1000);
    }, 10000);
}

function setCurrentTrack(track) {
    // Load the appropriate track
    currentTrack = track;
    $("#player-mp3-src").attr("src", trackList[track].mp3);
    $("#player-oga-src").attr("src", trackList[track].oga);
    player.get(0).load();

    // Figure out the current time.

    currentTime = 0;

    for (var i = 0; i < currentTrack; i++)
        currentTime += parseFloat(trackList[i].duration);

    // Set the appropriate poster
    setPoster(trackList[currentTrack].poster);

    console.log("Current Track: " + currentTrack + ", Current Poster: " + trackList[currentTrack].poster + ", Start %: " + trackList[currentTrack].startPercent);
}

function bindPlayerEvents(player) {
    // Bind the "play" event.
    player.bind("play", function(e) {
        console.log("Track played.");

        // Stop blinking the button.
        window.clearInterval(blinkerInter);

        playing = true;

        // Swap out the play icon for the pause
        $(".playback-btn i").removeClass("fa-play");
        $(".playback-btn i").addClass("fa-pause");

        // Swap the colour of the button
        $(".playback-btn").removeClass("btn-default");
        $(".playback-btn").removeClass("btn-warning");
        $(".playback-btn").addClass("btn-success");

        // Start the progress interval
        window.setTimeout(function() {
            startProgressInterval();
        }, 100);
    });

    // Bind the "pause" event
    player.bind("pause", function(e) {
        playing = false;

        // End the progress interval
        window.clearInterval(progressInter);

        // Check if playback for current track has ended or not.
        if (player.get(0).ended) {
            console.log("Track ended.");

            // Check if we are at the end of the playlist or not.
            // If not, then we need to proceed to the next track.

            if (currentTrack == (trackList.length - 1)) {
                console.log("End of playlist.");

                // Swap play button icons
                $(".playback-btn i").removeClass("fa-pause");
                $(".playback-btn i").addClass("fa-play");

                // Swap the button colour
                $(".playback-btn").removeClass("btn-success");
                $(".playback-btn").addClass("btn-default");

                // Set the progress bar to 0%
                $(".progress-bar").css("width", "");

                // Load the first track again
                setCurrentTrack(0);

                // Enable the button groups
                $(".btn-group").css("opacity", 1);
                $(".btn-group").tooltip("destroy");
                $(".btn").removeAttr("disabled");

            } else {
                // Increment the current track
                setCurrentTrack(currentTrack + 1);

                // Play it
                player.get(0).play();
            }

        } else {
            console.log("Track paused.");

            // Swap play button icons
            $(".playback-btn i").removeClass("fa-pause");
            $(".playback-btn i").addClass("fa-play");

            // Swap the button colour
            $(".playback-btn").removeClass("btn-success");
            $(".playback-btn").addClass("btn-warning");

        }
    });

    // Bind the player "loadstart" event to set the spinner.
    player.bind("loadstart", function(e) {
        $(".play-btn i").addClass("fa-spin fa-spinner");
    });

    // Bind the player "canplay" event; mainly for seeking.
    player.bind("canplay", function(e) {
        $(".play-btn i").removeClass("fa-spin fa-spinner");

        // Don't do anything if we're not seeking.
        if (targetTime < 0) return;

        player.get(0).currentTime = targetTime;

        targetTime = -1;

        updateCurrentProgress();

        player.get(0).play();

        // Reset transition delay in progress bar
        $(".progress-bar").css("-webkit-transition-duration", "");
        $(".progress-bar").css("transition-duration", "");
    });

}

function bindPlayerControlHandlers() {
    // Ensure that the button doesn't stay focused.
    $(".btn").click(function() {
        $(this).blur();
    });

    // Bind the play button
    $(".play-btn").click(function(e) {
        if (! playing) {
            player.get(0).play();
        } else {
            player.get(0).pause();
        }
    });

    // Bind the back button
    $(".back-btn").click(function(e) {
        if (! playing) {
            setCurrentTrack(getPreviousTrack());

            updateCurrentProgress();

            return;
        }

        if (player.get(0).currentTime < 1.5) {
            setCurrentTrack(getPreviousTrack());
        } else {
            setCurrentTrack(currentTrack);
        }

        updateCurrentProgress();

        window.setTimeout(function() {
            player.get(0).play();
        }, 500);
    });

    // Bind the forward button
    $(".forward-btn").click(function(e) {
        // If there is no next track, then do nothing.
        if (getNextTrack() == currentTrack) return;

        setCurrentTrack(getNextTrack());

        updateCurrentProgress();

        window.setTimeout(function() {
            player.get(0).play();
        }, 250);
    });

    // Bind the progress bar seek.
    $(".progress-container").click(function(e) {
        // Disable transition delay in progress bar
        $(".progress-bar").css("-webkit-transition-duration", "0s");
        $(".progress-bar").css("transition-duration", "0s");

        // Figure out the seek percentage
        var xPos     = e.pageX - $(e.target).parent().offset().left,
            barWidth = $(this).width(),
            seekPercent = (xPos / barWidth) * 100;

        console.log("Seek Percent: " + seekPercent);

        // Determine which track this percentage corresponds to.
        var targetTrack   = 0,
            trackProgress = 0;

        for (var i = 0; i < trackList.length; i++) {
            targetTrack = i;

            var thisTrackStart = trackList[i].startPercent,
                nextTrackStart = 100;

            if ((i + 1) < trackList.length)
                nextTrackStart = trackList[i + 1].startPercent;

            if (seekPercent >= nextTrackStart) continue;

            trackProgress = (seekPercent - thisTrackStart) / (nextTrackStart - thisTrackStart);

            break;
        }

        targetTime = parseFloat(trackList[targetTrack].duration) * trackProgress;

        setCurrentTrack(targetTrack);
    });
}

function startProgressInterval() {
    window.clearInterval(progressInter);

    progressInter = window.setInterval(function() {
        updateCurrentProgress();
    }, 250);
}

function getPreviousTrack() {
    var targetTrack = currentTrack - 1;

    if (targetTrack < 0) targetTrack = 0;

    return targetTrack;
}

function getNextTrack() {
    var targetTrack = currentTrack + 1;

    if (targetTrack >= trackList.length) targetTrack = currentTrack;

    return targetTrack;
}

function updateCurrentProgress() {
    var runningTime = currentTime + player.get(0).currentTime;

    var percentProgress = ((runningTime / totalTime) * 100);

    $(".begin-time").html(convertSecondsToTimeString(runningTime));
    $(".progress-bar").css("width", percentProgress + "%");
}

function determineStartPercent(tracks) {
    var indexTime = 0;

    $.each(tracks, function(index, track) {
        // Calculate start percent in relation to total time.
        var startPercent = (indexTime / totalTime) * 100;

        // Add property to track objects.
        track['startPercent'] = startPercent;

        // Add a track indicator onto the player page.
        if (startPercent > 0)
            $("<div />").addClass("track-indicator").css("left", startPercent + "%").appendTo(".track-indicators");

        indexTime += parseFloat(track.duration);
    });
}