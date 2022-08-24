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
                    <th colspan='2'><h2 id='musicTitle' class='left'>Loading Title...</h2></th>
                </tr>
                <tr>
                    <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/musicPlayerChunk.inc.php' ?>
                </tr>
                <tr>
                    <td colspan='2'>
                        <div id='buttonsContainer'>
                            <a id='quickDownload' href='<?php echo $_GET["path"] ?>' download><button type='button' class='button primaryColor-Dark shadow'><img src='/src/icons/download.svg' />Quick Download</button></a>
                        </div>
                    </td>
                </tr>
            </table>

            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/footer.html.php' ?>
        </div>

    </body>
    
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/script.html.php' ?>
    <script src='/src/jsmediatags.min.js'></script>
    <script>
        function test() {
            const jsmediatags = window.jsmediatags;
            jsmediatags.read($('#sourcePath'), {
                onSuccess: function ( tag ) {
                    const data = tag.tags.picture.data;
                    const format = tag.tags.picture.format;
                    let base64String = "";
                    for (let i = 0; i < data.length; i++) {
                        base64String += String.fromCharCode(data[i]);
                    }
                    $('#musicImg').attr('src', 'data:' + format + ';base64,' + window.btoa(base64String))
                },
                onError: function () {
                    $('#musicImg').attr('src', '/src/icons/albumDisk.svg')
                }
            })
        }
        var files = [ <?php $rawFolder = scandir( str_replace( $_GET["fileName"], '', $_SERVER["DOCUMENT_ROOT"] . $_GET["path"] ) ); foreach ( $rawFolder as $chunk ) if ( is_file( str_replace( $_GET["fileName"], '', $_SERVER["DOCUMENT_ROOT"] . $_GET["path"] ) . $chunk ) and isReadableForServer( $chunk ) == "Audio" ) echo "'" . addslashes( $chunk ) . "', "; ?> ];
        var mainPath = '<?php echo str_replace( $_GET["fileName"], '', $_GET["path"] ) ?>';
        $('#musicTitle').html( removeExtensionFromFile('<?php echo $_GET["fileName"] ?>') );
    </script>
    <script src='/src/API/musicPlayerControls.js'></script>

</html>