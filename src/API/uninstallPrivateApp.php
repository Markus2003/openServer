<?php
    session_start();
    if ( isset( $_GET["appName"] ) ) {
        try {
            chdir( $_SERVER["DOCUMENT_ROOT"] . '/Personal Vault/' . $_SESSION["openServerUserpath"] . '/.privateApps/' );
            include $_SERVER["DOCUMENT_ROOT"] . '/src/include/custom_functions.inc.php';
            rrmdir( $_GET["appName"] );
            echo "Success: Uninstall completed";
        } catch (\Throwable $th) {
            echo "Error: Uninstall failed";
        }
        exit();
    } else {
        echo "Error: No App selected";
        exit();
    }
?>