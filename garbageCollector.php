<?php
    include $_SERVER["DOCUMENT_ROOT"] . '/src/include/custom_functions.inc.php';
    $filesToDelete = [
    ];
    $foldersToDelete = [
    ];
    if ( count( $filesToDelete ) > 0 )
        foreach ( $filesToDelete as $file )
            if ( is_file( $file ) )
                unlink( $_SERVER["DOCUMENT_ROOT"] . $file );
    if ( count( $foldersToDelete ) > 0 )
        foreach ( $foldersToDelete as $folder )
            if ( is_dir( $folder ) )
                rrmdir( $_SERVER["DOCUMENT_ROOT"] . $folder );
    unlink( $_SERVER["DOCUMENT_ROOT"] . '/garbageCollector.php' );
?>