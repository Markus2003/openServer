<title>
    <?php echo file_get_contents( $_SERVER["DOCUMENT_ROOT"] . "/src/configs/serverName" ) ?>
</title>
<link rel="shortcut icon" type="image/jpg" href="/src/icons/openServer.ico?ver=<?php echo file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/configs/version' ) ?>"/>
<?php include $_SERVER["DOCUMENT_ROOT"] . '/src/include/head_content-no_title.html.php' ?>