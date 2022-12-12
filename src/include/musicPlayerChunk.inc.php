<td style='width: fit-content'>
    <div id='playerAndPlaylist'>
        <div id='musicPlayerContainer'>
            <img src='/src/icons/albumDisk.svg' id='musicImg' />
            <div id='playerTime'>
                <p id='currentTime'></p>
                <p id='totalTime'></p>
            </div>
            <div id='playerProgressBarContainer'>
                <div id='playerProgressBarDot'></div>
            </div>
            <div id='playerControls'>
                <button id='shuffle' class='button iconStyle primaryColor-Dark shadow' shuffleStatus='off' disabled><img src='/src/icons/shuffle_off.svg'></button>
                <button id='previous' class='button iconStyle primaryColor-Dark shadow'><img src='/src/icons/skip_previous.svg'></button>
                <button id='playPause' class='button iconStyle primaryColor-Dark shadow'><img src='/src/icons/play.svg'></button>
                <button id='next' class='button iconStyle primaryColor-Dark shadow'><img src='/src/icons/skip_next.svg'></button>
                <button id='repeat' class='button iconStyle primaryColor-Dark shadow' repeatStatus='off'><img src='/src/icons/repeat_off.svg'></button>
            </div>
            <audio id='musicPlayer' class='right' controls preload='auto'>
                <source id='sourcePath' src='<?php echo $_GET["path"] ?>' currentFile='<?php echo $_GET["fileName"] ?>' />
            </audio>
        </div>
        <div id='playlist'>
            <?php
                $rawFolder = scandir( str_replace( $_GET["fileName"], '', $_SERVER["DOCUMENT_ROOT"] . $_GET["path"] ) ); 
                foreach ( scandir( str_replace( $_GET["fileName"], '', $_SERVER["DOCUMENT_ROOT"] . $_GET["path"] ) ) as $chunk )
                    if ( is_file( str_replace( $_GET["fileName"], '', $_SERVER["DOCUMENT_ROOT"] . $_GET["path"] ) . $chunk ) and isReadableForServer( $chunk ) == "Audio" )
                        echo "<div class='playlistItem' filename='" . addslashes( $chunk ) . "'><img src='data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=' id='playingButton' /><p>" . $chunk . "</p><img src='data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=' id='removeButton' class='right' /></div>";
            ?>
        </div>
    </div>
</td>