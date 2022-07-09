<!DOCTYPE html>
<?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/super_top.inc.php' ?>
    
    <head>
        <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/head_content.html.php' ?>
        <style>

            .code {
                background-color: var( --primaryColor-Dark );
                border-radius: var( --m3-inputText-borderRadius );
                padding: 0px 10px;
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
                <section id='setupContainer' class='primaryColor center'>
                    <span class='max-width left sectionTitle' style='font-size: 30px'><img src='/src/icons/settings.svg' style='width: 30px; vertical-align: middle; margin-bottom: 0px;' />Welcome to the Server Setup Process</span>
                    <section id='0' class='max-width left' style='display: block'>
                        Welcome to the Server Setup Process!<br>
                        You are here because the Server Database ('<code class='code'>openServer</code>') was not found, but don't worry, here we will setup the Database!
                    </section>
                    <section id='1' class='max-width left' style='display: none'>
                        Here the process to prepare you Server:<br>
                        <ul>
                            <li>
                                In Linux run in the Terminal <code class='code'>sudo apt-get update && sudo apt-get upgrade -y && sudo apt-get install mariadb-server -y</code> to install <code class='code'>MariaDB</code> (if you already have <code class='code'>MySQL</code> skip this step)
                            </li>
                            <li>
                                Now install the SQL plugin for PHP with <code class='code'>sudo apt-get install php-mysql -y</code>
                            </li>
                            <li>
                                (Optional) Install the Zip and mbstring plugin for PHP with <code class='code'>sudo apt-get install php-files php-zip php-mbstring -y</code>
                            </li>
                            <li>
                                Enter the Database with <code class='code'>sudo mysql</code>
                            </li>
                            <li>
                                Create the Server Database <code class='code'>CREATE DATABASE `openServer`;</code>
                            </li>
                            <li>
                                Now you will need to create 2 User for the Database, one for Reading only the Database (The <code class='code'>SELECT</code> type will be fine) and another to Write and Delete elements (<code class='code'>ALL PRIVILEGES</code> is mandatory).<br>
                                Use this <a href='https://phoenixnap.com/kb/how-to-create-mariadb-user-grant-privileges' target='_blank' style='text-decoration: underline; color: var( --hoverColor );'>link</a> to learn how to create them and granting the access.<br>
                                Tip: Instead of writing <code class='code'>*.*</code> when granting access, write <code class='code'>openServer.*</code>
                            </li>
                        </ul>
                        If you want, you can use only 1 User, but you need to grant him '<code class='code'>ALL PRIVILEGES</code>'!<br><br>
                        When you are ready can go to the next page to insert the Database Credentials.
                    </section>
                    <section id='2' class='max-width left' style='display: none'>
                        Here we are, now fill the Form and if all is correct we are ready to go!<br><br>
                        <form id='saveCredentials' method='POST' enctype='multipart/form-data'>
                            Insert the host of the Database Server (If you inserted '%' int the Terminal then write 'localhost'): <input type='text' class='textInputs' name='host' required><br><br>
                            Insert the username for the Writer User: <input type='text' class='textInputs' name='writerUsername' required><br>
                            Insert the password for the Writer User: <input type='password' class='textInputs' name='writerPassword' required><br><br>
                            Insert the username for the Reader User (if you want to use only 1 user then re-type the Writer Username): <input type='text' class='textInputs' name='readerUsername' required><br>
                            Insert the password for the Reader User (if you want to use only 1 user then re-type the Writer Password): <input type='password' class='textInputs' name='readerPassword' required><br><br>
                            <button type='submit' class='button primaryColor-Dark left'>Save</button><br><br>
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

    <script>
        console.log("Server Scripts (JavaScript) Disabled\nRunning essentials Scripts for Setup Process");
        var currentProcecssStatus = 0;
        $('#back').click(function () {
            $('#continue').css('display', 'block');
            if ( currentProcecssStatus > 0 ) {
                $('#' + currentProcecssStatus).css('display', 'none');
                currentProcecssStatus--;
                $('#' + currentProcecssStatus).css('display', 'block');
            } else {
                currentProcecssStatus = 0;
            }
            if ( currentProcecssStatus == 0 )
                $('#back').css('display', 'none');
        });
        $('#continue').click(function () {
            $('#back').css('display', 'block');
            $('#' + currentProcecssStatus).css('display', 'none');
            currentProcecssStatus++;
            $('#' + currentProcecssStatus).css('display', 'block');
            if ( currentProcecssStatus >= 2 )
                $('#continue').css('display', 'none');
        });

        $('form#saveCredentials').submit(function (e) {
            $('#saveCredentials').after('<span id=\'process\'><img src=\'/src/icons/loadingMini.svg\' />Saving...</span>')
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: '/src/API/saveCredentials.php',
                type: 'POST',
                data: formData,
                success: function (data) {
                    alert( data );
                    $('#process').remove();
                    if ( data == "Success: Everything is fine, you can now use 'openServer'!" ) {
                        history.back();
                    }
                    //alert( data + '\nYou will be now redirected' );
                    //window.location.href = $('#sourcePath').val();
                    //history.back();
                },
                error: function (data) {
                    console.log( data );
                    alert("Error: There was an error when connecting to the API, try in a few minutes");
                    $('#process').remove();
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    </script>

</html>