<?php

    function printAccountPhoto () {

        session_start();
        if ( isset( $_SESSION["openServerUsername"] ) ){
            echo "<a href='/accountManager.php'><img src='/src/icons/account.svg' alt='Account Photo' id='accountPhoto' width='48px' height='auto' /></a>";
        } else {
            echo "<a href='/login.php'><img src='/src/icons/account.svg' alt='Account Photo' id='accountPhoto' width='48px' height='auto' /></a>";
        }

    }

?>
<header id='header' class='primaryColor'>
    <div class='hamburgerIcon' onclick='sideBarToggler(this)'>
        <div class='bar1'></div>
        <div class='bar2'></div>
        <div class='bar3'></div>
    </div>
    <text id='webTitle'>openServer <code id='directory'><?php echo getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder ?></code></text>
    <a href='/search.php'><img src='/src/icons/search.svg' id='searchButton' /></a>
    <?php printAccountPhoto(); ?>
</header>
<div id='headerGhost'></div>