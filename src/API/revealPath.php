<?php
    if ( isset( $_GET['email'] ) and isset( $_GET['password'] ) ) {
        include $_SERVER['DOCUMENT_ROOT'] . '/src/include/db_connect-Reader.inc.php';
        $result = $database->query("SELECT userpath FROM " . $credentials["defaultDatabase"] . ".users FROM email='" . $_GET["email"] . "' AND password='" . $_GET["password"] . "';");
        echo $result->fetch_all()[0];
    } else {
        echo "Error: You seem to don't have permission to view this info";
    }
?>