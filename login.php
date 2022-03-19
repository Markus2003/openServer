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
            <table id='formTable' class='primaryColor'>
                <tr>
                    <th>
                        <button type='button' id='login' class='tabButton active'>Login</button>
                    </th>
                    <th>
                        <button type='button' id='registration' class='tabButton'>Registration</button>
                    </th>
                </tr>
                <tr>
                    <td colspan='2'>
                        <div id='loginForm'>
                            <form id='accessForm' class='primaryColor' action='/validator.php' method='POST'>
                                <h3>Login</h3><br>
                                E-Mail:<br><input type='email' class='textInputs' name='email' placeholder='mistermarc11@gmail.com' /><br><br>
                                Password:<br><input type='password' class='textInputs' name='password' placeholder='volevi...' /><br><br>
                                <input type='hidden' name='type' value='login' />
                                <input type='submit' class='button shadow primaryColor-Dark' />
                            </form>
                        </div>
                        <div id='registrationForm' style='display: none'>
                            <form id='accessForm' class='primaryColor' action='/validator.php' method='POST'>
                                <h3>Registration</h3><br>
                                Username:<br><input type='text' class='textInputs' name='username' placeholder='Mavcoloide' /><br><br>
                                E-Mail:<br><input type='email' class='textInputs' name='email' placeholder='mistermarc11@gmail.com' /><br><br>
                                Password:<br><input type='password' class='textInputs' name='password' placeholder='volevi...' /><br><br>
                                Repeat Password:<br><input type='password' class='textInputs' name='repeatedPassword' placeholder='volevi...' /><br><br>
                                <input type='hidden' name='type' value='registration' />
                                <input type='submit' class='button shadow primaryColor-Dark' />
                            </form>
                        </div>
                    </td>
                </tr>
            </table>

            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/footer.html.php' ?>
        </div>

    </body>

    <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/script.html.php' ?>

</html>