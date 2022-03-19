<?php

    function printAccountPhoto () {

        session_start();
        if ( isset( $_SESSION["openServerUsername"] ) ){
            echo "<a href='/accountManager.php'><img src='/src/icons/account.svg' alt='Foto Account' id='accountPhoto' width='48px' height='auto' /></a>";
        } else {
            echo "<a href='/login.php'><img src='/src/icons/account.svg' alt='Foto Account' id='accountPhoto' width='48px' height='auto' /></a>";
        }

    }

?>
<header id='header' class='primaryColor'>
    <div class='hamburgerIcon' onclick='sideBarToggler(this)'>
        <div class='bar1'></div>
        <div class='bar2'></div>
        <div class='bar3'></div>
    </div>
    <text id='webTitle'>openServer <code id='directory'><?php echo $_SERVER["REQUEST_URI"] ?></code></text>
    <?php printAccountPhoto(); ?><!--TODO: Dropdown Menu per l'Utente-->
</header>
<div id='headerGhost'></div>