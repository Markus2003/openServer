<?php
    session_start();
    if ( isset( $_SESSION["openServerUsername"] ) and isset( $_GET["password"] ) ) {
        include $_SERVER["DOCUMENT_ROOT"] . '/src/include/custom_functions.inc.php';
        include $_SERVER["DOCUMENT_ROOT"] . '/src/include/db_connect-Writer.inc.php';
        do $userpath = generateUserpath(); while ( checkIfUserpathExist( $userpath ) );
        $database->query("UPDATE " . $credentials["defaultDatabase"] . ".users SET userpath='" . $userpath . "' WHERE email='" . $_SESSION["openServerEmail"] . "' AND password='" . sha1( $_GET["password"] ) . "';");
        $database->close();
        chdir( $_SERVER["DOCUMENT_ROOT"] . '/Personal Vault/' );
        rename( $_SESSION["openServerUserpath"], $userpath );
        include $_SERVER["DOCUMENT_ROOT"] . '/src/API/updateSession.php';
        system('python3 ' . $_SERVER["DOCUMENT_ROOT"] . '/src/API/python/sendEmail.py \'' . $_SERVER["DOCUMENT_ROOT"] . '\' \'' . $_SESSION["openServerEmail"] . '\' \'userpathUpdated\'');
        echo '0x00';
    } else
        echo '0x99';
?>