<?php
    chdir( $_SERVER["DOCUMENT_ROOT"] );
    $zip = new ZipArchive;
    if ( $zip->open('update.zip') === TRUE ) {
        #$zip->extractTo('.');
        $zip->close();
        unlink( 'update.zip' );
        if ( is_file( $_SERVER["DOCUMENT_ROOT"] . '/garbageCollector.php' ) )
            include $_SERVER["DOCUMENT_ROOT"] . '/garbageCollector.php';
        echo 'Update installed Successfully!';
    } else
        echo 'Update not installed';
?>