<?php
    chdir( $_SERVER["DOCUMENT_ROOT"] );
    if ( is_file( 'update.zip' ) ) {
        echo '200';
        exit();
    }
    $guessUrl = [ $_GET["newVer"], 'BETA.zip', 'ALPHA.zip' ];
    foreach ( $guessUrl as $url ) {
        $headers = @get_headers('https://github.com/Markus2003/openServer/archive/refs/tags/' . $url);
        if($headers && strpos( $headers[18], '404')) {
            continue;
        } else {
            file_put_contents( 'update.zip', file_get_contents( 'https://github.com/Markus2003/openServer/archive/refs/tags/' . $url ) );
            echo '200';
            exit();
        }
    }
    echo '404';
?>