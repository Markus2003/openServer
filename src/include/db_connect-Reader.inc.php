<?php
    $credentials = json_decode( file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/res/databaseCredentials.json' ), true );
    $database = new mysqli( $credentials["reader"]["host"], $credentials["reader"]["username"], $credentials["reader"]["password"], $credentials["defaultDatabase"] );
?>