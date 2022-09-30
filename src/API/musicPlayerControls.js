/* https://codepen.io/aravi-pen/pen/OxPaVb */
var player1,onplayhead,playerId,timeline,playhead,timelineWidth;

function updatePlaylist () {
    $('.playlistItem.playing').removeClass('playing');
    $('.playlistItem').each(function () {
        if ( $('#sourcePath').attr('currentFile') == $(this).attr('filename') )
            $(this).addClass('playing')
    });
    const jsmediatags = window.jsmediatags;
    jsmediatags.read('http://' + $(location).attr('host') + $('#sourcePath').attr('src'), {
        onSuccess: function ( result ) {
            if ( typeof result.tags.picture != 'undefined' ) {
                const { data, format } = result.tags.picture;
                let base64String = "";
                for (const i = 0; i < data.length; i++) {
                base64String += String.fromCharCode(data[i]);
                }
                $('#musicImg').attr('src', 'data:' + format + ';base64,' + window.btoa(base64String))
            } else {
                $('#musicImg').attr('src', '/src/icons/albumDisk.svg')
            }
        },
        onError: function () {
            $('#musicImg').attr('src', '/src/icons/albumDisk.svg')
        }
    })
}

function resetLabels () {
    $("#playerTime > #totalTime").html("--:--");
    $("#playerTime > #currentTime").html("--:--");    
}

function nextSong () {

}

function previousSong () {

}

function restartSong () {

}

function handlerBack () {

}

updatePlaylist();

$('.playlistItem').click(function () {
    if ( $('#sourcePath').attr('currentFile') != $(this).attr('filename') ) {
        $('#musicTitle').html( removeExtensionFromFile( $(this).attr('filename') ) );
        $('#sourcePath').attr('src', mainPath + $(this).attr('filename'));
        $('#quickDownload').attr('href', mainPath + $(this).attr('filename'));
        $('#sourcePath').attr('currentFile', $(this).attr('filename') );
        $('#musicPlayer')[0].load();
        resetLabels();
        isPlaying = false;
        $("#playPause > img").attr("src", "/src/icons/play.svg");
        updatePlaylist();
        ballSeek();
    }
});

$('#previous').click(function () {
    if ( $('#currentTime').html() < '00:03' )
        if ( files.indexOf( $('#sourcePath').attr('currentFile') ) > 0 ) {
            $('#musicTitle').html( removeExtensionFromFile( files[ files.indexOf( $('#sourcePath').attr('currentFile') ) - 1 ] ) );
            $('#sourcePath').attr('src', mainPath + files[ files.indexOf( $('#sourcePath').attr('currentFile') ) - 1 ]);
            $('#quickDownload').attr('href', mainPath + files[ files.indexOf( $('#sourcePath').attr('currentFile') ) - 1 ]);
            $('#sourcePath').attr('currentFile', files[ files.indexOf( $('#sourcePath').attr('currentFile') ) - 1 ] );
            $('#musicPlayer')[0].load();
            resetLabels();
            isPlaying = false;
            $("#playPause > img").attr("src", "/src/icons/play.svg");
            updatePlaylist();
            ballSeek();
        }
    else {
        
    }
});

$('#next').click(function () {
    if ( files.indexOf( $('#sourcePath').attr('currentFile') ) < files.length - 1 ) {
        $('#musicTitle').html( removeExtensionFromFile( files[ files.indexOf( $('#sourcePath').attr('currentFile') ) + 1 ] ) );
        $('#sourcePath').attr('src', mainPath + files[ files.indexOf( $('#sourcePath').attr('currentFile') ) + 1 ]);
        $('#sourcePath').attr('currentFile', files[ files.indexOf( $('#sourcePath').attr('currentFile') ) + 1 ] );
        $('#quickDownload').attr('href', mainPath + files[ files.indexOf( $('#sourcePath').attr('currentFile') ) + 1 ]);
        $('#musicPlayer')[0].load();
        resetLabels();
        isPlaying = false;
        $("#playPause > img").attr("src", "/src/icons/play.svg");
        updatePlaylist();
        ballSeek();
    }
});

$(window).on("load", function () {
    audioPlay();
    ballSeek();
    $('.playlistItem > p').each(function () {
        $(this).html( removeExtensionFromFile( $(this).html() ) );
    });

});

function audioPlay () {

    var player = $("#musicPlayer")[0];
    //player.play();
    initProgressBar();
    isPlaying = false;
    $("#playerTime > #totalTime").html("--:--");
    $("#playerTime > #currentTime").html("--:--");

}

function initProgressBar () {

    $("#playPause > img").attr("src", "/src/icons/play.svg");
    player1 = document.getElementById("musicPlayer");
    player1.addEventListener("timeupdate", timeCal);
    var playBtn = $("#playPause");
    playBtn.click(function() {
        if ( player1.paused === false ) {

            player1.pause();
            isPlaying = false;
            $("#playPause > img").attr("src", "/src/icons/play.svg");

        } else {

            player1.play();
            isPlaying = true;
            $("#playPause > img").attr("src", "/src/icons/pause.svg");

        }
    });

}

function timeCal () {

    var width = $("#playerProgressBarContainer").width();
    var length = player1.duration;
    var current_time = player1.currentTime;

    // calculate total length of value
    var totalLength = calculateTotalValue(length);
    // calculate current value time
    var currentTime = calculateCurrentValue(current_time);

    if ( totalLength == "NaN:Na" ) {
        
        $("#playerTime > #totalTime").html("--:--");
        $("#playerTime > #currentTime").html("--:--");

    } else {

        $("#playerTime > #totalTime").html(totalLength);
        $("#playerTime > #currentTime").html(currentTime);
    
    }

    var progressbar = document.getElementById("playerProgressBarDot");
    progressbar.style.marginLeft = width * (player1.currentTime / player1.duration) + "px";


}

function calculateTotalValue ( length ) {

    var minutes = Math.floor(length / 60);
    var  seconds_int = length - minutes * 60;
    if ( seconds_int < 10 )
        seconds_int = "0"+seconds_int;

    var seconds_str = seconds_int.toString();
    var  seconds = seconds_str.substr(0, 2);
    var time = minutes + ':' + seconds;
    return time;

}

function calculateCurrentValue ( currentTime ) {

    var current_hour = parseInt(currentTime / 3600) % 24,
    current_minute = parseInt(currentTime / 60) % 60,
    current_seconds_long = currentTime % 60,
    current_seconds = current_seconds_long.toFixed(),
    current_time = (current_minute < 10 ? "0" + current_minute : current_minute) + ":" + (current_seconds < 10 ? "0" + current_seconds : current_seconds);
    return current_time;

}

function ballSeek () {

    onplayhead = null;
    playerId = null;
    timeline = document.getElementById("playerProgressBarContainer");
    playhead = document.getElementById("playerProgressBarDot");
    timelineWidth = timeline.offsetWidth - playhead.offsetWidth;

    timeline.addEventListener("click", seek);
    playhead.addEventListener('mousedown', drag);
    window.addEventListener('mouseup', mouseUp);

}


function seek ( event ) {

    var player = document.getElementById("musicPlayer");
    player.currentTime = player.duration * clickPercent(event, timeline, timelineWidth);

}

function clickPercent ( e, timeline, timelineWidth ) {

    return (event.clientX - getPosition(timeline)) / timelineWidth;

}

function getPosition ( el ) {

    return el.getBoundingClientRect().left;

}

function drag ( e ) {

    player1.removeEventListener("timeupdate", timeCal);
    onplayhead = $(this).attr("id");
    playerId = "musicPlayer"
    var player = document.getElementById( playerId );
    window.addEventListener('mousemove', dragFunc);
    player.removeEventListener('timeupdate', timeUpdate);

}


function dragFunc ( e ) {

    var player = document.getElementById(onplayhead);
    var newMargLeft = e.clientX - getPosition(timeline);

    if ( newMargLeft >= 0 && newMargLeft <= timelineWidth )
        playhead.style.marginLeft = newMargLeft + "px";

    if ( newMargLeft < 0 )
        playhead.style.marginLeft = "0px";

    if ( newMargLeft > timelineWidth )
        playhead.style.marginLeft = timelineWidth + "px";

}

function mouseUp ( e ) {
    if ( onplayhead != null ) {

        var player = document.getElementById(playerId);
        window.removeEventListener('mousemove', dragFunc);
        player.currentTime = player.duration * clickPercent(e, timeline, timelineWidth);
        player1.addEventListener("timeupdate", timeCal);
        player.addEventListener('timeupdate', timeUpdate);
        
    }
    onplayhead = null;
}

function timeUpdate () {

    var player2 = document.getElementById(onplayhead);
    var player = document.getElementById(playerId);
    var playPercent = timelineWidth * (player.currentTime / player.duration);
    player2.style.marginLeft = playPercent + "px";
    // If song is over
    if (player.currentTime == player.duration) {
        player.pause();
    }

}