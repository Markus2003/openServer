<?php
    session_start();
    if ( isset( $_SESSION["openServerEmail"] ) ) {
        include $_SERVER["DOCUMENT_ROOT"] . '/src/include/db_connect-Reader.inc.php';
        $result = $database->query("SELECT * FROM " . $credentials["defaultDatabase"] . ".users WHERE email='" . $_SESSION["openServerEmail"] . "';");
        $database->close();
        $result = $result->fetch_array();
        $_SESSION["openServerUsername"] = $result["username"];
        $_SESSION["openServerUserpath"] = $result["userpath"];
        $_SESSION["openServerFlags"] = $result["flags"];
    }
?>