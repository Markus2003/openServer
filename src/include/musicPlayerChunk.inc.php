<td style='width: fit-content'>
    <div id='playerAndPlaylist'>
        <div id='musicPlayerContainer'>
            <img src='/src/icons/albumDisk.svg' id='musicImg' /><!--https://medium.com/@codefoxx/how-to-extract-metadata-from-music-files-with-javascript-using-jsmediatags-619323bb2b16-->
            <div id='playerTime'>
                <p id='currentTime'></p>
                <p id='totalTime'></p>
            </div>
            <div id='playerProgressBarContainer'>
                <div id='playerProgressBarDot'></div>
            </div>
            <div id='playerControls'>
                <button id='previous' class='button primaryColor-Dark shadow'><img src='/src/icons/skip_previous.svg'></button>
                <button id='playPause' class='button primaryColor-Dark shadow'><img src='/src/icons/play.svg'></button>
                <button id='next' class='button primaryColor-Dark shadow'><img src='/src/icons/skip_next.svg'></button>
            </div>
            <audio id='musicPlayer' class='right' controls preload='auto'>
                <source id='sourcePath' src='<?php echo $_GET["path"] ?>' currentFile='<?php echo $_GET["fileName"] ?>' />
            </audio>
        </div>
        <div id='playlist'>
            <?php $rawFolder = scandir( str_replace( $_GET["fileName"], '', $_SERVER["DOCUMENT_ROOT"] . $_GET["path"] ) ); foreach ( $rawFolder as $chunk ) if ( is_file( str_replace( $_GET["fileName"], '', $_SERVER["DOCUMENT_ROOT"] . $_GET["path"] ) . $chunk ) and isReadableForServer( $chunk ) == "Audio" ) echo "<div class='playlistItem' filename='" . addslashes( $chunk ) . "'><img src='data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=' />" . $chunk . "</div>"; ?>
        </div>
    </div>
</td>