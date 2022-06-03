<?php
    if ( isset( $_GET["password"] ) ) {
        session_start();
        include $_SERVER["DOCUMENT_ROOT"] . '/src/include/custom_functions.inc.php';
        include $_SERVER["DOCUMENT_ROOT"] . '/src/include/db_connect-Reader.inc.php';
        $result = $database->query("SELECT * FROM " . $credentials["defaultDatabase"] . ".users WHERE email='" . $_SESSION["openServerEmail"] . "' AND password='" . sha1( $_GET["password"] ) . "';");
        $database->close();
        if ( $result->num_rows == 1 ) {
            include $_SERVER["DOCUMENT_ROOT"] . '/src/include/db_connect-Writer.inc.php';
            system('python3 ' . $_SERVER["DOCUMENT_ROOT"] . '/src/API/python/sendEmail.py \'' . $_SERVER["DOCUMENT_ROOT"] . '\' \'' . $_SESSION["openServerEmail"] . '\' \'goodbye\'');
            $database->query("DELETE FROM " . $credentials["defaultDatabase"] . ".users WHERE email='" . $_SESSION["openServerEmail"] . "';");
            $database->close();
            rrmdir( $_SERVER["DOCUMENT_ROOT"] . '/Personal Vault/' . $_SESSION["openServerUserpath"] );
            include $_SERVER["DOCUMENT_ROOT"] . '/src/API/logout.php';
        }
    }
?>