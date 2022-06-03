<?php
    session_start();
    if ( isset( $_SESSION["openServerUsername"] ) and isset( $_GET["command"] ) )
        switch ( $_GET["command"] ) {
            case 'Userpath':
                if ( isset( $_GET["password"] ) ) {
                    include $_SERVER["DOCUMENT_ROOT"] . '/src/include/db_connect-Reader.inc.php';
                    $result = $database->query("SELECT userpath FROM " . $credentials["defaultDatabase"] . ".users WHERE email='" . $_SESSION["openServerEmail"] . "' AND password='" . sha1( $_GET["password"] ) . "';");
                    $database->close();
                    if ( $result->num_rows == 1 )
                        echo '/Personal Vault/' . $_SESSION["openServerUserpath"] . '/';
                    else
                        echo 'Error: Wrong Password inserted';
                } else {
                    echo 'Error: You have not inserted a Password';
                }
            break;

            default:
                echo $_SESSION["openServer" . $_GET["command"]];
        }
?>