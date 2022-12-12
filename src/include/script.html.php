<script src='/src/script.js'></script>
<script src='/src/m3.js'></script>
<?php
    if ( !is_file( $_SERVER["DOCUMENT_ROOT"] . '/src/res/databaseCredentials.json' ) ) {
        fopen( $_SERVER["DOCUMENT_ROOT"] . '/src/res/databaseCredentials.json', "w" );
        include $_SERVER["DOCUMENT_ROOT"] . '/src/include/fab.html.php';
    } else {
        include $_SERVER["DOCUMENT_ROOT"] . '/src/include/db_connect-Reader.inc.php';
        if ( $database->connect_error ) {
            $database->close();
            include $_SERVER["DOCUMENT_ROOT"] . '/src/include/fab.html.php';
        } else {
            $database->close();
            include $_SERVER["DOCUMENT_ROOT"] . '/src/include/db_connect-Writer.inc.php';
            if ( $database->connect_error ) {
                $database->close();
                include $_SERVER["DOCUMENT_ROOT"] . '/src/include/fab.html.php';
            } else {
                include $_SERVER["DOCUMENT_ROOT"] . '/src/include/db_connect-Writer.inc.php';
                $instructions = json_decode( file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/res/databaseInstructions.json' ), true );
                $result = $database->query( $instructions["queryCheck"] );
                if ( !$result ) {
                    $database->close();
                    include $_SERVER["DOCUMENT_ROOT"] . '/src/include/fab.html.php';
                } else if ( $result->num_rows != $instructions["queryResultCheck"] ) {
                    $database->close();
                    include $_SERVER["DOCUMENT_ROOT"] . '/src/include/fab.html.php';
                }
            }
        }
    }
?>