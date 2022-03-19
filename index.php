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
            <?php #include $_SERVER["DOCUMENT_ROOT"] . '/src/include/scanFolder.inc.php' ?>
            <div id='superContainer' class='primaryColor'>
                <section class='primaryColor-Dark shadow'>
                    <span class='sectionTitle'><img src='/src/icons/home.svg' width='20px' height='20px' /><b>Server News</b></span>
                    <article>
                        Initial Release of <code>openServer</code><br>
                        Phase => <code>ALPHA</code>
                    </article>
                </section>
                <div id='miniContainer'>
                    <?php
                        $jsonIconsRes = json_decode( file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/res/iconForSection.json' ), true );
                        $jsonDescriptionRes = json_decode( file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/res/sectionDescription.json' ), true );
                        $jsonNewsRes = json_decode( file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/res/sectionNews.json' ), true );
                        foreach ( $rawFolder as $folder )
                            if ( is_dir( $folder ) and checkBlacklistFolder( $folder ) ) {
                                if ( findStringInArray( $jsonIconsRes["sectionName"], $folder ) )
                                    echo "
                                    <section class='primaryColor-Dark shadow'>
                                        <span class='sectionTitle'><img src='/src/icons/" . $jsonIconsRes["sectionIcon"][ array_search( $folder, $jsonIconsRes["sectionName"] ) ] . "' /><b>" . $folder . "</b></span>
                                    ";
                                else
                                    echo "
                                    <section class='primaryColor-Dark shadow'>
                                        <span class='sectionTitle'><img src='/src/icons/" . $jsonIconsRes["fallback"] . "' /><b>" . $folder . "</b></span>
                                    ";
                                echo "
                                <article>
                                    ";
                                    if ( findStringInArray( $jsonDescriptionRes["sectionName"], $folder ) )
                                        echo $jsonDescriptionRes["sectionDescription"][ array_search( $folder, $jsonDescriptionRes["sectionName"] ) ];
                                    else
                                        echo $jsonDescriptionRes["fallback"];
                                echo "
                                </article>";
                                if ( findStringInArray( $jsonNewsRes["sectionName"], $folder ) )
                                    echo "
                                    <article>
                                        News in this section:<br>
                                        <strong>" . $jsonNewsRes["sectionNews"][ array_search( $folder, $jsonNewsRes["sectionName"] ) ] . "</strong>
                                    </article>
                                    ";
                                echo "<article style='margin-top: 10px'>
                                    <a href='/" . $folder . "'><button type='button' class='button primaryColor shadow'>Go to " . $folder . "</button></a>
                                </article>
                                </section>
                                ";
                            }

                    ?>
                </div>
            </div>

            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/footer.html.php' ?>

        </div>

    </body>

    <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/script.html.php' ?>

</html>