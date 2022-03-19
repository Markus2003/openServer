<?php
    if ( !is_dir( $_SERVER['DOCUMENT_ROOT'] . '/Applications/' . explode( '.', basename( $_FILES['file']['name'] ) )[0] . '/' ) )
        if ( move_uploaded_file( $_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/Applications/' . basename( $_FILES['file']['name'] ) ) ) {
            $fileName = basename( $_FILES['file']['name'] );
            chdir( $_SERVER['DOCUMENT_ROOT'] . '/Applications' );
            mkdir( explode(  '.', $fileName )[0], 0777 );
            system('unzip -q -d \'' . explode(  '.', $fileName )[0] . '/\' \'' . $fileName . '\' && rm \'' . $fileName . '\'' );
            echo 'Success: App installed';
        } else
            echo 'Error: Error during installation, App not installed';
    else
        echo 'Error: App already exist';
?>