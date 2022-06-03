<?php
    session_start();
    include $_SERVER["DOCUMENT_ROOT"] . '/src/include/custom_functions.inc.php';
    if ( isset( $_POST["username"] ) and isset( $_POST["email"] ) and isset( $_POST["username"] ) and isset( $_POST["password"] ) and isset( $_POST["repeatedPassword"] ) ) {
        include $_SERVER["DOCUMENT_ROOT"] . '/src/include/db_connect-Reader.inc.php';
        $result = $database->query("SELECT username, userpath, flags FROM " . $credentials["defaultDatabase"] . ".users WHERE email='" . $database->real_escape_string( $_POST["email"] ) . "' AND password='" . sha1( $database->real_escape_string( $_POST["password"] ) ) . "';" );
        $database->close();
        if ( $result->num_rows <= 0 and !$database->connect_error ) {
            do
                $userpath = generateUserpath();
            while ( checkIfUserpathExist( $userpath ) );
            include $_SERVER["DOCUMENT_ROOT"] . '/src/include/db_connect-Writer.inc.php';
            $result = $database->query("INSERT INTO " . $credentials["defaultDatabase"] . ".users (email, password, username, userpath, flags) VALUES (\"" . $database->real_escape_string( $_POST["email"] ) . "\", \"" . sha1( $database->real_escape_string( $_POST["password"] ) ) . "\", \"" . $database->real_escape_string( $_POST["username"] ) . "\", \"" . $userpath . "\", \"0\");");
            $database->close();
            mkdir( $_SERVER["DOCUMENT_ROOT"] . '/Personal Vault/' . $userpath, 0777 );
            system('python3 ' . $_SERVER["DOCUMENT_ROOT"] . '/src/API/python/sendEmail.py \'' . $_SERVER["DOCUMENT_ROOT"] . '\' \'' . $_POST["email"] . '\' \'greetings\'');
            echo "Success: user '" . $_POST["username"] . "' registered correctly";
        } elseif ( $result->num_rows == 1 and !$database->connect_error ) {
            echo "Error: User already exist";
        } else {
            echo "Error: An unknown error has occurred";
        }
    } elseif ( isset( $_POST["email"] ) and isset( $_POST["password"] ) ) {
        include $_SERVER["DOCUMENT_ROOT"] . '/src/include/db_connect-Reader.inc.php';
        $result = $database->query("SELECT username, userpath, flags FROM " . $credentials["defaultDatabase"] . ".users WHERE email='" . $database->real_escape_string( $_POST["email"] ) . "' AND password='" . sha1( $database->real_escape_string( $_POST["password"] ) ) . "';" );
        $database->close();
        if ( $result->num_rows == 1 and !$database->connect_error ) {
            $result = $result->fetch_array();
            $_SESSION["openServerUsername"] = $result["username"];
            $_SESSION["openServerEmail"] = $_POST["email"];
            $_SESSION["openServerUserpath"] = $result["userpath"];
            $_SESSION["openServerFlags"] = $result["flags"];
            echo "Success: Log-In successfull";
        } elseif ( $result->num_rows <= 0 and !$database->connect_error ) {
            echo "Error: User not found";
        } else {
            echo "Error: An unknown error has occurred";
        }
    }
?>