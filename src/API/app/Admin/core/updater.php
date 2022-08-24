<div class='sectionTitle'><img src='src/icons/updaterIcon.svg' alt='Update Server' />Server Updater</div><hr>
<?php include '../src/include/customFunctions.inc.php' ?>
<script src='/src/marked.min.js'></script>
<style>
    .versionInfoContainer {
        display: flex;
        justify-content: flex-start;
        align-items: stretch;
        flex-direction: column;
        row-gap: 10px;
        max-width: 600px;
    }
    
    .versionInfoContainer > div {
        display: flex;
        flex-direction: column;
        background-color: var( --grey-Dark );
        padding: var( --m3-inputText-padding );
        border-radius: var( --m3-inputText-borderRadius );
    }

    #updateIconStatus {
        aspect-ratio: 1 / 1;
        width: 150px;
        height: auto;
    }

    .visualVersionInfo {
        display: flex;
        flex-direction: column;
        align-items: center;
        row-gap: 30px;
    }

    .iconButtonContainer {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        align-items: center;
    }

    #uploadUpdate {
        display: flex;
        flex-direction: column;
        align-items: center;
        row-gap: 10px;
    }
</style>
<div style='display: flex;justify-content: space-around;align-items: stretch;flex-direction: row;'>
    <div class='versionInfoContainer'>
        <div>
            <p><b>Current openServer Version:</b> <?php echo file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/configs/version' ) ?></p>
            <p><b>Codename:</b> <?php echo file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/configs/versionName' ) ?></p>
        </div>
        <div id='newUpdateChangelog' style='display: none'>
            <b><p id='title'>Loading...</p></b>
            <p id='content'>Loading...</p>
        </div>
        <div id='currentChangelog'>
            <b><p>Changelog for the Actual Version (<?php echo file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/configs/version' ) ?>):</p></b>
            <p id='content'></p>
        </div>
    </div>
    <div class='visualVersionInfo'>
        <img src='src/icons/updateError.svg' id='updateIconStatus' />
        <button type='button' id='checkUpdate' class='button primaryColor'>Check Update Availability</button>
        <div id='customUpdateContainer'>
            <button type='button' id='flashCustomUpdate' class='button primaryColor'>Flash a Custom Update</button>
            <form id='uploadUpdate' method='POST' enctype='multipart/form-data' style='display: none'>
                <input type='file' name='file' id='file' class='button primaryColor' accept='.zip' required />
                <input type="hidden" id="sourcePath" name="path" value="/">
                <input type='submit' id='submit' class='button primaryColor' value='Flash Update' />
            </form>
        </div>
        <div class='iconButtonContainer'>
            <button type='button' id='clearCache' class='button iconStyle primaryColor' title='Clear Updater Cache'><img src='src/icons/remove.svg' /></button>
            <a href='https://github.com/Markus2003/openServer' target='_blank'><button type='button' class='button iconStyle primaryColor' title='Visit the Project Page on GitHub'><img src='src/icons/github.svg' /></button></a>
            <button type='button' id='downloadUpdateAndSave' class='button iconStyle primaryColor' title='Save the latest Update in your Personal Vault'><img src='src/icons/export.svg' /></button>
        </div>
    </div>
</div>
<script>
    var cloudVersion = '';
    var localVersion = '';

    getVersion();
    $('#currentChangelog > #content').html( marked.parse( '<?php echo file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/res/changelog' ) ?>' ) );

    function getVersion () {
        $.ajax({
            url: 'https://raw.githubusercontent.com/Markus2003/openServer/main/src/configs/version',
            type: 'GET',
            success: function (data) {
                cloudVersion = data;
            },
            cache: false,
            contentType: false,
            processData: false
        });
        $.ajax({
            url: '/src/configs/version',
            type: 'GET',
            success: function (data) {
                localVersion = data;
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

    function compare(a, b) {
        if (a === b) return 0;
        var a_components = a.split(".");
        var b_components = b.split(".");
        var len = Math.min(a_components.length, b_components.length);
        for (var i = 0; i < len; i++) {
            if (parseInt(a_components[i]) > parseInt(b_components[i])) return 1;
            if (parseInt(a_components[i]) < parseInt(b_components[i])) return -1;
        }
        if (a_components.length > b_components.length) return 1;
        if (a_components.length < b_components.length) return -1;
        return 0;
    }

    $('#downloadUpdateAndSave').click(function () {
        var status = $('#updateIconStatus').attr('src');
        $('#updateIconStatus').attr('src', '/src/icons/loading.svg');
        $.ajax({
            url: 'core/API/downloadUpdate.php?newVer=' + cloudVersion,
            type: 'GET',
            success: function (data) {
                console.log(data);
                $.ajax({
                    url: 'core/API/saveUpdate.php',
                    type: 'GET',
                    success: function (data) {
                        $('#updateIconStatus').attr('src', status);
                        snackbarNotification('Update Saved in your Personal Vault', 'install.svg')
                    },
                    error: function () {
                        $('#updateIconStatus').attr('src', status);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    $('#checkUpdate').click(function () {
        switch ( $(this).html() ) {
            case 'Check Update Availability':
                checkUpdateAvailability();
            break;

            case 'Download Update':
                downloadUpdate();
            break;

            case 'Install Update':
                installUpdate();
            break;
        }
    });

    $('#clearCache').click(function () {
        $('#updateIconStatus').attr('src', '/src/icons/loading.svg');
        $.ajax({
            url: 'core/API/clearCache.php',
            type: 'GET',
            success: function () {
                $('#updateIconStatus').attr('src', 'src/icons/updateError.svg');
                $('#checkUpdate').html('Check Update Availability');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    })

    function checkUpdateAvailability () {
        $('#updateIconStatus').attr('src', '/src/icons/loading.svg');
        $.ajax({
            url: 'https://raw.githubusercontent.com/Markus2003/openServer/main/src/configs/version',
            type: 'GET',
            success: function (data) {
                cloudVersion = data;
                $.ajax({
                    url: '/src/configs/version',
                    type: 'GET',
                    success: function (data) {
                        localVersion = data;
                        switch ( compare( localVersion, cloudVersion ) ) {
                            case -1:
                                $('#checkUpdate').html('Download Update');
                                snackbarNotification('New Update Available!', 'updateReadyToDownload.svg');
                                $('#newUpdateChangelog > b > #title').html('Changelog for the New Update (' + cloudVersion + '):');
                                $('#newUpdateChangelog').show();
                                $.ajax({
                                    url: 'https://raw.githubusercontent.com/Markus2003/openServer/main/src/res/changelog',
                                    type: 'GET',
                                    success: function (data) {
                                        $('#updateIconStatus').attr('src', 'src/icons/updateReadyToDownload.svg');
                                        $('#newUpdateChangelog > #content').html( marked.parse( data.replaceAll('\\n', '\n') ) );
                                    },
                                    error: function () {
                                        $('#updateIconStatus').attr('src', 'src/icons/updateReadyToDownload.svg');
                                        $('#newUpdateChangelog > #content').html('Error: Impossible to retrieve Changelog');
                                    },
                                    cache: false,
                                    contentType: false,
                                    processData: false
                                });
                            break;

                            case 0:
                            case 1:
                                $('#updateIconStatus').attr('src', 'src/icons/updateCompleted.svg');
                                snackbarNotification('No Update Found! Great!', 'updateCompleted.svg');
                            break;
                        }
                    },
                    error: function () {
                        $('#updateIconStatus').attr('src', 'src/icons/updateError.svg');
                        snackbarNotification('There was an error while checking Update Availability', 'updateError.svg');
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            },
            error: function () {
                $('#updateIconStatus').attr('src', 'src/icons/updateError.svg');
                snackbarNotification('There was an error while checking Update Availability', 'updateError.svg');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

    function downloadUpdate () {
        $('#updateIconStatus').attr('src', '/src/icons/loading.svg');
        $.ajax({
            url: 'core/API/downloadUpdate.php?newVer=' + cloudVersion,
            type: 'GET',
            success: function (data) {
                snackbarNotification('Update Download Complete', 'downloadCompleted.svg');
                console.log(data);
                $('#checkUpdate').html('Install Update');
                if ( confirm('Do you want to install the update now?') )
                    installUpdate();
                else
                    $('#updateIconStatus').attr('src', 'src/icons/updateError.svg');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

    function installUpdate() {
        $('#updateIconStatus').attr('src', '/src/icons/loading.svg');
        $.ajax({
            url: 'core/API/installUpdate.php',
            type: 'GET',
            success: function (data) {
                alert(data);
                if ( data == 'Update installed Successfully!' ) {
                    snackbarNotification('Update Installed', 'updateCompleted.svg');
                    updateView('updater.php');
                } else
                    $('#updateIconStatus').attr('src', 'src/icons/updateError.svg');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

    $('#flashCustomUpdate').click(function () {
        $(this).hide();
        $('#uploadUpdate').show();
        snackbarNotification('Remember to call your custom update \'update.zip\'', 'info.svg');
    });

    $('form#uploadUpdate').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: '/src/API/uploadFile.php',
            type: 'POST',
            data: formData,
            success: function (data) {
                if ( data == 'Success: File Uploaded' ) {
                    snackbarNotification('Update Upload Complete, beginning installation', 'downloadCompleted.svg');
                    installUpdate();
                } else {
                    snackbarNotification('Error while uploading the Update', 'downloadError.svg');
                }
            },
            error: function () {
                snackbarNotification('There was an error when trying connecting to the API<br>Try again in a few moments', 'hexError.svg');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
</script>