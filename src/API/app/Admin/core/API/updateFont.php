<?php
    if ( isset( $_GET["font"] ) )
        file_put_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/customFont.css', '@font-face{font-family: \'Server Font\';src: url(\'/src/res/' . $_GET["font"] . '\');}');
?>