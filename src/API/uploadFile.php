<?php
    if ( isset( $_POST["path"] ) ) {
        for ( $i = 0; $i < count( $_FILES['file']['name'] ); $i++ ) {
            if ( !is_file( $_SERVER['DOCUMENT_ROOT'] . $_POST["path"] . basename( $_FILES['file']['name'][$i] ) ) )
                if ( move_uploaded_file( $_FILES['file']['tmp_name'][$i], $_SERVER['DOCUMENT_ROOT'] . $_POST["path"] . basename( $_FILES['file']['name'][$i] ) ) ) {
                    echo 'Success: File Uploaded';
                } else
                    echo 'Error: Error during File upload';
            else
                echo 'Error: File already exist';
        }
    } else
        echo 'Error: Necessary Argument \'path\' not passed via POST';

?>