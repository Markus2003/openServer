<?php
    if ( isset( $_GET["type"] ) )
        switch ( $_GET["type"] ) {
            case 'Films':
                foreach ( scandir( $_SERVER["DOCUMENT_ROOT"] . '/Films/posters' ) as $chunk )
                    if ( is_file( $_SERVER["DOCUMENT_ROOT"] . '/Films/posters/' . $chunk ) )
                        unlink( $_SERVER["DOCUMENT_ROOT"] . '/Films/posters/' . $chunk );
            break;

            case 'Update':
                if ( is_file( $_SERVER["DOCUMENT_ROOT"] . '/update.zip' ) )
                    unlink( $_SERVER["DOCUMENT_ROOT"] . '/update.zip' );
            break;

            case 'Personal Vault':
                include $_SERVER["DOCUMENT_ROOT"] . '/src/include/custom_functions.inc.php';
                foreach ( scandir( $_SERVER["DOCUMENT_ROOT"] . '/Personal Vault/' ) as $chunk )
                    if ( is_dir( $_SERVER["DOCUMENT_ROOT"] . '/Personal Vault/' . $chunk ) and $chunk != '.' and $chunk != '..' ) {
                        $credentials = json_decode(file_get_contents('../../src/configs/dbCredentials.json'), true);
                        $db = new mysqli( $credentials["host"], $credentials["username"], $credentials["password"], $credentials["defaultDB"] );
                        $result = $db->query("SELECT * FROM " . $credentials["defaultDB"] . ".users WHERE userpath='" . $chunk . "';");
                        $db->close();
                        if ( $result )
                            if ( $result->num_rows == 0 )
                                rrmdir( $_SERVER["DOCUMENT_ROOT"] . '/Personal Vault/' . $chunk );
                    }
            break;
        }
?>