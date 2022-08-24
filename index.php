<!DOCTYPE html>
<?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/super_top.inc.php' ?>
    
    <head>
        <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/head_content.html.php' ?>
        <script src='/src/marked.min.js'></script>
        <style>
            @media screen and ( min-width: 711px ) {
                #miniContainer > *:nth-child(2n-1):nth-last-of-type(1) {
                    grid-column: span 2;
                }
            }
        </style>
    </head>

    <body>

        <div id='sideNavBar' class='sideNavbar'>
            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/sideNavBar.inc.php' ?>
        </div>

        <div id='main'>
            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/navbar.inc.php' ?>
            <div id='superContainer' class='primaryColor'>
                <section class='primaryColor-Dark shadow'>
                    <span class='sectionTitle'><img src='/src/icons/home.svg' width='20px' height='20px' /><b>Server News</b></span>
                    <article>
                        New Release of <code>openServer</code>: <code><?php echo file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/configs/versionName' ) ?></code><br>
                        Phase => <code><?php echo file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/configs/versionStatus' ) ?></code><br>
                        <div id='changelog'>
                            <?php echo file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/res/changelog' ) ?>
                        </div>
                    </article>
                    <article id='newUpdateAvailable'>
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
    <script src='/src/marked.min.js'></script>
    <script>
        
        $('#changelog').html( marked.parse( $('#changelog').html().replaceAll('\\n', '\n') ) );

        var cloudVersion = '';
        var localVersion = '';

        checkUpdateAvailability();

        function compare(a, b) {
            if (a === b) return 0;
            var a_components = a.split(".");
            var b_components = b.split(".");
            var len = Math.min(a_components.length, b_components.length);
            for (var i = 0; i < len; i++) {
                if (parseInt(a_components[i]) > parseInt(b_components[i])) return 1;
                if (parseInt(a_components[i]) < parseInt(b_components[i])) return -1;
            }
            if (a_components.length > b_components.length) return 1;
            if (a_components.length < b_components.length) return -1;
            return 0;
        }

        function checkUpdateAvailability () {
            $.ajax({
                url: 'https://raw.githubusercontent.com/Markus2003/openServer/main/src/configs/version',
                type: 'GET',
                success: function (data) {
                    cloudVersion = data;
                    $.ajax({
                        url: '/src/configs/version',
                        type: 'GET',
                        success: function (data) {
                            localVersion = data;
                            switch ( compare( localVersion, cloudVersion ) ) {
                                case -1:
                                    $('#newUpdateAvailable').html('Hello There! It seems that Markus2003 has released a new version of openServer, ask you server Admin to install it!')
                                break;
                            }
                        },
                        error: function () {

                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                },
                error: function () {

                },
                cache: false,
                contentType: false,
                processData: false
            });
        }

    </script>

</html>