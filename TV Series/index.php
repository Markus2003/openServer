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
            <?php
                if ( isset( $_GET['overrideFolder'] ) )
                    $overrideFolder = $_GET['overrideFolder'];
                else
                    $overrideFolder = '';
            ?>
            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/navbar.inc.php' ?>
            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/scandir.inc.php' ?>

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
                                include $_SERVER["DOCUMENT_ROOT"] . '/src/include/folderCommonButtons.inc.php';

                        if ( count( $fileList ) > 0 )
                            foreach ( $fileList as $file )
                                if ( isReadableForServer( $file ) == 'Video' )
                                    include $_SERVER["DOCUMENT_ROOT"] . '/src/include/fileCommonButtons.inc.php';
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