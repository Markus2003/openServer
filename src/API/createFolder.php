<?php
    include $_SERVER["DOCUMENT_ROOT"] . '/src/include/custom_functions.inc.php';

    if ( isset( $_GET["path"] ) and isset( $_GET["folderName"] ) ) {

        if ( !is_dir( $_SERVER["DOCUMENT_ROOT"] . $_GET["path"] . $_GET["folderName"] ) ) {

            if ( checkBlacklistFolder( $_GET["folderName"] ) ) {

                chdir( $_SERVER["DOCUMENT_ROOT"] . $_GET["path"] );
                mkdir( $_GET["folderName"], 0777 );
                echo 'Success: Folder \'' . $_GET["folderName"] . '\' created';

            } else
                echo 'Error: Folder Name \'' . $_GET["folderName"] . '\' is prohibited';

        } else
            echo 'Error: Folder \'' . $_GET["folderName"] . '\' already exist in path \'' . $_GET["path"] . '\'';

    }
?>