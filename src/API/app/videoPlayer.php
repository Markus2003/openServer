<!DOCTYPE html>
<?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/super_top.inc.php' ?>
    
    <head>
        <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/head_content.html.php' ?>
    </head>

    <body>

        <div id='sideNavBar' class='sideNavbar'>
            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/sideNavBar.inc.php' ?>
        </div>

        <div id='main'>
            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/navbar.inc.php' ?>

            <table id='playerSuperContainer' class='primaryColor'>
                <tr>
                    <th colspan='2'><h2 id='videoTitle' class='left'><?php echo $_GET["fileName"] ?></h2></th>
                </tr>
                <tr>
                    <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/videoPlayerChunk.inc.php' ?>
                </tr>
                <tr>
                    <td colspan='2'>
                        <div id='buttonsContainer'>
                            <button type='button' id='previousFile' class='button sensibleActionButton primaryColor-Dark shadow'><img src='/src/icons/back_arrow.svg' />Previous File</button>
                            <a id='quickDownload' href='<?php echo $_GET["path"] ?>' download><button type='button' class='button primaryColor-Dark shadow'><img src='/src/icons/download.svg' />Quick Download</button></a>
                            <button type='button' id='nextFile' class='button sensibleActionButton primaryColor-Dark shadow'>Next File<img src='/src/icons/forward_arrow.svg' /></button>
                        </div>
                    </td>
                </tr>
            </table>

            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/footer.html.php' ?>
        </div>

    </body>
    
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/script.html.php' ?>
    <script src='/src/API/tvAndFilmInfo.js'></script>
    <script>
        var files = [ <?php $rawFolder = scandir( str_replace( $_GET["fileName"], '', $_SERVER["DOCUMENT_ROOT"] . $_GET["path"] ) ); foreach ( $rawFolder as $chunk ) if ( is_file( str_replace( $_GET["fileName"], '', $_SERVER["DOCUMENT_ROOT"] . $_GET["path"] ) . $chunk ) and isReadableForServer( $chunk ) == "Video" ) echo "'" . addslashes( $chunk ) . "', "; ?> ];
        var mainPath = '<?php echo str_replace( $_GET["fileName"], '', $_GET["path"] ) ?>';
        $('#videoTitle').html( removeExtensionFromFile('<?php echo $_GET["fileName"] ?>') );
    </script>
    <script src='/src/API/videoPlayerControls.js'></script>

</html>