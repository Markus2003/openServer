<?php
    session_start();
    if ( isset( $_SESSION["openServerUserpath"] ) and isset( $_GET["type"] ) ) {
        include $_SERVER["DOCUMENT_ROOT"] . '/src/include/custom_functions.inc.php';
        switch ( $_GET["type"] ) {
            case 'ADD':
                if ( isset( $_GET["pathToShare"] ) and isset( $_GET["fileShared"] ) ) {
                    include $_SERVER["DOCUMENT_ROOT"] . '/src/include/db_connect-Reader.inc.php';
                    $result = $database->query("SELECT * FROM " . $credentials["defaultDatabase"] . ".shareRegister WHERE email='" . $_SESSION["openServerEmail"] . "' AND pathToShare='" . $_GET["pathToShare"] . "' AND fileShared='" . $_GET["fileShared"] . "';");
                    $database->close();
                    if ( $result->num_rows == 0 ) {
                        $UUID = generateUIID();
                        include $_SERVER["DOCUMENT_ROOT"] . '/src/include/db_connect-Writer.inc.php';
                        $database->query("INSERT INTO `shareRegister` (`shareUUID`, `email`, `pathToShare`, `fileShared`) VALUES ('" . $UUID . "', '" . $_SESSION["openServerEmail"] . "', '" . $_GET["pathToShare"] . "', '" . $_GET["fileShared"] . "')");
                        $database->close();
                        http_response_code(200);
                    } else http_response_code(404);
                } else http_response_code(405);
            break;

            case 'REMOVE':
                if ( isset( $_GET["pathToShare"] ) and isset( $_GET["fileShared"] ) ) {
                    include $_SERVER["DOCUMENT_ROOT"] . '/src/include/db_connect-Writer.inc.php';
                    $database->query("DELETE FROM `shareRegister` WHERE email='" . $_SESSION["openServerEmail"] . "' AND pathToShare='" . $_GET["pathToShare"] . "' AND fileShared='" . $_GET["fileShared"] . "';");
                    $database->close();
                    http_response_code(200);
                } else http_response_code(405);
            break;

            case 'OPTIMIZE':
                include $_SERVER["DOCUMENT_ROOT"] . '/src/include/db_connect-Reader.inc.php';
                $result = $database->query("SELECT * FROM " . $credentials["defaultDatabase"] . ".shareRegister WHERE email='" . $_SESSION["openServerEmail"] . "';");
                $database->close();
                if ( $result->num_rows != 0 ) {
                    foreach ( $result->fetch_all() as $row ) {
                        if ( !is_file( $_SERVER["DOCUMENT_ROOT"] . "/Personal Vault/" . $_SESSION["openServerUserpath"] . $row[2] . $row[3] ) ) {
                            include $_SERVER["DOCUMENT_ROOT"] . '/src/include/db_connect-Writer.inc.php';
                            $database->query("DELETE FROM `shareRegister` WHERE shareUUID='" . $row[0] . "';");
                            $database->close();
                        }
                    }
                }
                http_response_code(200);
            break;

            default:
                http_response_code(405);
        }
    } else http_response_code(405);
?>