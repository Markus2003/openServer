<?php
    if ( isset( $_GET["host"] ) and isset( $_GET["defaultDB"] ) and isset( $_GET["username"] ) and isset( $_GET["password"] ) ) {
        include '../../src/include/customFunctions.inc.php';
        if ( checkDatabaseCredentials( $_GET["host"], $_GET["username"], $_GET["password"], $_GET["defaultDB"] ) ) {
            file_put_contents('../../src/configs/dbCredentials.json', json_encode(array( 'host' => $_GET["host"], 'username' => $_GET["username"], 'password' => $_GET["password"], 'defaultDB' => $_GET["defaultDB"] )));
            if ( checkDatabaseCredentials() )
                echo '0x000';
            else
                echo '0x001';
        } else {
            echo '0x999';
        }
    }
?>