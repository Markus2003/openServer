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
                    <span class='max-width left sectionTitle' style='font-size: 30px; margin-bottom: 10px;'><img src='/src/icons/upload.svg' style='width: 30px; vertical-align: middle;' />Welcome to the upload process</span>
                    <section id='0' class='max-width left' style='display: block'>
                        Welcome to the upload process!<br>
                        Here you can upload your own File on this server.<br><br>
                        <b>Remember!</b><br>
                        File will be uploaded in the directory <code><?php echo $_GET["path"] ?></code>
                    </section>
                    <section id='1' class='max-width left' style='display: none'>
                        Please select the File to upload<br>
                        <form id='uploadFile' class='uploadForm' method='post' enctype='multipart/form-data'>
                            <input type='hidden' id='sourcePath' name='path' value='<?php echo $_GET["path"] ?>' />
                            <input type='file' name='file[]' id='file' class='button primaryColor-Dark shadow' multiple required />
                            <input type='submit' id='submit' class='button primaryColor-Dark shadow' value='Upload' />
                        </form>
                    </section>
                    <section class='max-width'>
                        <button type='button' id='continue' class='button primaryColor-Dark right shadow' style='width: 100px; display: block'>Continue</button>
                        <button type='button' id='back' class='button primaryColor-Dark right shadow' style='width: 100px; display: none'>Back</button>
                    </section>
                </section>
            </div>

            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/footer.html.php' ?>
        </div>

    </body>

    <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/script.html.php' ?>
    <script>
        var currentUploadStatus = 0;
        $('#back').click(function () {
            $('#continue').css('display', 'block');
            if ( currentUploadStatus > 0 ) {
                $('#' + currentUploadStatus).css('display', 'none');
                currentUploadStatus--;
                $('#' + currentUploadStatus).css('display', 'block');
            } else {
                currentUploadStatus = 0;
            }
            if ( currentUploadStatus == 0 )
                $('#back').css('display', 'none');
        });
        $('#continue').click(function () {
            $('#back').css('display', 'block');
            $('#' + currentUploadStatus).css('display', 'none');
            currentUploadStatus++;
            $('#' + currentUploadStatus).css('display', 'block');
            if ( currentUploadStatus >= 1 )
                $('#continue').css('display', 'none');
        });
    </script>

</html>