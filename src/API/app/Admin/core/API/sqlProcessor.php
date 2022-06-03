<?php include '../../src/include/customFunctions.inc.php' ?>
<?php
    if ( isset( $_POST["query"] ) ) {
        $credentials = json_decode(file_get_contents('../../src/configs/dbCredentials.json'), true);
        $db = new mysqli( $credentials["host"], $credentials["username"], $credentials["password"], $credentials["defaultDB"] );
        $result = $db->query($_POST["query"]);
        if ( !$result )
            echo printError('', "Query failed to run, check for syntax error");
        else
            if ( findStringInArray( explode(' ', strtoupper($_POST["query"])), "SELECT" ) || findStringInArray( explode(' ', strtoupper($_POST["query"])), "SHOW" ) )
                printTableFromResult( $result );
            else
                echo printDone();
    }
?>