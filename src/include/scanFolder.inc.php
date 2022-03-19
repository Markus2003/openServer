<?php
    $rawFolder = scandir( $_SERVER["DOCUMENT_ROOT"] . $_SERVER["REQUEST_URI"] );
    $folderList = [];
    $fileList = [];
    foreach ( $rawFolder as $chunk )
        if ( is_dir( $chunk ) and checkBlacklistFolder( $chunk ) )
            array_push( $folderList, $chunk );
        else if ( is_file( $chunk ) and checkBlacklistFile( $chunk ) )
            array_push( $fileList, $chunk );
?>