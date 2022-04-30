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
            <?php
                if ( isset( $_GET['overrideFolder'] ) )
                    $overrideFolder = $_GET['overrideFolder'];
                else
                    $overrideFolder = '';

                include $_SERVER["DOCUMENT_ROOT"] . '/src/include/scandir.inc.php';
            ?>

            <div id='superContainer' class='primaryColor-Dark'>
                <?php
                    if ( $overrideFolder != '' )
                        echo "
                            <section class='primaryColor shadow'>
                                <span class='max-width left sectionTitle' style='font-size: 24px'><a><button type='submit' class='button shadow primaryColor-Dark' onclick='history.back()'><img src='/src/icons/back_arrow.svg' /></button></a> <b>Go Back</b></span>
                            </section>
                        ";
                    if ( count( $folderList ) == 0 and count( $fileList ) == 0 )
                        echo "
                            <section class='primaryColor shadow'>
                                <span class='max-width left sectionTitle' style='font-size: 30px'><img src='/src/icons/error.svg' style='width: 30px' /><b>No Files found</b></span>
                            </section>
                        ";
                    else {
                        if ( count( $folderList ) > 0 )
                            foreach ( $folderList as $folder )
                                echo "
                                <section class='primaryColor shadow'>
                                    <span class='max-width left sectionTitle' style='font-size: 30px'><img src='/src/icons/folder.svg' style='width: 30px' /><b>" . $folder . "</b></span>
                                    <article class='max-width'>
                                        <form action='" . $_SERVER["PHP_SELF"] . "' method='GET'>
                                            <input type='hidden' name='overrideFolder' value='" . $overrideFolder . $folder . "/' />
                                            <button type='submit' class='button right shadow primaryColor-Dark'><img src='/src/icons/forward_arrow.svg' /></button>
                                        </form>
                                        <button type='button' class='button primaryColor-Dark right shadow' onclick='renameFolder( \"" . getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder . "\", \"" . $folder . "\" )'><img src='/src/icons/edit.svg' /></button>
                                        <button type='button' class='button primaryColor-Dark right shadow' onclick='deleteFolder( \"" . getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder . "\", \"" . $folder . "\" )'><img src='/src/icons/bin.svg' /></button>
                                    </article>
                                </section>
                                ";

                        if ( count( $fileList ) > 0 )
                            foreach ( $fileList as $file )
                                if ( isReadableForServer( $file ) == 'Video' )
                                    echo "
                                    <section class='primaryColor shadow'>
                                        <span class='max-width left sectionTitle' style='font-size: 30px'><img src='/src/icons/tv.svg' style='width: 30px' /><b>" . $file . "</b></span>
                                        <article class='max-width'>
                                            <!--<form action='" . $_SERVER["PHP_SELF"] . "' method='GET'>
                                                <input type='hidden' name='overrideFolder' value='" . $overrideFolder . $folder . "/' />
                                                <button type='submit' class='button right shadow primaryColor-Dark'><img src='/src/icons/forward_arrow.svg' /></button>
                                            </form>-->
                                            <a href='" . getInServerAddress( $_SERVER["REQUEST_URI"] ) . $overrideFolder . $file . "'><button type='button' class='button right shadow primaryColor-Dark'><img src='/src/icons/play.svg' /></button></a>
                                            <a href='" . getInServerAddress( $_SERVER["REQUEST_URI"] ) . $overrideFolder . $file . "' download><button type='button' class='button right shadow primaryColor-Dark'><img src='/src/icons/download.svg' /></button></a>
                                            <button type='button' class='button primaryColor-Dark right shadow' onclick='renameFile( \"" . getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder . "\", \"" . $file . "\", \"" . getFileExtension( $file ) . "\" )'><img src='/src/icons/edit.svg' /></button>
                                            <button type='button' class='button primaryColor-Dark right shadow' onclick='deleteFile( \"" . getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder . "\", \"" . $file . "\" )'><img src='/src/icons/bin.svg' /></button>
                                        </article>
                                    </section>
                                    ";
                    }
                ?>
            </div>

            <button type='button' id='createFolder' class='button sensibleActionButton primaryColor shadow' onclick='createFolder("<?php echo getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder ?>")'><img src='/src/icons/new_folder.svg' />Create new Folder</button>
            <button type='button' id='uploadFile' class='button sensibleActionButton primaryColor shadow' onclick='uploadFile("TV Series", "<?php echo getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder ?>")'><img src='/src/icons/upload.svg' />Upload a TV Series</button>

            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/footer.html.php' ?>
        </div>

    </body>

    <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/script.html.php' ?>

</html>