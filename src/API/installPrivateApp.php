<?php
    session_start();
    if ( isset( $_SESSION["openServerEmail"] ) ) {
        if ( !is_dir( $_SERVER['DOCUMENT_ROOT'] . '/Personal Vault/' . $_SESSION["openServerUserpath"] . '/.privateApps/' . explode( '.', $_GET["appName"] )[0] . '/' ) ) {
            $fileName = $_GET["appName"];
            chdir( $_SERVER['DOCUMENT_ROOT'] . '/Personal Vault/' . $_SESSION["openServerUserpath"] . '/.privateApps' );
            mkdir( explode(  '.', $fileName )[0], 0777 );
            $zip = new ZipArchive;
            if ( $zip->open( $_SERVER["DOCUMENT_ROOT"] . '/Personal Vault/' . $_SESSION["openServerUserpath"] . '/' . $fileName ) === TRUE ) {
                $zip->extractTo( explode( '.', $fileName)[0] . '/.');
                $zip->close();
                unlink( $fileName );
                #echo 'Update installed Successfully!';
                echo 'Success: App installed';
            } else
                #echo 'Update not installed';
                echo 'Error: Unexpected Error during App extraction';
        } else
            echo 'Error: App already exist';
    }
?>