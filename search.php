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

            <form id='searchForm' method='GET'>
                <span class='max-width left sectionTitle' style='font-size: 30px; margin-bottom: 10px;'><img src='/src/icons/search.svg' style='width: 30px; vertical-align: middle;' />Server File Finder</span>
                <input type='text' id='query' class='textInputs' name='query' <?php if ( isset( $_GET["query"] ) ) echo "value='" . $_GET["query"] . "'" ?> placeholder='Search File By Name...' required/>
                <?php
                    if ( isset( $_GET["filters"] ) )
                        $filters = json_decode( $_GET["filters"], true );
                ?>
                <fieldset>
                    <legend>Filters</legend>
                    <div><!-- Custom Checkbox https://codepen.io/alvarotrigo/pen/wvyvjva?editors=1100 -->
                        Sections to Search:
                        <?php
                            foreach ( $rawFolder as $folder )
                                if ( is_dir( $folder ) and checkBlacklistFolder( $folder ) and $folder != 'Applications' )
                                    if ( isset( $_GET["filters"] ) )
                                        if ( findStringInArray( $filters['sectionsToFilter'], $folder ) )
                                            echo "<button type='button' id='" . $folder . "' class='filtersSection button chip primaryColor-Dark' value='" . $folder . "'><img src='' />" . $folder . "</button>";
                                        else
                                            echo "<button type='button' id='" . $folder . "' class='filtersSection button chip primaryColor-Dark active' value='" . $folder . "'><img src='' />" . $folder . "</button>";
                                    else
                                        echo "<button type='button' id='" . $folder . "' class='filtersSection button chip primaryColor-Darka active' value='" . $folder . "'><img src='' />" . $folder . "</button>";
                        ?>
                    </div>
                    <div>
                        File Type to Search:
                        <?php
                            $fileTypes = ['Audio', 'Video', 'Image', 'Book', 'Text', 'Archive', 'Install Disk', 'Android Installer'];
                            sort( $fileTypes );
                            foreach ( $fileTypes as $type )
                                if ( isset( $_GET["filters"] ) )
                                    if ( findStringInArray( $filters['fileTypeToFilter'], $type ) )
                                        echo "<button type='button' id='" . $type . "' class='filtersType button chip primaryColor-Dark' value='" . $type . "'><img src='' />" . $type . "</button>";
                                    else
                                        echo "<button type='button' id='" . $type . "' class='filtersType button chip primaryColor-Dark active' value='" . $type . "'><img src='' />" . $type . "</button>";
                                else
                                    echo "<button type='button' id='" . $type . "' class='filtersType button chip primaryColor-Dark active' value='" . $type . "'><img src='' />" . $type . "</button>";
                        ?>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Other Search Options</legend>
                    <div>
                        <?php
                            if ( isset( $_GET["strictCompare"] ) )
                                echo "<button type='button' class='button chip extraOptions primaryColor-Dark active'><img src='' />Strict String Compare</button>";

                            else
                                echo "<button type='button' class='button chip extraOptions primaryColor-Dark'><img src='' />Strict String Compare</button>";
                        ?>
                    </div>
                </fieldset>
                <button type='submit' class='button primaryColor-Dark'>Search</button>
            </form>

            <?php
                $serverStructure = [];
                function scan_folder ( $actualFolder, $deepness=0 ) {
                    global $filters, $serverStructure;
                    foreach ( scandir( $_SERVER["DOCUMENT_ROOT"] . $actualFolder ) as $chunk ) {
                        try {
                            if ( $deepness == 0 ) {
                                if ( is_dir( $_SERVER["DOCUMENT_ROOT"] . $actualFolder . $chunk ) and !findStringInArray( $filters['sectionsToFilter'], $chunk ) and checkBlacklistFolder( $chunk ) and $chunk != 'Applications' ) 
                                    if ( $chunk == 'Personal Vault' )
                                        scan_folder( $actualFolder . $chunk . '/' . $_SESSION["openServerUserpath"] . '/', $deepness + 1 );
                                    else
                                        scan_folder( $actualFolder . $chunk . '/', $deepness + 1 );
                                elseif ( is_file( $_SERVER["DOCUMENT_ROOT"] . $actualFolder . $chunk ) and !findStringInArray( $filters['fileTypeToFilter'], isReadableForServer( $chunk ) ) and !contains( $chunk, '.php' ) )
                                    array_push( $serverStructure, $actualFolder . $chunk );
                            } elseif ( $deepness == 1 ) {
                                if ( is_dir( $_SERVER["DOCUMENT_ROOT"] . $actualFolder . $chunk ) and checkBlacklistFolder( $chunk ) )
                                    scan_folder( $actualFolder . $chunk . '/', $deepness + 1 );
                                elseif ( is_file( $_SERVER["DOCUMENT_ROOT"] . $actualFolder . $chunk ) and !findStringInArray( $filters['fileTypeToFilter'], isReadableForServer( $chunk ) ) and !contains( $chunk, '.php' ) )
                                    array_push( $serverStructure, $actualFolder . $chunk );
                            } else {
                                if ( is_dir( $_SERVER["DOCUMENT_ROOT"] . $actualFolder . $chunk ) and checkBlacklistFolder( $chunk ) )
                                    scan_folder( $actualFolder . $chunk . '/', $deepness + 1 );
                                elseif ( is_file( $_SERVER["DOCUMENT_ROOT"] . $actualFolder . $chunk ) and !findStringInArray( $filters['fileTypeToFilter'], isReadableForServer( $chunk ) ) )
                                    array_push( $serverStructure, $actualFolder . $chunk );
                            }
                        } catch (\Throwable $th) {
                            
                        }
                    }
                }

                function printResult ( $chunk ) {
                    $file = explode( '/', $chunk )[ count( explode( '/', $chunk ) ) - 1 ];
                    $section = explode( '/', $chunk )[1];
                    $overrideFolder = str_replace( $file, '', str_replace( '/' . $section, '', $chunk ) );
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
                        <article class='max-width'>";
                            switch ( $section ) {

                                case 'Films':
                                    echo "
                                        <form action='/src/API/app/filmPlayer.php' method='GET'>
                                            <input type='hidden' name='fileName' value='" . $file . "' />
                                            <input type='hidden' name='path' value='/Films/" . $overrideFolder . $file . "' />
                                            <button type='submit' class='button right shadow primaryColor-Dark'><img src='/src/icons/play.svg' /></button>
                                        </form>
                                    ";
                                break;

                                case 'Music':
                                    echo "
                                        <form action='/src/API/app/musicPlayer.php' method='GET'>
                                            <input type='hidden' name='fileName' value='" . $file . "' />
                                            <input type='hidden' name='path' value='/Music/" . $overrideFolder . $file . "' />
                                            <button type='submit' class='button right shadow primaryColor-Dark'><img src='/src/icons/play.svg' /></button>
                                        </form>
                                    ";
                                break;

                                case 'Personal Vault':
                                break;
                                
                                case 'TV Series':
                                    echo "
                                        <form action='/src/API/app/seriesPlayer.php' method='GET'>
                                            <input type='hidden' name='fileName' value='" . $file . "' />
                                            <input type='hidden' name='path' value='/TV Series/" . $overrideFolder . $file . "' />
                                            <button type='submit' class='button right shadow primaryColor-Dark'><img src='/src/icons/play.svg' /></button>
                                        </form>
                                    ";
                                break;

                                default:
                                    echo "<a href='" . $chunk . "'><button type='button' class='button primaryColor-Dark right shadow'><img src='/src/icons/launch.svg' /></button></a>";

                            }
                            switch ( $section ) {

                                case 'Personal Vault':
                                    echo "
                                        <form action='/" . $section . "' method='GET'>
                                            <input type='hidden' name='overrideFolder' value='" . $overrideFolder . "' />
                                            <button type='submit' class='button right shadow primaryColor-Dark'><img src='/src/icons/folder.svg' /></button>
                                        </form>
                                    ";
                                break;

                                default:
                                    echo "
                                        <form action='/" . $section . "' method='GET'>
                                            <input type='hidden' name='overrideFolder' value='" . $overrideFolder . "' />
                                            <button type='submit' class='button right shadow primaryColor-Dark'><img src='/src/icons/folder.svg' /></button>
                                        </form>
                                    ";

                            }
                            echo "<a href='" . $chunk . "' download><button type='button' class='button primaryColor-Dark right shadow'><img src='/src/icons/download.svg' /></button></a>
                            <!--<button type='button' class='button primaryColor-Dark right shadow' onclick='renameFile( \"/" . $section . $overrideFolder . "\", \"" . $file . "\", \"" . getFileExtension( $file ) . "\" )'><img src='/src/icons/edit.svg' /></button>-->
                            <!--<button type='button' class='button primaryColor-Dark right shadow' onclick='deleteFile( \"/" . $section . $overrideFolder . "\", \"" . $file . "\" )'><img src='/src/icons/bin.svg' /></button>-->
                        </article>
                    </section>
                ";
                }

                if ( isset( $_GET["query"] ) ) {
                    scan_folder( '/' );
                    $result = 0;
                    echo "<div id='superContainer' class='primaryColor-Dark'>";
                    foreach ( $serverStructure as $chunk ) {

                        if ( isset( $_GET["strictCompare"] ) ) {
                            if ( contains( explode( '/', $chunk )[ count( explode( '/', $chunk ) ) - 1 ], $_GET["query"] ) ) {
                                printResult( $chunk );
                                $result++;
                            }

                        } elseif ( contains( strtolower( explode( '/', $chunk )[ count( explode( '/', $chunk ) ) - 1 ] ), strtolower( $_GET["query"] ) ) ) {
                            printResult( $chunk );
                            $result++;
                        }

                    }
                    if ( $result == 0 )
                        echo "
                            <section class='primaryColor shadow'>
                                <span class='max-width left sectionTitle' style='font-size: 30px'><img src='/src/icons/error.svg' style='width: 30px' /><b>No Results found...</b></span>
                            </section>
                        ";
                    echo "</div>";
                }
            ?>

            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/footer.html.php' ?>
        </div>

    </body>

    <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/script.html.php' ?>
    <script>
        function createFilter ( className ) {
            var result = [];
            $('.' + className).each(function () {
                if ( !$(this).hasClass('active') )
                    result.push( $(this).id );
            });
            return result;
        }

        $('form#searchForm').submit(function (e) {
            e.preventDefault();
            var jsonDatas = {
                sectionsToFilter: createFilter('filtersSection'),
                fileTypeToFilter: createFilter('filtersType')
            }
            var extra = '';
            if ( $('.extraOptions').hasClass('active') )
                extra += '&strictCompare=true';
            window.location.href = '<?php echo $_SERVER["PHP_SELF"] ?>?query=' + $('#query').val() + '&filters=' + JSON.stringify( jsonDatas ) + extra;
        });
    </script>

</html>