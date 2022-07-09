<div class='sectionTitle'><img src='src/icons/exlusionTuner.svg' alt='Exclusion Tuner' />Exclusion Tuner</div><hr>
<?php include '../src/include/customFunctions.inc.php' ?>
<style>
    #exlusionContainer {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
        row-gap: 45px;
    }

    .exclusionSection {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        width: 100%;
    }
</style>
<div id='exlusionContainer'>
    <div class='exclusionSection'>
        Folder Exclusion:
        <table id='folderTable'>
            <?php
                $filesAndFolder = json_decode( file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/res/filesFoldersBlacklist.json' ), true );
                foreach ( $filesAndFolder["folders"] as $folder )
                    echo "<tr><td><input type='text' class='folderExclusion input' value='" . $folder . "' /></td></tr>";
            ?>
            <tr><td><button type='button' class='button iconStyle primaryColor addRow' reference='folderTable' insertClass='folderExclusion'><img src='src/icons/add.svg' /></button></td></tr>
        </table>
        <button type='button' class='button primaryColor'><img src='src/icons/saveFloppy.svg' />Save Changes</button>
    </div>
    <div class='exclusionSection'>
        File Exclusion:
        <table id='fileTable'>
            <?php
                $filesAndFolder = json_decode( file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/res/filesFoldersBlacklist.json' ), true );
                foreach ( $filesAndFolder["files"] as $file )
                    echo "<tr><td><input type='text' class='fileExclusion input' value='" . $file . "' /></td></tr>";
            ?>
            <tr><td><button type='button' class='button iconStyle primaryColor addRow' reference='fileTable' insertClass='fileExclusion'><img src='src/icons/add.svg' /></button></td></tr>
        </table>
        <button type='button' class='button primaryColor'><img src='src/icons/saveFloppy.svg' />Save Changes</button>
    </div>
    <div class='exclusionSection'>
        System Apps Uninstall Exclusion:
        <table id='appTable'>
            <?php
                $systemApps = json_decode( file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/res/systemApps.json' ), true );
                foreach ( $systemApps["sysApps"] as $app )
                    echo "<tr><td><input type='text' class='appExclusion input' value='" . $app . "' /></td></tr>";
            ?>
            <tr><td><button type='button' class='button iconStyle primaryColor addRow' reference='appTable' insertClass='appExclusion'><img src='src/icons/add.svg' /></button></td></tr>
        </table>
        <button type='button' class='button primaryColor'><img src='src/icons/saveFloppy.svg' />Save Changes</button>
    </div>
</div>
<script>
    $('.addRow').click(function () {
        $('#' + $(this).attr('reference') + ' > tbody > tr:last-child').before("<tr><td><input type='text' class='" + $(this).attr('insertClass') + " input' /></td></tr>");
    });
</script>