<?php
    try {
        $file = fopen( $_SERVER["DOCUMENT_ROOT"] . '/src/res/databaseCredentials.json', "w" );
        $writer = [ "host" => $_POST["host"], "username" => $_POST["writerUsername"], "password" => $_POST["writerPassword"] ];
        $reader = [ "host" => $_POST["host"], "username" => $_POST["readerUsername"], "password" => $_POST["readerPassword"] ];
        $defaultDatabse = $_POST["databaseName"];
        fwrite( $file, json_encode( [ "writer" => $writer, "reader" => $reader, "defaultDatabase" => $defaultDatabse ] ) );
        fclose( $file );
        include $_SERVER["DOCUMENT_ROOT"] . '/src/include/db_connect-Writer.inc.php';
        if ( $database->connect_error ) {
            $database->close();
            echo "Error: Credentials not valid";
            exit();
        } else {
            $result = $database->query("SHOW TABLES FROM " . $credentials["defaultDatabase"] . ';' );
            if ( $result->num_rows > 1 ) {
                foreach ( $result->fetch_row() as $row )
                    $database->query("DROP TABLE " . $credentials["defaultDatabase"] . '.' . $row . ';' );
                $result = $database->query("CREATE TABLE `users` (`email` varchar(320) NOT NULL,`password` varchar(255) NOT NULL,`username` varchar(30) NOT NULL,`userpath` varchar(15) NOT NULL,`flags` tinyint(1) NOT NULL DEFAULT 0) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                if ( !$result ) {
                    $database->close();
                    echo "Error: There was an error while creating the Database Structure";
                    exit();
                } else {
                    $result = $database->query("ALTER TABLE `users` ADD PRIMARY KEY (`email`); COMMIT;");
                    if ( !$result ) {
                        $database->close();
                        echo "Error: There was an error while creating the Database Structure";
                        exit();
                    } else {
                        $database->close();
                        echo "Success: Everything is fine, you can now use 'openServer'!";
                        exit();
                    }
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