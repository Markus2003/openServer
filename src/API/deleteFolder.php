<?php
    if ( isset( $_GET["path"] ) and isset( $_GET["folderName"] ) ) {
        include $_SERVER["DOCUMENT_ROOT"] . '/src/include/custom_functions.inc.php';

        if ( is_dir( $_SERVER["DOCUMENT_ROOT"] . $_GET["path"] . $_GET["folderName"] ) ) {
                chdir( $_SERVER["DOCUMENT_ROOT"] . $_GET["path"] );
                rrmdir( $_GET["folderName"] );
                echo 'Success: Folder \'' . $_GET["folderName"] . '\' deleted';
        } else
            echo 'Error: Folder \'' . $_GET["folderName"] . '\' does not exist in path \'' . $_GET["path"] . '\'';

    }
?>