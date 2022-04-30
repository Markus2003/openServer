<?php
    if ( !isset( $overrideFolder ) )
        $overrideFolder = '';
    #$rawFolder = scandir( $_SERVER["DOCUMENT_ROOT"] . getInServerAddress( $_SERVER["REQUEST_URI"] ) . $overrideFolder );
    $rawFolder = scandir( $_SERVER["DOCUMENT_ROOT"] . getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder );
    $folderList = [];
    $fileList = [];
    foreach ( $rawFolder as $chunk )
        if ( is_dir( $_SERVER["DOCUMENT_ROOT"] . getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder . $chunk ) and checkBlacklistFolder( $chunk ) )
            array_push( $folderList, $chunk );
        else if ( is_file( $_SERVER["DOCUMENT_ROOT"] . getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder . $chunk ) and checkBlacklistFile( $chunk ) )
            array_push( $fileList, $chunk );
?>