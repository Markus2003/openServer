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
            <div id='superContainer'>
                <section id='setupContainer' class='primaryColor center'>
                    <span class='max-width left sectionTitle' style='font-size: 30px'><img src='/src/icons/install.svg' style='width: 30px; vertical-align: middle; margin-bottom: 10px;' />Welcome to the setup process</span>
                    <section id='0' class='max-width left' style='display: block'>
                        Welcome to the setup process!<br>
                        Here you can install new Web App on this server.<br><br>
                        <b>Remember!</b><br>
                        Package name <b>must</b> be: '<code>app name</code>.zip'<br>
                        Package structure <b>must</b> be:<br>
                        <code>app name</code>.zip<br>
                        | -> <code>index.html</code>/<code>index.php</code> to start the app<br>
                        | -> <code>info.txt</code> containg some info about the app (reccomended)<br>
                        | -> <code>icon.svg</code> to display the icon of the app from the list (reccomended)<br>
                        : -> other file for the app<br>
                        <!--<button class='switch' role='switch' aria-checked='false'></button>-->
                    </section>
                    <section id='1' class='max-width left' style='display: none'>
                        Please select the package to upload and install<br>
                        <form id='uploadPackage' class='uploadForm' method='post' enctype='multipart/form-data'>
                            <input type='file' name='file' id='file' class='button primaryColor-Dark shadow' accept='.zip' required />
                            <input type='submit' id='submit' class='button primaryColor-Dark shadow' value='Install' />
                        </form>
                    </section>
                    <section class='max-width'>
                        <button type='button' id='continue' class='button primaryColor-Dark right' style='width: 100px; display: block'>Continue</button>
                        <button type='button' id='back' class='button primaryColor-Dark right' style='width: 100px; display: none'>Back</button>
                    </section>
                </section>
            </div>

            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/footer.html.php' ?>
        </div>

    </body>

    <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/script.html.php' ?>
    <script>
        var currentInstallationStatus = 0;
        $('#back').click(function () {
            $('#continue').css('display', 'block');
            if ( currentInstallationStatus > 0 ) {
                $('#' + currentInstallationStatus).css('display', 'none');
                currentInstallationStatus--;
                $('#' + currentInstallationStatus).css('display', 'block');
            } else {
                currentInstallationStatus = 0;
            }
            if ( currentInstallationStatus == 0 )
                $('#back').css('display', 'none');
        });
        $('#continue').click(function () {
            $('#back').css('display', 'block');
            $('#' + currentInstallationStatus).css('display', 'none');
            currentInstallationStatus++;
            $('#' + currentInstallationStatus).css('display', 'block');
            if ( currentInstallationStatus >= 1 )
                $('#continue').css('display', 'none');
        });
    </script>

</html>