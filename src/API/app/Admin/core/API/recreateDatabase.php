<?php
    $instructions = json_decode( file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/res/databaseInstructions.json' ), true );
    $credentials = json_decode( file_get_contents( '../src/configs/dbCredentials.json' ), true );
    $db = new mysqli( $credentials["host"], $credentials["username"], $credentials["password"], $credentials["defaultDB"] );
    #$result = $db->query( $instructions['preparationInstructions'] );
    $result = $db->query( 'SHOW TABLES FROM `openServer`;' );
    if ( $result->num_rows > 0 ) {
        $result = $result->fetch_all();
        print_r( $result );
    }
    #TODO: Code to delete every table
?>