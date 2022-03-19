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
            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/scandir.inc.php' ?>

            <div id='superContainer' class='primaryColor-Dark'>
                <?php
                    if ( count( $folderList ) > 0 )
                        foreach ( $folderList as $app ) {
                            echo "
                                <section class='primaryColor shadow'>
                                    <span class='max-width left sectionTitle' style='font-size: 30px'><img src='" . printAppIconName( $app ) . "' style='width: 30px' /><b>" . $app . "</b></span>";
                                    
                                    if ( is_file( $_SERVER["DOCUMENT_ROOT"] . '/Applications/' . $app . '/info.txt' ) )
                                        echo "
                                            <article class='max-width left'>
                                                " . file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/Applications/' . $app . '/info.txt' ) . "
                                            </article>
                                        ";
                                    else
                                        echo "
                                            <article class='max-width left'>
                                                No description found
                                            </article>
                                        ";
                                    
                                    echo "<article class='max-width'>
                                        <a href='" . $app . "/' target='_blank' class='right'><button type='button' class='button primaryColor-Dark shadow'><img src='/src/icons/launch.svg' /></button></a>
                                        <button type='button' class='button primaryColor-Dark right shadow' onclick='downloadApp(\"" . $app . "\")'><img src='/src/icons/archive.svg' /></button>
                                        <button type='button' class='button primaryColor-Dark right shadow' onclick='uninstallApp(\"" . $app . "\")'><img src='/src/icons/bin.svg' /></button>
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
                ?>
            </div>

            <button type='button' id='installButton' class='button primaryColor shadow'><img src='/src/icons/install.svg' />Install an App</button>

            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/footer.html.php' ?>
        </div>

    </body>

    <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/script.html.php' ?>

</html>