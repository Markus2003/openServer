<?php
    if ( isset( $_GET["appName"] ) ) {
        $systemApp = json_decode( file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/res/systemApps.json' ), true );
        foreach ( $systemApp["sysApps"] as $app )
            if ( $_GET["appName"] == $app ) {
                echo "Error: Operation not permitted. System app uninstall not allowed.";
                exit();
            }
        try {
            chdir( $_SERVER["DOCUMENT_ROOT"] . '/Applications/' );
            system('rm -rf \'' . $_GET["appName"] . '/\'');
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