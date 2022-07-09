<div class='sectionTitle'><img src='src/icons/restoreOption.svg' alt='Restore Option' />Restore Option</div><hr>
<?php include '../src/include/customFunctions.inc.php' ?>

<style>
    #restoreOptions {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        row-gap: 45px;
    }

    #restoreOptions > div {
        display: flex;
        flex-direction: column;
        row-gap: 5px;
    }
</style>

<div id='restoreOptions'>
    <div>
        This Section is in BETA, continue at your own risk
    </div>
    <div>
        Changed Database Credential?
        <button type='button' id='restoreCredentials' class='button primaryColor'><img src='src/icons/credentials.svg' alt='Restore Credentials' />Restore Database Credentials</button>
    </div>
    <div>
        Unable to use Database?
        <button type='button' id='recreateDatabase' class='button primaryColor'><img src='src/icons/database.svg' alt='Restore Database' />Restore Database Structure (Not Working yet)</button>
    </div>
    <div>
        Update gone in the wrong way?
        <button type='button' class='button loremIpsum primaryColor'><img src='src/icons/restore.svg' alt='Restore Server' />Restore Server (Not Working yet)</button>
    </div>
    <div>
        openServer isn't for you?
        <button type='button' class='button loremIpsum primaryColor'><img src='src/icons/deleteForever.svg' alt='Uninstall openServer' />Uninstall openServer (Not Working yet)</button>
    </div>
</div>
<script>
    $('#restoreCredentials').click(function () {
        $('#restoreOptions').html("<img src='/src/icons/loading.svg' /><br><p>Please wait, we are working on it...<br><b>DO NOT close the page, otherwise the process will fail</b></p>");
        $.ajax({
            url: '/src/API/deleteFile.php?path=/src/API/app/Admin/src/configs/&fileName=dbCredentials.json',
            type: 'GET',
            success: function (data) {
                location.reload();
            },
            error: function () {
                snackbarNotification('There was an error when trying connecting to the API<br>Try again in a few moments', 'hexError.svg');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    $('#recreateDatabase').click(function () {
        $('#restoreOptions').html("<img src='/src/icons/loading.svg' /><br><p>Please wait, we are working on it...<br><b>DO NOT close the page, otherwise the process will fail</b></p>");
        $.ajax({
            url: 'core/API/recreateDatabase.php',
            type: 'GET',
            success: function (data) {
                snackbarNotification(data, 'info.svg');
            },
            error: function () {
                snackbarNotification('There was an error when trying connecting to the API<br>Try again in a few moments', 'hexError.svg');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    $('.loremIpsum').click(function () {
        $('#restoreOptions').html("<img src='/src/icons/loading.svg' /><br><p>Please wait, we are working on it...<br><b>DO NOT close the page, otherwise the process will fail</b></p>");
    });
</script>