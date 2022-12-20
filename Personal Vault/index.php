<!DOCTYPE html>
<?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/super_top.inc.php' ?>
<?php
    if ( !isset( $_SESSION["openServerUserpath"] ) ) {
        header('Location: /login.php');
        exit();
    }
?>
    
    <head>
        <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/head_content.html.php' ?>
    </head>

    <body>

        <div id='sideNavBar' class='sideNavbar'>
            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/sideNavBar.inc.php' ?>
        </div>

        <div id='main'>
            <?php $overrideFolder = $_POST["overrideFolder"]; include $_SERVER["DOCUMENT_ROOT"] . '/src/include/navbar.inc.php'; $overrideFolder = $_SESSION["openServerUserpath"] . '/' . $_POST["overrideFolder"]; ?>
            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/scandir.inc.php' ?>

                <?php
                    if ( !isset( $_POST["overrideFolder"] ) ) {
                        echo "
                        <div id='superContainer' class='primaryColor-Dark'>
                            <section class='primaryColor shadow'>
                                <span class='sectionTitle'><img src='/src/icons/applications.svg' width='20px' height='20px' /><b>Private Apps</b></span>
                            </section>
                        ";
                        if ( !is_dir( $_SERVER["DOCUMENT_ROOT"] . '/Personal Vault/' . $_SESSION["openServerUserpath"] . '/.privateApps/' ) )
                            mkdir( $_SERVER["DOCUMENT_ROOT"] . '/Personal Vault/' . $_SESSION["openServerUserpath"] . '/.privateApps/', 0777 );
                        $rawFolder = scandir( $_SERVER["DOCUMENT_ROOT"] . '/Personal Vault/' . $_SESSION["openServerUserpath"] . '/.privateApps/' );
                        $folders = [];
                        foreach ( $rawFolder as $chunk )
                            if ( is_dir( $_SERVER["DOCUMENT_ROOT"] . '/Personal Vault/' . $_SESSION["openServerUserpath"] . '/.privateApps/' . $chunk ) and $chunk != '.' and $chunk != '..' )
                                array_push( $folders, $chunk );
                        if ( count( $folders ) > 0 )
                            foreach ( $folders as $folder ) {
                                echo "
                                    <section class='primaryColor shadow'>
                                        <span class='max-width left sectionTitle' style='font-size: 30px'><img src='" . printPrivateAppIconName( $folder ) . "' style='width: 30px' /><b>" . $folder . "</b></span>";
                                        
                                        if ( is_file( $_SERVER["DOCUMENT_ROOT"] . '/Personal Vault/' . $_SESSION["openServerUserpath"] . '/.privateApps/' . $folder . '/info.txt' ) )
                                            echo "
                                                <article class='max-width left'>
                                                    " . file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/Personal Vault/' . $_SESSION["openServerUserpath"] . '/.privateApps/' . $folder . '/info.txt' ) . "
                                                </article>
                                            ";
                                        else
                                            echo "
                                                <article class='max-width left'>
                                                    No description found
                                                </article>
                                            ";
                                        
                                        echo "<article class='max-width'>
                                            <a href='" . $_SESSION["openServerUserpath"] . "/.privateApps/" . $folder . "/' target='_blank' class='right'><button type='button' class='button primaryColor-Dark shadow'><img src='/src/icons/launch.svg' /></button></a>
                                            <button type='button' class='button primaryColor-Dark right shadow' onclick='downloadPrivateApp(\"" . $folder . "\")'><img src='/src/icons/archive.svg' /></button>
                                            <button type='button' class='button uninstallPrivateApp primaryColor-Dark right shadow' appName='" . $folder . "'><img src='/src/icons/bin.svg' /></button>
                                        </article>
                                    </section>
                                ";
                            }
                        else
                            echo "
                                <section class='primaryColor shadow'>
                                    <span class='max-width left sectionTitle' style='font-size: 30px'><img src='/src/icons/error.svg' style='width: 30px' /><b>No Apps found</b></span>
                                </section>
                            ";
                        echo "
                            </div>
                            <br>
                        ";
                    }
                ?>
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
                                <span class='max-width left chunk-size'><button type='button' class='button primaryColor withIMG getFolderSize' location=\"/Personal Vault/". $overrideFolder . $folder . "\"><img src='/src/icons/error.svg' />Get Folder Size</button></span>
                                <article class='max-width'>
                                    <form action='" . $_SERVER["PHP_SELF"] . "' method='POST'>
                                        <input type='hidden' name='overrideFolder' value='" . $_POST["overrideFolder"] . $folder . "/' />
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
                    session_start();
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

                                    case 'Install Disk':
                                        echo 'installMedia.svg';
                                    break;

                                    case 'Android Installer':
                                        echo 'adb.svg';
                                    break;

                                    default:
                                        echo 'file.svg';
                                }                                
                                echo "' style='aspect-ratio: 1 / 1; width: 30px; height: auto;' />" . $file . "
                                </span>
                                <span class='max-width left chunk-size'><button type='button' class='button primaryColor withIMG getFileSize' location=\"/Personal Vault/". $overrideFolder . $file . "\"><img src='/src/icons/error.svg' />Get File Size</button></span>
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
                                            if ( explode( ".", $file )[ count( explode( ".", $file ) ) - 1 ] == 'zip' and !isset( $_POST["overrideFolder"] ) ) {
                                                echo "<button type='button' class='button privateInstall primaryColor-Dark right shadow' appName='" . $file . "'><img src='/src/icons/install.svg' /></button>";
                                            } else
                                                echo "<a href=\"/src/API/viewer.php?type=VAULT&path=" . addslashes( str_replace( explode( '/', $overrideFolder )[0], '', $overrideFolder ) ) . "&filename=" . addslashes( $file ) . "\"><button type='button' class='button primaryColor-Dark right shadow'><img src='/src/icons/launch.svg' /></button></a>";
                                    }
                                    echo "<a href=\"/src/API/download.php?type=VAULT&path=" . addslashes( str_replace( explode( '/', $overrideFolder )[0], '', $overrideFolder ) ) . "&filename=" . addslashes( $file ) . "\" download><button type='button' class='button primaryColor-Dark right shadow'><img src='/src/icons/download.svg' /></button></a>";
                                    echo "<button type='button' class='button primaryColor-Dark right shadow' onclick='rename( \"" . getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder . "\", \"" . $file . "\" )'><img src='/src/icons/edit.svg' /></button>";
                                    if ( isset( $_SESSION["openServerFileHoldingType"] ) ) {
                                        if ( findStringInArray( $_SESSION["openServerFileHolding"], getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder . $file ) and $_SESSION["openServerFileHoldingType"] == "COPY" ) {
                                            echo "<button type='button' class='button primaryColor-Dark right shadow copy' path='" . getInServerAddress( $_SERVER["PHP_SELF"] ) .  $overrideFolder . $file . "' disabled><img src='/src/icons/copy.svg' /></button>";
                                        } else {
                                            echo "<button type='button' class='button primaryColor-Dark right shadow copy' path='" . getInServerAddress( $_SERVER["PHP_SELF"] ) .  $overrideFolder . $file . "'><img src='/src/icons/copy.svg' /></button>";
                                        }
                                        if ( findStringInArray( $_SESSION["openServerFileHolding"], getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder . $file ) and $_SESSION["openServerFileHoldingType"] == "MOVE" ) {
                                            echo "<button type='button' class='button primaryColor-Dark right shadow move' path='" . getInServerAddress( $_SERVER["PHP_SELF"] ) .  $overrideFolder . $file . "' disabled><img src='/src/icons/cut.svg' /></button>";
                                        } else {
                                            echo "<button type='button' class='button primaryColor-Dark right shadow move' path='" . getInServerAddress( $_SERVER["PHP_SELF"] ) .  $overrideFolder . $file . "'><img src='/src/icons/cut.svg' /></button>";
                                        }
                                    } else {
                                        echo "<button type='button' class='button primaryColor-Dark right shadow copy' path='" . getInServerAddress( $_SERVER["PHP_SELF"] ) .  $overrideFolder . $file . "'><img src='/src/icons/copy.svg' /></button>";
                                        echo "<button type='button' class='button primaryColor-Dark right shadow move' path='" . getInServerAddress( $_SERVER["PHP_SELF"] ) .  $overrideFolder . $file . "'><img src='/src/icons/cut.svg' /></button>";
                                    }
                                    if ( checkIfShared( $overrideFolder, $file ) ) {
                                        echo "<button type='button' class='button primaryColor-Dark right shadow removeShare' path=\"" . addslashes( str_replace( explode( '/', $overrideFolder )[0], '', $overrideFolder ) ) . "\" file=\"" . addslashes( $file ) . "\"><img src='/src/icons/cancelShare.svg' class='img' /></button>";
                                    } else {
                                        echo "<button type='button' class='button primaryColor-Dark right shadow share' path=\"" . addslashes( str_replace( explode( '/', $overrideFolder )[0], '', $overrideFolder ) ) . "\" file=\"" . addslashes( $file ) . "\"><img src='/src/icons/share.svg' class='img' /></button>";
                                    }
                                    echo "<button type='button' class='button primaryColor-Dark right shadow' onclick='deleteFile( \"" . getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder . "\", \"" . $file . "\" )'><img src='/src/icons/bin.svg' /></button>";
                                echo "</article>
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
    <div id='fsOps' class=''>
        <button id='actHere' class='button iconStyle primaryColor shadown' path='<?php echo getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder ?>'><img src='/src/icons/paste.svg' /></button>
        <button id='cancelAct' class='button iconStyle primaryColor shadown'><img src='/src/icons/close.svg' /></button>
        <div>
            Holding <p id='counter'>0</p> files... <p id='type'></p>
        </div>
    </div>
    <script>
        updateLabel();

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

        function updateLabel () {
            $.ajax({
                url: '/src/API/getHoldingNumber.php',
                type: 'GET',
                success: function ( data ) {
                    data = JSON.parse( data );
                    if ( data.count != 0 ) {
                        $('#fsOps').addClass('show');
                        $('#fsOps > div > #counter').html( data.count );
                        $('#fsOps > div > #type').html( "(" + data.type + ")" );
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }

        $('#actHere').click(function () {
            $('#fsOps > div').html('Working... <img src=\'/src/icons/loading.svg\' width=\'24px\' height=\'24px\' />');
            console.log( $(this).attr('path') );
            $.ajax({
                url: '/src/API/completeAction.php?path=' + $(this).attr('path'),
                type: 'GET',
                success: function ( data ) {
                    location.reload();
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });

        $('#cancelAct').click(function () {
            $.ajax({
                url: '/src/API/destroyFileHolding.php',
                type: 'GET',
                success: function ( data ) {
                    location.reload();
                },
                cache: false,
                contentType: false,
                processData: false
            })
        });

        $('.copy').click(function () {
            $(this).prop('disabled', true);
            $.ajax({
                url: '/src/API/addNewFileToHold.php?path=' + $(this).attr('path') + '&type=COPY',
                type: 'GET',
                success: function ( data ) {
                    updateLabel();
                },
                cache: false,
                contentType: false,
                processData: false
            })
        });

        $('.move').click(function () {
            $(this).prop('disabled', true);
            $.ajax({
                url: '/src/API/addNewFileToHold.php?path=' + $(this).attr('path') + '&type=MOVE',
                type: 'GET',
                success: function ( data ) {
                    updateLabel();
                },
                cache: false,
                contentType: false,
                processData: false
            })
        });

        $('.share').click(function () {
            $(this).children('.img').attr('src', '/src/icons/cancelShare.svg');
            $(this).removeClass('share');
            $(this).addClass('removeShare');
            $.ajax({
                url: '/src/API/shareManager.php?type=ADD&pathToShare=' + $(this).attr('path') + '&fileShared=' + $(this).attr('file'),
                type: 'GET',
                success: function ( data ) {
                    $(this).children('.img').attr('src', '/src/icons/cancelShare.svg');
                    $(this).addClass('removeShare');
                    $(this).removeClass('share');
                    snackbarNotification('Share Link created!', 'share.svg');
                },
                cache: false,
                contentType: false,
                processData: false
            })
        })

        $('.removeShare').click(function () {
            $(this).children('.img').attr('src', '/src/icons/share.svg');
            $(this).removeClass('removeShare');
            $(this).addClass('share');
            $.ajax({
                url: '/src/API/shareManager.php?type=REMOVE&pathToShare=' + $(this).attr('path') + '&fileShared=' + $(this).attr('file'),
                type: 'GET',
                success: function ( data ) {
                    $(this).children('.img').attr('src', '/src/icons/share.svg');
                    $(this).addClass('share');
                    $(this).removeClass('removeShare');
                    snackbarNotification('Share Link deleted!', 'cancelShare.svg');
                },
                cache: false,
                contentType: false,
                processData: false
            })
        })

        $('.privateInstall').click(function () {
            $.ajax({
                url: '/src/API/installPrivateApp.php?appName=' + $(this).attr('appName'),
                type: 'GET',
                success: function (data) {
                    alert( data );
                    location.reload();
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });

        $('.uninstallPrivateApp').click(function () {
            $.ajax({
                url: '/src/API/uninstallPrivateApp.php?appName=' + $(this).attr('appName'),
                type: 'GET',
                success: function (data) {
                    alert( data );
                    location.reload();
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });

        function downloadPrivateApp ( appName ) {
            window.location.href = '/src/API/downloadApp.php?appName=' + appName;
        }
    </script>

</html>