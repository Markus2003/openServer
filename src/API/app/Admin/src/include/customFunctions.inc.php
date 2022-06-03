<?php
    function checkDatabaseCredentials ( $host=null, $username=null, $password=null, $defaultDB=null ) {
        if ( $host == null and $username == null and $password == null and $defaultDB == null ) {
            $credentials = json_decode(file_get_contents('src/configs/dbCredentials.json'), true);
            if ( $credentials["host"] != null and $credentials["username"] != null and $credentials["defaultDB"] != null ) {
                $db = new mysqli($credentials["host"], $credentials["username"], $credentials["password"], $credentials["defaultDB"]);
                if ( $db->connect_errno )
                    return FALSE;
                else
                    return TRUE;
            } else 
                return FALSE;
        } else {
            $db = new mysqli( $host, $username, $password, $defaultDB );
            if ( $db->connect_errno )
                return FALSE;
            else
                return TRUE;
        }
    }

    function printTable ( $table, $extra='' ) {
        include '../src/include/dbConnect.inc.php';
        $result = $db->query('SELECT * FROM ' . $credentials["defaultDB"] . '.' . $table . ' ' . $extra . ';');
        if ( !$result ) {
            echo printError('', 'Couldn\'t find Table \'' . $table . '\' in Database \'' . $credentials["defaultDB"] . '\'!');
            $db->close();
            return FALSE;
        } else {
            $fields = [];
            for ( $i = 0; $i != $result->field_count; $i++ )
                array_push( $fields, $result->fetch_field()->name );
            echo "
                <table id='queryResult'>
                    <tr>
                        <th class='checkBox'><input type='checkbox' id='checkEverything' onclick=\"$('.checkboxRow').prop('checked', $(this).is(':checked'));\" /></th>
            ";
            for ( $i = 0; $i != count( $fields ); $i++ )
                echo '<th>' . $fields[$i] . '</th>';
            echo "</tr>";
            for ( $i = 0; $i != $result->num_rows; $i++ ) {
                $row = $result->fetch_array();
                echo "<tr class='resultRow'><td><input type='checkbox' class='checkboxRow' rowId='" . $i . "' /></td>";
                foreach ( $fields as $field )
                    echo "<td><span class='canCopy " . $i . "'>" . $row[$field] . "</span></td>";
                echo "</tr>";
            }
            echo "</table>";
            $db->close();
            return $fields;
        }
    }

    function printTableFromResult ( $result ) {
        $fields = [];
        for ( $i = 0; $i != $result->field_count; $i++ )
            array_push( $fields, $result->fetch_field()->name );
        echo "
            <table id='queryResult'>
                <tr>
                    <th class='checkBox'><input type='checkbox' id='checkEverything' onclick=\"$('.checkboxRow').prop('checked', $(this).is(':checked'));\" /></th>
        ";
        for ( $i = 0; $i != count( $fields ); $i++ )
            echo '<th>' . $fields[$i] . '</th>';
        echo "</tr>";
        for ( $i = 0; $i != $result->num_rows; $i++ ) {
            $row = $result->fetch_array();
            echo "<tr class='resultRow'><td><input type='checkbox' class='checkboxRow' rowId='" . $i . "' /></td>";
            foreach ( $fields as $field )
                echo "<td><span class='canCopy " . $i . "'>" . $row[$field] . "</span></td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    function printDatabaseToolbar () {
        return "
            <button type='button' id='addNew' class='button actionQuery'><img src='src/icons/add.svg' alt='Edit Row' />Add</button>
            <button type='button' id='editSelected' class='button actionQuery'><img src='src/icons/edit.svg' alt='Edit Row' />Edit</button>
            <button type='button' id='deleteSelected' class='button actionQuery'><img src='src/icons/deleteForever.svg' alt='Delete Selection' />Delete</button>
        ";
    }

    function findStringInArray ( $array, $string ) {
        for ( $i = 0; $i != count( $array ); $i++ ) if ( $array[ $i ] == $string ) return TRUE;
        return FALSE;
    }

    function printDone () {
        return "<p class='done'><img alt='Done' width='48px' height='auto' /></p><br>";
    }

    function printWarning ( $id='', $text ) {
        return "<p id='" . $id . "' class='warning'><img alt='Triangle Warning' width='48px' height='auto' /><span>Warning: " . $text . "</span></p><br>";
    }

    function printError ( $id='', $text ) {
        return "<p id='" . $id . "' class='error'><img alt='Hexagonal Warning' width='48px' height='auto' /><span>Error: " . $text . "</span></p><br>";
    }
?>