<!DOCTYPE html>
<?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/super_top.inc.php' ?>
    
    <head>
        <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/head_content.html.php' ?>
        <style>
            #playerSuperContainer{
                border-radius: 12px;
                padding-bottom: 10px;
            }

            #videoTitle {
                margin: 0;
                padding-left: 10px;
            }

            #descriptionContainer {
                padding: 10px;
            }

            #videoPlayer {
                width: 55%;
                /*width: 75%;*/
                border-radius: 12px;
                margin-right: 10px;
                margin-bottom: 10px;
                aspect-ratio: 16 / 9;
            }
        </style>
    </head>

    <body>

        <div id='sideNavBar' class='sideNavbar'>
            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/sideNavBar.inc.php' ?>
        </div>

        <div id='main'>
            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/navbar.inc.php' ?>

            <table id='playerSuperContainer' class='primaryColor'>
                <tr>
                    <th colspan='2'><h2 id='videoTitle' class='left'><?php echo $_GET["fileName"] ?></h2></th>
                </tr>
                <tr>
                    <td id='descriptionContainer'>
                        Description:
                        <p id='videoDescription'>
                            Not Assigned yet
                        </p>
                    </td>
                    <td style='width: fit-content'>
                        <video id='videoPlayer' class='right' controls>
                            <source id='sourcePath' src='<?php echo $_GET["path"] ?>' />
                        </video>
                    </td>
                </tr>
                <tr>
                    <td id='buttonsContainer' colspan='2'>
                        <button type='button' class='button sensibleActionButton primaryColor-Dark shadow'><img src='/src/icons/back_arrow.svg' />Previous Episode</button>
                        <button type='button' class='button sensibleActionButton primaryColor-Dark shadow'>Next Episode<img src='/src/icons/forward_arrow.svg' /></button>
                    </td>
                </tr>
            </table>

            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/footer.html.php' ?>
        </div>

    </body>

    <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/script.html.php' ?>

</html>