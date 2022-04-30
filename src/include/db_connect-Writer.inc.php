<?php
    $credentials = json_decode( file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/res/databaseCredentials.json' ), true );
    $database = new mysqli( $credentials["writer"]["host"], $credentials["writer"]["username"], $credentials["writer"]["password"], $credentials["defaultDatabase"] );
    #if ( $database->connect_errno ) {                                                   #Valutare la possibilità di reindirizzare ad una pagina dedicata all'errore
    #    echo "Error: Not Connected To Databse (Writer)";
    #    #header("Location: " . $subFolder . "errors/500.php");
    #    exit();
    #}
?>