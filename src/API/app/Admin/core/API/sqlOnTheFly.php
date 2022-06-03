<?php
    function spacesToNull ( $array ) {
        for ( $i = 0; $i != count( $array ) - 1; $i++ )
            if ( $array[$i] == '' )
                $array[$i] = "NULL";
        return $array;
    }

    function printFields ( $fields ) {
        $result = '';
        for ( $i = 0; $i != count( $fields ); $i++ ) if ( $i == count( $fields ) - 1 ) $result .= $fields[$i]; else $result .= $fields[$i] . ', ';
        return $result;
    }

    function printValues ( $fields ) {
        $fields = spacesToNull( $fields );
        $result = '';
        for ( $i = 0; $i != count( $fields ); $i++ ) if ( $i == count( $fields ) - 1 ) if ( $fields[$i] == "NULL" ) $result .= "NULL"; else $result .= "'" . $fields[$i] . "'"; else if ( $fields[$i] == "NULL" ) $result .= "NULL, "; else $result .= "'" . $fields[$i] . "', ";
        return $result;
    }

    function printValuesForIdent ( $fields, $data ) {
        $result = '';
        for ( $i = 0; $i != count( $fields ); $i++ ) if ( $i == count( $fields ) - 1 ) $result .= $fields[$i] . "='" . $data[$i] . "'"; else $result .= $fields[$i] . "='" . $data[$i] . "' AND ";
        return $result;
    }

    function printUpdateQuery ( $fields, $oldData, $newData ) {
        $oldData = spacesToNull( $oldData );
        $newData = spacesToNull( $newData );
        $result = '';
        for ( $i = 0; $i != count( $fields ); $i++ ) if ( $i == count( $fields ) - 1 ) if ( $newData[$i] == "NULL" ) $result .= $fields[$i] . "=NULL"; else $result .= $fields[$i] . "='" . $newData[$i] . "'"; else if ( $newData[$i] == "NULL" ) $result .= $fields[$i] . "=NULL, "; else $result .= $fields[$i] . "='" . $newData[$i] . "', ";
        $result .= ' WHERE ';
        for ( $i = 0; $i != count( $fields ); $i++ ) if ( $i == count( $fields ) - 1 ) if ( $oldData[$i] == "NULL" ) $result .= $fields[$i] . "=NULL"; else $result .= $fields[$i] . "='" . $oldData[$i] . "'"; else if ( $oldData[$i] == "NULL" ) $result .= $fields[$i] . "=NULL AND "; else $result .= $fields[$i] . "='" . $oldData[$i] . "' AND ";
        return $result;
    }

    if ( isset( $_GET["datas"] ) and isset( $_GET["type"] ) ) {
        $credentials = json_decode(file_get_contents('../../src/configs/dbCredentials.json'), true);
        $db = new mysqli( $credentials["host"], $credentials["username"], $credentials["password"], $credentials["defaultDB"] );
        $json = json_decode($_GET["datas"], true);
        switch ( $_GET["type"] ) {
            case 'INSERT':
                $result = $db->query("INSERT INTO " . $credentials["defaultDB"] . '.' . $json["table"] . " (" . printFields($json["fields"]) . ") VALUES (" . printValues($json["data"]) . ");");
                if ( !$result ) echo "Error: There was an Error while executing the Query\nINSERT INTO " . $credentials["defaultDB"] . '.' . $json["table"] . " (" . printFields($json["fields"]) . ") VALUES (" . printValues($json["data"]) . ");";
            break;

            case 'UPDATE':
                $result = $db->query("UPDATE " . $credentials["defaultDB"] . "." . $json["table"] . " SET " . printUpdateQuery( $json["fields"], $json["oldData"], $json["data"] ) . ";");
                if ( !$result ) echo 'Error: There was an Error while executing the Query';
            break;

            case 'DELETE':
                $result = $db->query("DELETE FROM " . $credentials["defaultDB"] . "." . $json["table"] . " WHERE " . printValuesForIdent( $json["fields"], $json["data"] ) . ";");
                if ( !$result ) echo 'Error: There was an Error while executing the Query';
            break;
        }
    }
?>