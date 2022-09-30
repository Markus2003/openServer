<?php
    $instructions = json_decode( file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/res/databaseInstructions.json' ), true );
    $credentials = json_decode( file_get_contents( '../../src/configs/dbCredentials.json' ), true );
    $db = new mysqli( $credentials["host"], $credentials["username"], $credentials["password"], $credentials["defaultDB"] );
    $result = $db->query( 'SHOW TABLES FROM `' . $credentials["defaultDB"] . '`;' );
    foreach( $result->fetch_all()[0] as $table )
        if ( $db->query( 'DROP TABLE `' . $credentials["defaultDB"] . '`.`' . $table . '`;' ) != TRUE ) {
            throw new Exception("Error: Impossible to complete Table Wipe");
            exit();
        }
    $result = $db->query( 'SHOW TABLES FROM `' . $credentials["defaultDB"] . '`;' );
    if ( count( $result->fetch_all()[0] ) != 0 ) {
        throw new Exception("Error: Impossible to complete Table Wipe");
        exit();
    }
    foreach ( $instructions["instructions"] as $pass )
        if ( $db->query( $pass ) != TRUE ) {
            throw new Exception("Error: Impossible to Recreate Tables");
            exit();
        }
    $result = $db->query( 'SHOW TABLES FROM `' . $credentials["defaultDB"] . '`;' );
    if ( count( $result->fetch_all()[0] ) != $instructions["queryResultCheck"] ) {
        throw new Exception("Error: Impossible to Recreate Tables");
        exit();
    }
?>