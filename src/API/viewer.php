<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"] . '/src/include/custom_functions.inc.php';

    function makeTheMagic( $finalPath, $file ){
        $mimeTypes = array(
            "html" => "text/html",
            "html" => "text/html",
            "doc" => "aplication/msword",
            "jpg" => "image/jpg",
            "gif" => "image/gif",
            "png" =>"image/png",
            "jpeg" => "image/jpg",
            "php" => "text/plain",
            "txt" => "text/plain",
            "sql" => "text/plain",
            "pdf" => "application/pdf"
        );
        if ( array_key_exists( strtolower( getFileExtension( $file ) ), $mimeTypes ) ) {
            header("Content-Type: " . $mimeTypes[ strtolower( getFileExtension( $file ) ) ]);
            header("Content-disposition: inline; filename=\"" . $file . "\"");
        } else {
            header("Location: /src/API/download.php?" . $_SERVER["QUERY_STRING"]);
            exit();
        }
        readfile( $finalPath );
    }

    if ( isset( $_GET["type"] ) ) {
        switch ( $_GET["type"] ) {
            case 'UUID':
                if ( isset( $_GET["UUID"] ) ) {
                    include $_SERVER["DOCUMENT_ROOT"] . '/src/include/db_connect-Reader.inc.php';
                    $result = $database->query("SELECT shareRegister.pathToShare, shareRegister.fileShared, users.userpath FROM " . $credentials["defaultDatabase"] . ".shareRegister INNER JOIN " . $credentials["defaultDatabase"] . ".users ON shareRegister.email=users.email WHERE shareRegister.shareUUID='" . $_GET["UUID"] . "';");
                    if ( $result->num_rows == 1 ) {
                        $result = $result->fetch_row();
                        if ( is_file( $_SERVER["DOCUMENT_ROOT"] . "/Personal Vault/" . $result[2] . $result[0] . $result[1] ) ) {
                            makeTheMagic( $_SERVER["DOCUMENT_ROOT"] . "/Personal Vault/" . $result[2] . $result[0] . $result[1], $result[1] );
                        } else http_response_code(404);
                    } else http_response_code(404);
                } else http_response_code(400);
            break;

            case 'VAULT':
                if ( isset( $_SESSION["openServerUserpath"] ) ) {
                    if ( isset( $_GET["path"] ) and isset( $_GET["filename"] ) ) {
                        if ( is_file( $_SERVER["DOCUMENT_ROOT"] . "/Personal Vault/" . $_SESSION["openServerUserpath"] . $_GET["path"] . $_GET["filename"] ) ) {
                            makeTheMagic( $_SERVER["DOCUMENT_ROOT"] . "/Personal Vault/" . $_SESSION["openServerUserpath"] . $_GET["path"] . $_GET["filename"], $_GET["filename"] );
                        } else http_response_code(404);
                    } else http_response_code(400);
                } else http_response_code(401);
            break;

            case 'REGULAR':
                if ( isset( $_GET["path"] ) and isset( $_GET["filename"] ) ) {
                    if ( is_file( $_SERVER["DOCUMENT_ROOT"] . $_GET["path"] . $_GET["filename"] ) ) {
                        makeTheMagic( $_SERVER["DOCUMENT_ROOT"] . $_GET["path"] . $_GET["filename"], $_GET["filename"] );
                    } else http_response_code(404);
                } else http_response_code(400);
            break;

            default:
                http_response_code(405);
        }
    } else http_response_code(400);
?>