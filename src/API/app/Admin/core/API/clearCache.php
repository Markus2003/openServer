<?php
    chdir( $_SERVER["DOCUMENT_ROOT"] );
    if ( is_file( 'update.zip' ) )
        unlink('update.zip');
?>