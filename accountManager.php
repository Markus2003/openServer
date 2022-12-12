<!DOCTYPE html>
<?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/super_top.inc.php' ?>

    <head>
        <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/head_content.html.php' ?>
        <?php session_start(); if ( !isset( $_SESSION["openServerUsername"] ) ) header('Location: /') ?>
    </head>

    <body>

        <div id='sideNavBar' class='sideNavbar'>
            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/sideNavBar.inc.php' ?>
        </div>

        <div id='main'>
            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/navbar.inc.php' ?>

            <div id='superContainer' class='primaryColor'>
                <section class='primaryColor-Dark shadow'>
                    <img src='/src/icons/account.svg' width=72px /><b><?php echo $_SESSION["openServerUsername"] ?></b>
                </section>
                <section class='primaryColor-Dark shadow'>
                    <table>
                        <tr>
                            <td>Username</td><td><?php echo $_SESSION["openServerUsername"] ?></td>
                        </tr>
                        <tr>
                            <td>E-Mail</td><td><?php echo $_SESSION["openServerEmail"] ?></td>
                        </tr>
                        <tr>
                            <td>Userpath</td><td><button type='button' id='revealUserpath' class='button primaryColor shadow' style='margin-bottom: 10px'>Show my Userpath</button><button type='button' id='regenerateUserpath' class='button primaryColor shadow'>Regenerate my Userpath</button></td>
                        </tr>
                        <tr>
                            <td>Personal Vault Size</td><td><b><?php echo formatSize( foldersize( $_SERVER["DOCUMENT_ROOT"] . '/Personal Vault/' . $_SESSION["openServerUserpath"] . '/' ) ) ?></b></td>
                        </tr>
                    </table>
                </section>
                <div id='miniContainer'>
                    <section class='primaryColor-Dark shadow'>
                        <button type='button' id='deleteAccount' class='button primaryColor shadow'>Delete my Account</button>
                    </section>
                    <section class='primaryColor-Dark shadow'>
                        <button type='button' id='logout' class='button primaryColor shadow'>Logout</button>
                    </section>
                </div>
                <?php
                    if ( $_SESSION["openServerFlags"] )
                        echo "
                            <section class='primaryColor-Dark shadow'>
                                <a href='/src/API/app/Admin/'><button type='button' class='button primaryColor shadow'>Go To Administration Page</button></a>
                            </section>
                        ";
                ?>
                
            </div>

            <br>

            <div id='superContainer' class='primaryColor-Dark'>
                <section class='primaryColor shadow'>
                    <span class='sectionTitle'><img src='/src/icons/share.svg' width='20px' height='20px' /><b>Share Register</b></span>
                </section>
                <?php
                    include $_SERVER["DOCUMENT_ROOT"] . '/src/include/db_connect-Reader.inc.php';
                    $result = $database->query("SELECT * FROM " . $credentials["defaultDatabase"] . ".shareRegister WHERE email='" . $_SESSION["openServerEmail"] . "';");
                    $database->close();
                    if ( $result->num_rows > 0 ) {
                        foreach ( $result->fetch_all() as $row ) {
                            echo "
                                <section class='primaryColor shadow' id='" . $row[0] . "'>
                                    <span class='max-width left sectionTitle' style='font-size: 30px'>
                                        <img src='/src/icons/";
                                        switch ( isReadableForServer( $row[3] ) ) {
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
                                    echo "' style='aspect-ratio: 1 / 1; width: 30px; height: auto;' />" . $row[3] . " (from Path \"" . $row[2] . "\")
                                    </span>
                                    <article class='max-width'>
                                        <button type='button' class='button withIMG primaryColor-Dark shareLink' link='http://" . $_SERVER["SERVER_NAME"] . "/src/API/viewer.php?type=UUID&UUID=" . $row[0] . "'><img src='/src/icons/copy.svg' />Copy Sharable Link</button>
                                    </article>
                                    <article class='max-width'>";
                                    echo "
                                        <form action='/Personal Vault/' method='POST'>
                                            <input type='hidden' name='overrideFolder' value='" . $row[2] . "' />
                                            <button type='submit' class='button right shadow primaryColor-Dark'><img src='/src/icons/folder.svg' /></button>
                                        </form>
                                    ";
                                    echo "<button type='button' class='button primaryColor-Dark right shadow removeShare' path=\"" . $row[2] . "\" file=\"" . $row[3] . "\" UUID=\"" . $row[0] . "\"><img src='/src/icons/cancelShare.svg' class='img' /></button>";
                                    echo "</article>
                                </section>
                            ";
                        }
                        echo "<button type='button' id='optimizeShareRegister' class='button sensibleActionButton primaryColor shadow'><img src='/src/icons/bin.svg' />Optimize Share Register</button>";
                    } else {
                        echo "
                            <section class='primaryColor shadow'>
                                <span class='max-width left sectionTitle' style='font-size: 30px'><img src='/src/icons/error.svg' style='width: 30px' /><b>No Shared Files found</b></span>
                            </section>
                        ";
                    }
                ?>            
            </div>

            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/footer.html.php' ?>
        </div>

    </body>

    <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/script.html.php' ?>
    <script>
        $('#revealUserpath').on('click', function () {
            if ( confirm('Do you really want to reveal your \'Userpath\'?\nThis string say where is your Personal Vault on the Server, keep it secret!') ) {
                var password = prompt('Insert your password to confirm this critical action:');
                $.ajax({
                    url: '/src/API/getSessionVar.php?command=Userpath&password=' + password,
                    success: function (data) {
                        alert( "Your Userpath in the Server is:\n" + data + "\nRemember to keep this String secret!\nYou will always be able to recover the Userpath in this page" );
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });

        $('#regenerateUserpath').click(function () {
            if ( confirm('Are you really sure you want to re-generate your current Userpath?') ) {
                var password = prompt('Insert your password to confirm this critical action:');
                $.ajax({
                    url: '/src/API/regenerateUserpath.php?password=' + password,
                    success: function (data) {
                        console.log(data);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });

        $('#logout').click(function () {
            $.ajax({
                url: '/src/API/logout.php',
                type: 'GET',
                success: function (data) {
                    window.location.href = '/';
                },
                cache: false,
                contentType: false,
                processData: false
            })
        });

        $('#deleteAccount').click(function () {
            if ( confirm('Are you sure you want to delete your openServer Account?\nYour files stored in the Personal Vault will be lost forever!') )
                if ( confirm('Really?\nThis operation will be irreversible!') ) {
                    var password = prompt('Insert your password to confirm this critical action:');
                    $.ajax({
                        url: '/src/API/deleteAccount.php?password=' + password,
                        type: 'GET',
                        success: function (data) {
                            alert('Your Account was deleted, soon you will receive a confirmation e-mail...');
                            window.location.href = '/';
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }
        });

        $('.removeShare').click(function () {
            $.ajax({
                url: '/src/API/shareManager.php?type=REMOVE&pathToShare=' + $(this).attr('path') + '&fileShared=' + $(this).attr('file'),
                type: 'GET',
                success: function ( data ) {
                    location.reload();
                },
                cache: false,
                contentType: false,
                processData: false
            })
        });

        $('.shareLink').click(function () {
            var $temp = $('<input>');
            $('body').append($temp);
            $temp.val($(this).attr('link')).select();
            document.execCommand('copy');
            $temp.remove();
            snackbarNotification('Share Link copied to Clipboard!', 'copy.svg');
        });

        $('#optimizeShareRegister').click(function () {
            $.ajax({
                url: '/src/API/shareManager.php?type=OPTIMIZE',
                type: 'GET',
                success: function ( data ) {
                    location.reload();
                },
                cache: false,
                contentType: false,
                processData: false
            })
        })
    </script>

</html>