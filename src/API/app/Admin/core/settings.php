<div class='sectionTitle'><img src='src/icons/settingIcon.svg' alt='Settings Icon' />Settings</div><hr>
<?php include '../src/include/customFunctions.inc.php' ?>
<?php
    $credentials = json_decode(file_get_contents('../src/configs/dbCredentials.json'), true);

    echo "Database Host: <input type='text' id='host' class='input notNULL' value='" . $credentials["host"] . "' /><br>";
    if ( $credentials["host"] == null )
        echo printWarning('hostNote', 'Invalid Host');
    else
        echo printDone();

    echo "Default Database Name: <input type='text' id='defaultDB' class='input notNULL' value='" . $credentials["defaultDB"] . "' /><br>";
    if ( $credentials["defaultDB"] == null )
        echo printWarning('hostNote', 'Invalid Default Database');
    else
        echo printDone();

    echo "Username: <input type='text' id='username' class='input notNULL' value='" . $credentials["username"] . "' /><br>";
    if ( $credentials["username"] == null )
        echo printWarning('usernameNote', 'Invalid Username');
    else
        echo printDone();

    echo "Password: <input type='password' id='password' class='input notNULL' value='" . $credentials["password"] . "' /><br>";
    if ( $credentials["password"] == null )
        echo printWarning('passwordNote', 'Invalid Password');
    else
        echo printDone();
    echo "Confirm Password: <input type='password' id='confirmPassword' class='input' /><br>" . printWarning('confirmPasswordNote', 'You must re-type your password for safety reason');
?>
<button type='submit' id='submitChanges' class='button'><img src='src/icons/saveFloppy.svg' />Save Changes</button>
<?php
    if ( is_file('../src/configs/dbCredentials.json') ) echo "<button type='submit' id='deleteConfig' class='button' style='margin-top: 10px'><img src='src/icons/deleteForever.svg' />Delete Configuration File</button>";
?>
<script>
    var timeout;

    $('#confirmPassword').on('keyup', function () {
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            if ( $('#password').val() == $('#confirmPassword').val() ) {
                $('#confirmPasswordNote').removeClass('warning');
                $('#confirmPasswordNote').addClass('done');
                $('#confirmPasswordNote > span').text("");
            } else {
                $('#confirmPasswordNote').removeClass('done');
                $('#confirmPasswordNote').addClass('warning');
                $('#confirmPasswordNote > span').text("Warning: Wrong password inserted");
            }
        }, 500);
    });

    $('#confirmPassword').on('keydown', function () {
        clearTimeout(timeout);
    });

    $('#submitChanges').click(function () {
        if ( $('#host').val() != '' && $('#defaultDB').val() != '' && $('#username').val() != '' )
            if ( $('#password').val() == $('#confirmPassword').val() )
                $.ajax({
                    url: 'core/API/saveCredentials.php?host=' + $('#host').val() + '&defaultDB=' + $('#defaultDB').val() + '&username=' + $('#username').val() + '&password=' + $('#password').val(),
                    type: 'GET',
                    success: function (data) {
                        switch (data) {
                            case '0x000':
                                alert("Failure on connecting to Database.");
                                updateView('settings.php');
                            break;
                            
                            case '0x001':
                                alert("Changes Saved.\nReloading page...");
                                location.reload();
                            break;
                            
                            case '0x999':
                                alert("Invalid Credentials inserted.");
                            break;
                        }
                        if ( data == '0x001' ) {
                        }
                    },
                    error: function (data) {
                        snackbarNotification('There was an error when trying connecting to the API<br>Try again in a few moments', 'hexError.svg');
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            else
                alert("Warning: Password mismatch");
        else
            alert("Warning: You didn't complete all the fields");
    });

    $('#deleteConfig').click(function () {
        if ( confirm("By deleting the configuration file you will need to re-setup the App.\nDo you want to continue?") )
            $.ajax({
                url: 'core/API/deleteConfig.php',
                type: 'GET',
                success: function (data) {
                    location.reload();
                },
                error: function (data) {
                    snackbarNotification('There was an error when trying connecting to the API<br>Try again in a few moments', 'hexError.svg');
                },
                cache: false,
                contentType: false,
                processData: false
            });
    });
</script>