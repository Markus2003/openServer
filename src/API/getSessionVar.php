<?php
    session_start();
    if ( isset( $_SESSION["openServerUsername"] ) and isset( $_GET["command"] ) )
        return $_SESSION["openServer" . $_GET["command"]];
?>