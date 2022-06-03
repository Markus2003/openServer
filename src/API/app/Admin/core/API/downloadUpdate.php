<?php
    chdir( $_SERVER["DOCUMENT_ROOT"] );
    if ( is_file( 'update.zip' ) ) {
        echo '200';
        exit();
    }
    $headers = @get_headers('https://github.com/Markus2003/openServer/releases/download/' . $_GET["newVer"] . '/' . $_GET["newVer"] . '.zip');
    if($headers && strpos( $headers[18], '404')) {
        echo '404';
    } else {
        file_put_contents( 'update.zip', file_get_contents( 'https://github.com/Markus2003/openServer/releases/download/' . $_GET["newVer"] . '/' . $_GET["newVer"] . '.zip' ) );
        echo '200';
    }
?>