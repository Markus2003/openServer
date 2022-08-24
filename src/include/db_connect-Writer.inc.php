<?php
    $credentials = json_decode( file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/res/databaseCredentials.json' ), true );
    $database = new mysqli( $credentials["writer"]["host"], $credentials["writer"]["username"], $credentials["writer"]["password"], $credentials["defaultDatabase"] );
?>
