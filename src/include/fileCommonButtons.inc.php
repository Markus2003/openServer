<?php
    echo "
        <section class='primaryColor shadow'>
    ";
    switch ( explode( '/', getInServerAddress( $_SERVER["REQUEST_URI"] ) )[1] ) {
        case 'Films':
            echo "
            <span class='max-width left sectionTitle' style='font-size: 30px'><img src='/src/icons/movie.svg' style='width: 30px' /><b>" . $file . "</b></span>
            ";
        break;

        case 'Music':
            echo "
            <span class='max-width left sectionTitle' style='font-size: 30px'><img src='/src/icons/music.svg' style='width: 30px' /><b>" . $file . "</b></span>
            ";
        break;

        case 'TV%20Series':
            echo "
                <span class='max-width left sectionTitle' style='font-size: 30px'><img src='/src/icons/tv.svg' style='width: 30px' /><b>" . $file . "</b></span>
            ";
        break;
    }
    echo "
                <span class='max-width left chunk-size'><button type='button' class='button primaryColor withIMG getFileSize' location=\"/" . str_replace( '%20', ' ', explode( '/', getInServerAddress( $_SERVER["REQUEST_URI"] ) )[1] ) . '/' . $overrideFolder . $file . "\"><img src='/src/icons/error.svg' />Get File Size</button></span>
                <article class='max-width'>
    ";
    switch ( explode( '/', getInServerAddress( $_SERVER["REQUEST_URI"] ) )[1] ) {
        case 'Films':
            echo "
                    <form action='/src/API/app/filmPlayer.php' method='GET'>
                        <input type='hidden' name='fileName' value=\"" . $file . "\" />
                        <input type='hidden' name='path' value=\"/Films/" . $overrideFolder . $file . "\" />
                        <button type='submit' class='button right shadow primaryColor-Dark'><img src='/src/icons/play.svg' /></button>
                    </form>
            ";
        break;

        case 'Music':
            echo "
                    <form action='/src/API/app/musicPlayer.php' method='GET'>
                        <input type='hidden' name='fileName' value=\"" . $file . "\" />
                        <input type='hidden' name='path' value=\"/Music/" . $overrideFolder . $file . "\" />
                        <button type='submit' class='button right shadow primaryColor-Dark'><img src='/src/icons/play.svg' /></button>
                    </form>
            ";
        break;

        case 'TV%20Series':
            echo "
                    <form action='/src/API/app/seriesPlayer.php' method='GET'>
                        <input type='hidden' name='fileName' value=\"" . $file . "\" />
                        <input type='hidden' name='path' value=\"/TV Series/" . $overrideFolder . $file . "\" />
                        <button type='submit' class='button right shadow primaryColor-Dark'><img src='/src/icons/play.svg' /></button>
                    </form>
            ";
        break;
    }
    echo "
                    <a href=\"/src/API/download.php?type=REGULAR&path=" . addslashes( getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder ) . "&filename=" . $file . "\" download><button type='button' class='button right shadow primaryColor-Dark'><img src='/src/icons/download.svg' /></button></a>
                    <button type='button' class='button primaryColor-Dark right shadow' onclick=\"renameFile( '" . addslashes( getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder ) . "', '" . addslashes( $file ) . "', '" . getFileExtension( $file ) . "' )\"><img src='/src/icons/edit.svg' /></button>
                    <button type='button' class='button primaryColor-Dark right shadow' onclick=\"deleteFile( '" . addslashes( getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder ) . "', '" . addslashes( $file ) . "' )\"><img src='/src/icons/bin.svg' /></button>
                </article>
            </section>
    ";
?>