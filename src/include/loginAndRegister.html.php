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
            <div id='loginDiv'>
                <form id='loginForm' class='accessForm primaryColor' action='/src/API/accessValidator.php' method='POST'>
                    <h3>Login</h3><br>
                    E-Mail:<br><input type='email' class='textInputs' name='email' placeholder='elonmusk@mars.com' /><br><br>
                    Password:<br><input type='password' class='textInputs password' name='password' placeholder='XÆA-12' /><img src='/src/icons/visibilityOn.svg' class='revealPassword' /><br><br>
                    <input type='hidden' name='type' value='login' />
                    <input type='submit' id='loginButton' class='button shadow primaryColor-Dark' />
                </form>
            </div>
            <div id='registrationDiv'>
                <form id='registrationForm' class='accessForm primaryColor' action='/src/API/accessValidator.php' method='POST' style='display: none'>
                    <h3>Registration</h3><br>
                    Username:<br><input type='text' class='textInputs' name='username' placeholder='Elon Musk' /><br><br>
                    E-Mail:<br><input type='email' class='textInputs' name='email' placeholder='elonmusk@mars.com' /><br><br>
                    Password:<br><input type='password' class='textInputs password' name='password' placeholder='XÆA-12' /><img src='/src/icons/visibilityOn.svg' class='revealPassword' /><br><br>
                    Repeat Password:<br><input type='password' class='textInputs password' name='repeatedPassword' placeholder='XÆA-12' /><img src='/src/icons/visibilityOn.svg' class='revealPassword' /><br><br>
                    <input type='hidden' name='type' value='registration' />
                    <input type='submit' id='registerButton' class='button shadow primaryColor-Dark' />
                </form>
            </div>
        </td>
    </tr>
</table>

<script>
    $('form#loginForm').submit(function (e) {
        $('#loginButton').after('<div class=\'uploader\'><img src=\'/src/icons/loadingMini.svg\' />Logging In...</div>');
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: '/src/API/accessValidator.php',
            type: 'POST',
            data: formData,
            success: function (data) {
                $('#notice').remove();
                if ( data == 'Success: Log-In successfull' ) {
                    //alert( data + '\nYou will be now redirected' );
                    window.location.href = '/';    
                } else {
                    alert( data );
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
    
    $('form#registrationForm').submit(function (e) {
        $('#registerButton').after('<div class=\'uploader\'><img src=\'/src/icons/loadingMini.svg\' />Registering...</div>');
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: '/src/API/accessValidator.php',
            type: 'POST',
            data: formData,
            success: function (data) {
                $('#notice').remove();
                alert( data + '\nThe page will now reload' );
                location.reload();
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
</script>