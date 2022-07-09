<!DOCTYPE html>
<html lang='en'>
    <head>
        <title>
            Admin
        </title>
        <link rel='icon' href='src/icons/Admin.svg' />
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <meta name='description' content='A simple Admin in development' />
        <link rel='stylesheet' href='src/style.css' />
        <link rel='stylesheet' href='/src/customFont.css?rnd=<?php echo $_SERVER['REQUEST_TIME'] ?>' />
        <script src='src/jquery.min.js'></script>
        <?php include 'src/include/customFunctions.inc.php' ?>
    </head>
    <body>
        <div id='superTitle'>
            <img src='src/icons/Admin.svg' width='92px' height='auto' alt='Admin Icon' style='cursor: pointer' onclick='location.reload();' /><div><h1>Admin</h1><h6>by Marco Ricci</h6></div>
        </div>
        <div id='bodySuperContainer'>
            <div id='menuList'>
                <?php
                    if ( checkDatabaseCredentials() )
                        echo "
                            <a pageRef='accountManagement.php' class='menuAction'><div><img src='src/icons/accountManagement.svg' alt='User Management' /><span>User Management</span></div></a>
                            <a pageRef='tablesManagement.php' class='menuAction'><div><img src='src/icons/fileIcon.svg' alt='Tables Management' /><span>Tables Manager</span></div></a>
                            <a pageRef='dbDevMode.php' class='menuAction'><div><img src='src/icons/developerMode.svg' alt='Database Settings' /><span>Database Settings</span></div></a>
                            <hr>
                        ";
                    else
                        echo "
                            <script>
                                alert('Error: It seems that you haven\'t done the setup procedure or you inserted wrong credentials.\\nPlease, complete the setup procedure.\\n\\nNote: App will not work until you finish!');
                            </script>
                        ";
                ?>
                <a pageRef='fontCustomization.php' class='menuAction'><div><img src='src/icons/font.svg' alt='Font Customizer' /><span>Font Customizer</span></div></a>
                <a pageRef='exclusionTuner.php' class='menuAction'><div><img src='src/icons/exlusionTuner.svg' alt='Exclusion Tuner' /><span>Exclusion Tuner</span></div></a>
                <a pageRef='cacheManager.php' class='menuAction'><div><img src='src/icons/cache.svg' alt='Update Server' /><span>Cache Manager</span></div></a>
                <a pageRef='restoreOption.php' class='menuAction'><div><img src='src/icons/restoreOption.svg' alt='Restore Server Option' /><span>Restore Server Option</span></div></a>
                <a pageRef='updater.php' class='menuAction'><div><img src='src/icons/updaterIcon.svg' alt='Update Server' /><span>Server Updater</span></div></a>
                <hr>
                <a pageRef='settings.php' class='menuAction active'><div><img src='src/icons/settingIcon.svg' /><span>Settings</span></div></a>
                <a href='/' class='menuAction'><div><img src='src/icons/home.svg' /><span>Go to Server Root</span></div></a>
                <a onclick='history.back()' class='menuAction'><div><img src='src/icons/return.svg' /><span>Go Back</span></div></a>
                <h6 id='versionInfo'><?php echo file_get_contents('src/configs/versionDetail') ?></h6>
            </div>
            <div>
                <div id='resultPage'>
                    We are loading the page, please wait...
                </div>
                <div id='snackbar'></div>
            </div>
        </div>
    </body>
    <script>
        updateView('settings.php');

        function updateView ( pageToCall ) {
            $('#resultPage').html("We are loading the page, please wait...")
            $.ajax({
                url: 'core/' + pageToCall,
                type: 'GET',
                success: function (data) {
                    $('#resultPage').html(data);
                },
                error: function (data) {
                    $('#resultPage').html("<div class='error'><img src='src/icons/hexError.svg' width='96px' height='auto' alt='Hexagonal Error' /><h1>An Error has occurred</h1></div>");
                    snackbarNotification('An Error has occurred, please try again in a few moments', 'hexError.svg');
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }

        //Temporary Handler for section change
        $('.menuAction').click(function () {
            $('.menuAction').removeClass('active');
            $(this).addClass('active');
            updateView( $(this).attr('pageRef') );
        });

        function snackbarNotification (text, img='') {
            if (img!='')
                img = 'src/icons/toast/' + img;
            $('#snackbar').empty();
            $('#snackbar').prepend('<span><img src=\'' + img + '\' />' + text + '</span>');
            $('#snackbar').toggleClass('show');
            setTimeout(function () {
                $('#snackbar').toggleClass('show');
            }, 3000);
        }

        $('#versionInfo').click(function () {
            snackbarNotification('Version <?php echo file_get_contents('src/configs/versionNumber') ?> - <?php echo file_get_contents('src/configs/versionDetail') ?>', 'build.svg')
        });
    </script>
</html>