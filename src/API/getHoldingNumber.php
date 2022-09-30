<?php
    session_start();
    if ( isset( $_SESSION["openServerUserpath"] ) )
        if ( isset( $_SESSION["openServerFileHolding"] ) )
            print_r( json_encode( array( "count"=>count( $_SESSION["openServerFileHolding"] ), "type"=>$_SESSION["openServerFileHoldingType"] ) ) );
        else
            print_r( json_encode( array( "count"=>0, "type"=>null ) ) );
?>