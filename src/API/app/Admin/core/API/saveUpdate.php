<?php
    session_start();
    if ( isset( $_SESSION["openServerUserpath"] ) ) {
        rename( $_SERVER["DOCUMENT_ROOT"] . '/update.zip', $_SERVER["DOCUMENT_ROOT"] . '/Personal Vault/' . $_SESSION["openServerUserpath"] . '/update.zip' );
    }
?>