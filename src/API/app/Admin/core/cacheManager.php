<div class='sectionTitle'><img src='src/icons/cache.svg' alt='Cache Manager' />Cache Manager</div><hr>
<?php include '../src/include/customFunctions.inc.php' ?>
<style>
    #cacheContainer {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
        row-gap: 35px;
    }
</style>
<div id='cacheContainer'>
    <div>
        <code>Film Poster</code> Cache size: <?php echo formatSize( folderSize( $_SERVER["DOCUMENT_ROOT"] . '/Films/posters' ) ) ?><br>
        <button type='button' id='Films' class='button wiper'><img src='src/icons/deleteForever.svg' />Wipe Cache</button>
    </div>
    <div>
        <code>update.zip</code> Cache size: <?php if ( is_file( $_SERVER["DOCUMENT_ROOT"] . '/update.zip' ) ) echo formatSize( filesize( $_SERVER["DOCUMENT_ROOT"] . '/update.zip' ) ); else echo formatSize( 0 ); ?><br>
        <button type='button' id='Update' class='button wiper'><img src='src/icons/deleteForever.svg' />Wipe Cache</button>
    </div>
    <div>
        <code>Personal Vault</code> not linked Account Cache size: <?php echo getSpaceOfNotLinkedPersonalVault() ?><br>
        <button type='button' id='Personal Vault' class='button wiper'><img src='src/icons/deleteForever.svg' />Wipe Cache</button>
    </div>
</div>
<script>
    $('.wiper').click(function () {
        $('#cacheContainer').html("<img src='/src/icons/loading.svg' /><br><p>Wiping...</p>");
        $.ajax({
            url: 'core/API/wiper.php?type=' + $(this).attr('id'),
            type: 'GET',
            success: function (data) {
                console.log(data);
                updateView('cacheManager.php');
            },
            error: function (data) {
                snackbarNotification('There was an error when trying connecting to the API<br>Try again in a few moments', 'hexError.svg');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
</script>