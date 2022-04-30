<?php
    if ( isset( $_GET["path"] ) and isset( $_GET["fileName"] ) ) {

        if ( is_file( $_SERVER["DOCUMENT_ROOT"] . $_GET["path"] . $_GET["fileName"] ) ) {

            #if ( checkBlacklistFile( $_GET["fileName"] ) ) {

                chdir( $_SERVER["DOCUMENT_ROOT"] . $_GET["path"] );
                unlink( $_GET["fileName"] );
                echo 'Success: File \'' . $_GET["fileName"] . '\' deleted';

            #} else
            #    echo 'Error: Folder Name \'' . $_GET["fileName"] . '\' is prohibited';

        } else
            echo 'Error: File \'' . $_GET["fileName"] . '\' does not exist in path \'' . $_GET["path"] . '\'';

    }
?>