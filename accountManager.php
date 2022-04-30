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
                            <td>Userpath</td><td><button type='button' id='revealUserpath' class='button primaryColor shadow'>Show my Userpath</button></td>
                        </tr>
                        <tr>
                            <td>You are an Admin</td><td><b><?php if ( $_SESSION["openServerFlags"] ) echo "True"; else echo "False"; ?></b></td>
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
            </div>

            <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/footer.html.php' ?>
        </div>

    </body>

    <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/script.html.php' ?>
    <script>
        $('#revealUserpath').click(function () {
            if ( confirm('Do you really want to reveal your \'Userpath\'?\nThis string say where is your Personal Vault on the Server, keep it secret!') ) {
                var password = prompt('Insert your password to confirm this action:');
                $.ajax({
                    url: '/src/API/revealPath.php?email=<?php echo $_SESSION["openServerEmail"] ?>&password=' + password,
                    success: function (data) {
                        console.log( data );
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
                    var password = prompt('Insert you password to confirm this critical action:');
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
    </script>

</html>