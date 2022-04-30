<?php
    if ( isset( $_GET["directory"] ) and isset( $_GET["oldChunkName"] ) and isset( $_GET["newChunkName"] ) ) {
        chdir( $_SERVER["DOCUMENT_ROOT"] . $_GET["directory"] );
        rename( $_GET["oldChunkName"], $_GET["newChunkName"] );
    }
?>