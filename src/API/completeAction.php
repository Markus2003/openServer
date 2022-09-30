<?php
    session_start();
    if ( isset( $_SESSION["openServerFileHolding"] ) and isset( $_SESSION["openServerFileHoldingType"] ) and isset( $_GET["path"] ) and isset( $_SESSION["openServerUserpath"] ) ) {
        foreach ( $_SESSION["openServerFileHolding"] as $file )
            switch ( $_SESSION["openServerFileHoldingType"] ) {
                case 'COPY':
                    copy( $_SERVER["DOCUMENT_ROOT"] . $file, $_SERVER["DOCUMENT_ROOT"] . $_GET["path"] . explode( '/', $file )[ count( explode( '/', $file ) ) - 1 ] );
                break;
                
                case 'MOVE':
                    rename( $_SERVER["DOCUMENT_ROOT"] . $file, $_SERVER["DOCUMENT_ROOT"] . $_GET["path"] . explode( '/', $file )[ count( explode( '/', $file ) ) - 1 ] );
                break;
            }
        unset( $_SESSION["openServerFileHolding"] );
        unset( $_SESSION["openServerFileHoldingType"] );
    }
?>