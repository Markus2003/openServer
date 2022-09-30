<?php
    session_start();
    if ( isset( $_SESSION["openServerFlags"] ) and isset( $_GET["newRelease"] ) ) {
        $json = json_decode( file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/res/updaterSettings.json' ), true );
        $json["currentChannel"] = $_GET["newRelease"];
        file_put_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/res/updaterSettings.json', json_encode( $json ) );
    }
?>