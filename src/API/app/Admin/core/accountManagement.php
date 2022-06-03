<div class='sectionTitle'><img src='src/icons/accountManagement.svg' alt='User Management Icon' />User Management</div><hr>
<?php include '../src/include/customFunctions.inc.php' ?>
<div id='toolbar' style='padding-top: 0px'>
    <?php #if ( $fields ) echo printDatabaseToolbar() ?>
    <?php echo printDatabaseToolbar() ?>
</div>
<?php
    $fields = printTable('users');
?>
<!--<div id='toolbar'>
    <?php #if ( $fields ) echo printDatabaseToolbar() ?>
</div>-->
<script>
    var fields = [ <?php foreach ( $fields as $field ) echo '\'' . $field . '\', '; ?> ];
</script>
<script src='core/API/dbFunctions.js'></script>
<script>
    $('#addNew').click(function () {
        addNewRow('users', fields);
        updateView('accountManagement.php');
    });
    $('#editSelected').click(function () {
        if ( getSelectedRow().length == 1 ) {
            editRows('users', fields, getSelectedRow());
            updateView('accountManagement.php');
        } else if ( getSelectedRow().length > 1 )
            snackbarNotification('Warning: Multi-Row editing disabled<br>You can enable it by modifying the code in the page', 'warnIcon.svg')
    });
    $('#deleteSelected').click(function () {
        if ( getSelectedRow().length > 0 ) {
            deleteRows('users', fields, getSelectedRow());
            updateView('accountManagement.php');
        }
    });
</script>