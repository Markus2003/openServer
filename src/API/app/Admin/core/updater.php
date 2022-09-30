<div class='sectionTitle'><img src='src/icons/updaterIcon.svg' alt='Update Server' />Server Updater</div><hr>
<?php include '../src/include/customFunctions.inc.php' ?>
<script src='/src/marked.min.js'></script>
<style>
    #updateContainer {
        display: flex;
        justify-content: space-around;
        align-items: stretch;
        flex-direction: row;
    }

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

    fieldset.monoContent {
        border-radius: 5px;
    }

    fieldset.monoContent > select {
        background-color: transparent;
        color: white;
        width: 100%;
        border-style: none;
    }

    .monoContent > select > option {
        background-color: transparent;
        color: black;
        width: 100%;
        border-style: none;
    }

    fieldset.monoContent > select {
        padding: 10px;
    }

    fieldset.monoContent > .button {
        margin-top: 10px;
    }

    #newUpdateChangelog > #content code, #currentChangelog > #content code, #newUpdateChangelog > #content a, #currentChangelog > #content a {
        background-color: #585858;
        padding: 2px;
        border-radius: 5px;
        color: white;
    }

    #newUpdateChangelog > #content a, #currentChangelog > #content a {
        text-decoration: underline;
    }

    @media screen and ( max-width: 1290px ) {

        #updateContainer {
            display: flex;
            flex-direction: column-reverse;
            justify-content: space-around;
            align-items: stretch;
        }

    }
</style>
<div id='updateContainer'>
    <div class='versionInfoContainer'>
        <div>
            <?php
                $updaterSettings = json_decode( file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/res/updaterSettings.json' ), true )
            ?>
            <p><b>Current openServer Version:</b> <?php echo file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/configs/versionStatus' ) . '-' . file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/configs/version' ) ?></p>
            <p><b>Codename:</b> <?php echo file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/configs/versionName' ) ?></p>
        </div>
        <div id='newUpdateChangelog' style='display: none'>
            <b><p id='title'>Loading...</p></b>
            <p id='content'>Loading...</p>
        </div>
        <div id='currentChangelog'>
            <b><p>Changelog for the Actual Version (<?php echo file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/configs/versionStatus' ) . '-' . file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/configs/version' ) ?>):</p></b>
            <p id='content'></p>
        </div>
    </div>
    <div class='visualVersionInfo'>
        <img src='src/icons/updateError.svg' id='updateIconStatus' />
        <div class='versionInfoContainer'>
            <div>
                <fieldset class='monoContent'>
                    <legend>Select Your Release Channel</legend>
                    <select id='releaseSelect'>
                        <?php
                            foreach ( $updaterSettings["channelDisponibility"] as $channel )
                                if ( $channel == $updaterSettings["currentChannel"] )
                                    echo "<option value='" . $channel . "' selected>" . $channel . '</option>';
                                else
                                    echo "<option value='" . $channel . "' >" . $channel . '</option>';
                        ?>
                    </select>
                    <button type='button' id='checkUpdate' class='button primaryColor'>Check Update Availability</button>
                </fieldset>
            </div>
        </div>
        <div id='customUpdateContainer'>
            <button type='button' id='flashCustomUpdate' class='button primaryColor'>Flash a Custom Update</button>
            <form id='uploadUpdate' method='POST' enctype='multipart/form-data' style='display: none'>
                <input type='file' name='file[]' id='file' class='button primaryColor' accept='.zip' required />
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
    var cloudVersion = "";

    $('#currentChangelog > #content').html( marked.parse( '<?php echo file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/res/changelog' ) ?>' ) );

    $("#releaseSelect").change(function () {
        var status = $('#updateIconStatus').attr('src');
        $('#updateIconStatus').attr('src', '/src/icons/loading.svg');
        $.ajax({
            url: '/src/API/updateChannelRelease.php?newRelease=' + $(this).children("option:selected").val(),
            type: 'GET',
            success: function (data) {
                $('#updateIconStatus').attr('src', status);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

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
        var updateChannels = "";
        var actualVersion = "";
        var rollingChannel = "BETA";
        $.ajax({
            url: 'https://raw.githubusercontent.com/Markus2003/openServer/main/updateChannels',
            type: 'GET',
            success: function ( data ) {
                updateChannels = JSON.parse( data );
            },
            error: function () {
                $('#updateIconStatus').attr('src', 'src/icons/updateError.svg');
                snackbarNotification('There was an error while checking Update Availability', 'updateError.svg');
                return;
            },
            async: false,
            cache: false,
            contentType: false,
            processData: false
        });
        $.ajax({
            url: '/src/configs/version',
            type: 'GET',
            success: function ( data ) {
                actualVersion = data;
            },
            error: function () {
                $('#updateIconStatus').attr('src', 'src/icons/updateError.svg');
                snackbarNotification('There was an error while checking Update Availability', 'updateError.svg');
                return;
            },
            async: false,
            cache: false,
            contentType: false,
            processData: false
        });
        $.ajax({
            url: '/src/res/updaterSettings.json',
            type: 'GET',
            success: function ( data ) {
                rollingChannel = data;
            },
            error: function () {
                $('#updateIconStatus').attr('src', 'src/icons/updateError.svg');
                snackbarNotification('There was an error while checking Update Availability', 'updateError.svg');
                return;
            },
            async: false,
            cache: false,
            contentType: false,
            processData: false
        });
        for ( var i = Object.keys( updateChannels ).length - 1; i >= 0; i-- ) {
            if ( updateChannels[i].channel == rollingChannel.currentChannel )
                if ( compare( actualVersion, updateChannels[i].version ) == -1 && updateChannels[i].published ) {
                    $('#checkUpdate').html('Download Update');
                    snackbarNotification('New Update Available!', 'updateReadyToDownload.svg');
                    $('#newUpdateChangelog > b > #title').html('Changelog for the New Update (' + updateChannels[i].channel + '-' + updateChannels[i].version + '):');
                    $('#newUpdateChangelog').show();
                    cloudVersion = updateChannels[i].version;
                    if ( updateChannels[i].changelog != null ) {
                        $('#updateIconStatus').attr('src', 'src/icons/updateReadyToDownload.svg');
                        $('#newUpdateChangelog > #content').html( marked.parse( updateChannels[i].changelog.replaceAll('\\n', '\n') ) );
                    } else {
                        $('#updateIconStatus').attr('src', 'src/icons/updateReadyToDownload.svg');
                        $('#newUpdateChangelog > #content').html('Error: Cannot retrieve Changelog');
                    }
                    return;
                }
        }
        $('#updateIconStatus').attr('src', 'src/icons/updateCompleted.svg');
        snackbarNotification('No Update Found! Great!', 'updateCompleted.svg');
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
                    snackbarNotification('Error while uploading the Update', 'hexError.svg');
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