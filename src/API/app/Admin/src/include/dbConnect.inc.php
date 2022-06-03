<?php
    $credentials = json_decode(file_get_contents('../src/configs/dbCredentials.json'), true);
    $db = new mysqli( $credentials["host"], $credentials["username"], $credentials["password"], $credentials["defaultDB"] );
?>