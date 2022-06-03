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
            <?php $overrideFolder = $_SESSION["openServerUserpath"] . '/' . $_POST["overrideFolder"]; include $_SERVER["DOCUMENT_ROOT"] . '/src/include/navbar.inc.php' ?>
            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/scandir.inc.php' ?>

            <div id='superContainer' class='primaryColor-Dark'>
                <section class='primaryColor shadow'>
                    <span class='sectionTitle'><img src='/src/icons/folder.svg' width='20px' height='20px' /><b>Folders</b></span>
                </section>
                <?php
                    if ( isset( $_POST["overrideFolder"] ) )
                        echo "
                            <section class='primaryColor shadow'>
                                <span class='max-width left sectionTitle' style='font-size: 24px'><a><button type='submit' class='button shadow primaryColor-Dark' onclick='history.back()'><img src='/src/icons/back_arrow.svg' /></button></a> <b>Go Back</b></span>
                            </section>
                        ";
                    foreach ( $folderList as $folder )
                        echo "
                            <section class='primaryColor shadow'>
                                <span class='max-width left sectionTitle' style='font-size: 30px'>
                                    <img src='/src/icons/folder.svg' style='width: 30px' />" . $folder . "
                                </span>
                                <article class='max-width'>
                                    <form action='" . $_SERVER["PHP_SELF"] . "' method='POST'>
                                        <input type='hidden' name='overrideFolder' value='" . $POST["overrideFolder"] . $folder . "/' />
                                        <button type='submit' class='button changeFolder primaryColor-Dark right shadow'><img src='/src/icons/forward_arrow.svg' /></button>
                                    </form>
                                    <button type='button' class='button primaryColor-Dark right shadow' onclick='rename( \"" . getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder . "\", \"" . $folder . "\" )'><img src='/src/icons/edit.svg' /></button>
                                    <button type='button' class='button primaryColor-Dark right shadow' onclick='deleteFolder( \"" . getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder . "\", \"" . $folder . "\" )'><img src='/src/icons/bin.svg' /></button>
                                </article>
                            </section>
                        ";
                ?>
                <button type='button' id='createFolder' class='button sensibleActionButton primaryColor shadow' onclick='createFolder("<?php echo getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder ?>")'><img src='/src/icons/new_folder.svg' />Create new Folder</button>
            </div>
            <br>
            <div id='superContainer' class='primaryColor-Dark'>
                <section class='primaryColor shadow'>
                    <span class='sectionTitle'><img src='/src/icons/file.svg' width='20px' height='20px' /><b>Files</b></span>
                </section>
                <?php
                    foreach ( $fileList as $file ) {
                        echo "
                            <section class='primaryColor shadow'>
                                <span class='max-width left sectionTitle' style='font-size: 30px'>
                                    <img src='/src/icons/";
                                switch ( isReadableForServer( $file ) ) {
                                    case 'Audio':
                                        echo "music.svg";
                                    break;

                                    case 'Video':
                                        echo "movie.svg";
                                    break;

                                    case 'Image':
                                        echo 'picture.svg';
                                    break;

                                    case 'Book':
                                        echo 'book.svg';
                                    break;

                                    case 'Text':
                                        echo 'textFile.svg';
                                    break;

                                    case 'Archive':
                                        echo 'zip.svg';
                                    break;

                                    case 'Android Installer':
                                        echo 'adb.svg';
                                    break;

                                    default:
                                        echo 'file.svg';
                                }                                
                                echo "' style='aspect-ratio: 1 / 1; width: 30px; height: auto;' />" . $file . "
                                </span>
                                <article class='max-width'>";
                                    switch ( isReadableForServer( $file ) ) {
                                        case "Video":
                                            echo "
                                                <form action='/src/API/app/videoPlayer.php' method='GET'>
                                                    <input type='hidden' name='fileName' value='" . $file . "' />
                                                    <input type='hidden' name='path' value='/Personal Vault/" . $overrideFolder . $file . "' />
                                                    <button type='submit' class='button right shadow primaryColor-Dark'><img src='/src/icons/play.svg' /></button>
                                                </form>
                                            ";
                                        break;

                                        default:
                                            echo "<a href='" . getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder . $file , "'><button type='button' class='button primaryColor-Dark right shadow'><img src='/src/icons/launch.svg' /></button></a>";
                                    }
                                    echo "<a href='" . getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder . $file , "' download><button type='button' class='button primaryColor-Dark right shadow'><img src='/src/icons/download.svg' /></button></a>
                                    <button type='button' class='button primaryColor-Dark right shadow' onclick='rename( \"" . getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder . "\", \"" . $file . "\" )'><img src='/src/icons/edit.svg' /></button>
                                    <button type='button' class='button primaryColor-Dark right shadow' onclick='deleteFile( \"" . getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder . "\", \"" . $file . "\" )'><img src='/src/icons/bin.svg' /></button>
                                </article>
                            </section>
                        ";
                    }
                ?>
                <button type='button' id='uploadFile' class='button sensibleActionButton primaryColor shadow' onclick='uploadFile("Personal Vault", "<?php echo getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder ?>")'><img src='/src/icons/upload.svg' />Upload a File</button>
            </div>

            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/footer.html.php' ?>
        </div>

    </body>

    <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/script.html.php' ?>
    <script>
        function rename ( directory, oldChunkName ) {
            var newChunkName = prompt("Type your new chunk name for '" + oldChunkName + "' (Remember to write the extension!):\nLeave blank to abort");
            if ( newChunkName != '' && newChunkName != null )
                $.ajax({
                    url: '/src/API/rename.php?directory=' + directory + '&oldChunkName=' + oldChunkName + '&newChunkName=' + newChunkName,
                    type: 'GET',
                    success: function (data) {
                        window.location.reload();
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
        }

        $('.mv').click(function () {
            var response = prompt("Where do you want to move '" + $(this).val() + "'?\nLeave blank to abort");
            if ( response != '' )
                mv( $(this).attr('originalPath'), $(this).val(), response );
        });

        function mv ( originalPath, fileName, newPath ) {
            //TODO: Ajax code to mv.php page
        }
    </script>

</html>