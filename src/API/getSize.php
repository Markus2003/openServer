<?php
    if ( isset( $_GET["type"] ) and isset( $_GET["location"] ) ) {
        include $_SERVER["DOCUMENT_ROOT"] . '/src/include/custom_functions.inc.php';
        switch ( $_GET["type"] ) {
            case "folder":
                echo formatSize( foldersize( $_SERVER["DOCUMENT_ROOT"] . $_GET["location"] ) );
            break;

            case "file":
                echo formatSize( filesize( $_SERVER["DOCUMENT_ROOT"] . $_GET["location"] ) );
            break;
        }
    }
?>