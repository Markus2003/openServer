<div class='sectionTitle'><img src='src/icons/fileIcon.svg' alt='Tables Management Icon' />Tables Manager</div><hr>
<?php include '../src/include/customFunctions.inc.php' ?>
Current Database:
<select id='dbSelect'>
    <?php
        include '../src/include/dbConnect.inc.php';
        $result = $db->query("SHOW TABLES FROM " . $credentials["defaultDB"] . ";");
        $db->close();
        if ( $result->num_rows > 1 ) {
            foreach ( $result->fetch_all() as $row )
                foreach ( $row as $col ) {
                    if ( $col != 'users' and !isset( $first ) )
                        $first = $col;
                    if ( $col != 'users' )
                        echo "<option value='" . $col . "'>" . $col . '</option>';
                }
        }
    ?>
</select>
<div id='printTable'>
    We are loading the result, please wait...
</div>
<script>
    <?php echo "printTable('" . $first . "');" ?>

    $("#dbSelect").change(function () {
        printTable( $(this).children("option:selected").val() );
    });
    function printTable ( name ) {
        $('#printTable').html("We are loading the result, please wait...");
        $.ajax({
            url: 'core/API/printTable.php?tableName=' + name,
            type: 'GET',
            success: function (data) {
                $('#printTable').html(data);
                //console.log(fields);
            },
            error: function (data) {
                snackbarNotification('There was an error when trying connecting to the API<br>Try again in a few moments', 'hexError.svg');
                $('#printTable').html("<div class='error'><img src='src/icons/hexError.svg' width='96px' height='auto' alt='Hexagonal Error' /><h1>An Error has occurred</h1></div>");
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

    
</script>