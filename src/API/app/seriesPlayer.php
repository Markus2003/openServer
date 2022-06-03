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
                    <th colspan='2'><h2 id='videoTitle' class='left'>Loading Title...</h2></th>
                </tr>
                <tr>
                    <td id='descriptionContainer'>
                        Description:
                        <p id='videoDescription'>
                            Not Assigned yet
                        </p>
                    </td>
                    <td style='width: fit-content'>
                        <video id='videoPlayer' class='right' controls>
                            <source id='sourcePath' src='<?php echo $_GET["path"] ?>' currentFile='<?php echo $_GET["fileName"] ?>' />
                        </video>
                    </td>
                </tr>
                <tr>
                    <td id='buttonsContainer' colspan='2'>
                        <button type='button' id='previousEpisode' class='button sensibleActionButton primaryColor-Dark shadow'><img src='/src/icons/back_arrow.svg' />Previous Episode</button>
                        <button type='button' id='nextEpisode' class='button sensibleActionButton primaryColor-Dark shadow'>Next Episode<img src='/src/icons/forward_arrow.svg' /></button>
                    </td>
                </tr>
            </table>

            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/footer.html.php' ?>
        </div>

    </body>
    
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/script.html.php' ?>
    <script src='/src/API/tvAndFilmInfo.js'></script>
    <script>
        var files = [ <?php $rawFolder = scandir( str_replace( $_GET["fileName"], '', $_SERVER["DOCUMENT_ROOT"] . $_GET["path"] ) ); foreach ( $rawFolder as $chunk ) if ( is_file( str_replace( $_GET["fileName"], '', $_SERVER["DOCUMENT_ROOT"] . $_GET["path"] ) . $chunk ) and isReadableForServer( $chunk ) == "Video" ) echo "'" . $chunk . "', "; ?> ];
        var mainPath = '<?php echo str_replace( $_GET["fileName"], '', $_GET["path"] ) ?>';
        $('#videoTitle').html( removeExtensionFromFile('<?php echo $_GET["fileName"] ?>') );
        
        $('#previousEpisode').click(function () {
            if ( files.indexOf( $('#sourcePath').attr('currentFile') ) > 0 ) {
                $('#videoTitle').html( removeExtensionFromFile( files[ files.indexOf( $('#sourcePath').attr('currentFile') ) - 1 ] ) );
                $('#sourcePath').attr('src', mainPath + files[ files.indexOf( $('#sourcePath').attr('currentFile') ) - 1 ]);
                $('#sourcePath').attr('currentFile', files[ files.indexOf( $('#sourcePath').attr('currentFile') ) - 1 ] );
                $('#videoPlayer')[0].load();
            }
        });

        $('#nextEpisode').click(function () {
            if ( files.indexOf( $('#sourcePath').attr('currentFile') ) < files.length - 1 ) {
                $('#videoTitle').html( removeExtensionFromFile( files[ files.indexOf( $('#sourcePath').attr('currentFile') ) + 1 ] ) );
                $('#sourcePath').attr('src', mainPath + files[ files.indexOf( $('#sourcePath').attr('currentFile') ) + 1 ]);
                $('#sourcePath').attr('currentFile', files[ files.indexOf( $('#sourcePath').attr('currentFile') ) + 1 ] );
                $('#videoPlayer')[0].load();
            }
        });
    </script>

</html>