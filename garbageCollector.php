<?php
    include $_SERVER["DOCUMENT_ROOT"] . '/src/include/custom_functions.inc.php';
    $filesToDelete = [
    ];
    $foldersToDelete = [
    ];
    $queryToRun = [
        "ALTER TABLE `shareRegister` CHANGE `shareUUID` `shareUUID` VARCHAR(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;"
    ];
    if ( count( $filesToDelete ) > 0 )
        foreach ( $filesToDelete as $file )
            if ( is_file( $file ) )
                unlink( $_SERVER["DOCUMENT_ROOT"] . $file );
    if ( count( $foldersToDelete ) > 0 )
        foreach ( $foldersToDelete as $folder )
            if ( is_dir( $folder ) )
                rrmdir( $_SERVER["DOCUMENT_ROOT"] . $folder );
    if ( count( $queryToRun ) > 0  ) {
        include $_SERVER["DOCUMENT_ROOT"] . '/src/include/db_connect-Writer.inc.php';
        foreach ( $queryToRun as $query )
            $database->query( $query );
        $database->close();
    }
    unlink( $_SERVER["DOCUMENT_ROOT"] . '/garbageCollector.php' );
?>