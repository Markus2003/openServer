<?php
    session_start();
    if ( isset( $_SESSION["openServerFileHoldingType"] ) ) {
        if ( $_SESSION["openServerFileHoldingType"] == $_GET["type"] ) {
            if ( isset( $_SESSION["openServerFileHolding"] ) ) {
                array_push( $_SESSION["openServerFileHolding"], $_GET["path"] );
            } else {
                $_SESSION["openServerFileHolding"] = [ $_GET["path"] ];
            }
        } else {
            $_SESSION["openServerFileHoldingType"] = $_GET["type"];
            $_SESSION["openServerFileHolding"] = [ $_GET["path"] ];
        }
    } else {
        $_SESSION["openServerFileHoldingType"] = $_GET["type"];
        $_SESSION["openServerFileHolding"] = [ $_GET["path"] ];
    }
?>