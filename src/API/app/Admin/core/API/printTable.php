<?php
    function printSpecTable ( $table ) {
        $credentials = json_decode(file_get_contents('../../src/configs/dbCredentials.json'), true);
        $db = new mysqli( $credentials["host"], $credentials["username"], $credentials["password"], $credentials["defaultDB"] );
        $result = $db->query('SELECT * FROM ' . $credentials["defaultDB"] . '.' . $table . ';');
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

    if ( isset( $_GET["tableName"] ) ) {
        include '../../src/include/customFunctions.inc.php';
        echo "
            <div id='toolbar'>
                " . printDatabaseToolbar() . "
            </div>";
        $fields = printSpecTable( $_GET["tableName"] );
        #echo "
        #    <div style='display: flex;justify-content: flex-start;align-items: stretch;flex-direction: row;'>";
        #        if ( $fields ) echo printDatabaseToolbar();
        #echo "
        #    </div>";
    }
?>
<script src='core/API/dbFunctions.js'></script>
<script>
    var fields = [ <?php foreach ( $fields as $field ) echo '\'' . $field . '\', '; ?> ];

    $('#addNew').click(function () {
        console.log('belin');
        addNewRow($('#dbSelect').children("option:selected").val(), fields);
        updateView('tablesManagement.php');
    });
    $('#editSelected').click(function () {
        if ( getSelectedRow().length == 1 ) {
            editRows($('#dbSelect').children("option:selected").val(), fields, getSelectedRow());
            updateView('tablesManagement.php');
        } else if ( getSelectedRow().length > 1 )
            snackbarNotification('Warning: Multi-Row editing disabled<br>You can enable it by modifying the code in the page', 'warnIcon.svg')
    });
    $('#deleteSelected').click(function () {
        if ( getSelectedRow().length > 0 ) {
            deleteRows($('#dbSelect').children("option:selected").val(), fields, getSelectedRow());
            updateView('tablesManagement.php');
        }
    });
</script>