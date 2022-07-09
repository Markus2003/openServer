<?php
    try {
        $file = fopen( $_SERVER["DOCUMENT_ROOT"] . '/src/res/databaseCredentials.json', "w" );
        $writer = [ "host" => $_POST["host"], "username" => $_POST["writerUsername"], "password" => $_POST["writerPassword"] ];
        $reader = [ "host" => $_POST["host"], "username" => $_POST["readerUsername"], "password" => $_POST["readerPassword"] ];
        $defaultDatabse = "openServer";
        fwrite( $file, json_encode( [ "writer" => $writer, "reader" => $reader, "defaultDatabase" => $defaultDatabse ] ) );
        fclose( $file );
        include $_SERVER["DOCUMENT_ROOT"] . '/src/include/db_connect-Writer.inc.php';
        if ( $database->connect_error ) {
            $database->close();
            echo "Error: Credentials not valid";
            exit();
        } else {
            $instructions = json_decode( file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/res/databaseInstructions.json' ), true );
            $result = $database->query( $instructions["queryCheck"] );
            if ( $result->num_rows != count( $instructions['instructions'] ) ) {
                foreach ( $result->fetch_row() as $row )
                    $database->query("DROP TABLE " . $credentials["defaultDatabase"] . '.' . $row . ';' );
                foreach ( $instructions['instructions'] as $proced )
                    $database->query( $proced );
                $result = $database->query( $instructions["queryCheck"] );
                if ( $result->num_rows == count( $instructions['instructions'] ) ) {    
                    $database->close();
                    echo "Success: Everything is fine, you can now use 'openServer'!";
                    exit();
                } else {
                    $database->close();
                    echo "Error: There was an error while creating the Database Structure";
                    exit();
                }
            } else {
                $database->close();
                echo "Success: Everything is fine, you can now use 'openServer'!";
                exit();
            }
        }
    } catch ( Exception $e ) {
        echo "Error: The was an error process, cannot continue";
        exit();
    }
?>