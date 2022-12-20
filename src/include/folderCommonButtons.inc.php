<?php
    echo "
        <section class='primaryColor shadow'>
            <span class='max-width left sectionTitle' style='font-size: 30px'><img src='/src/icons/folder.svg' style='width: 30px' /><b>" . $folder . "</b></span>
            <span class='max-width left chunk-size'><button type='button' class='button primaryColor withIMG getFolderSize' location=\"/" . str_replace( '%20', ' ', explode( '/', getInServerAddress( $_SERVER["REQUEST_URI"] ) )[1] ) . '/' . $overrideFolder . $folder . "/\"><img src='/src/icons/error.svg' />Get Folder Size</button></span>
            <article class='max-width'>
                <form action='" . $_SERVER["PHP_SELF"] . "' method='GET'>
                    <input type='hidden' name='overrideFolder' value=\"" . addslashes( $overrideFolder . $folder ) . "/\" />
                    <button type='submit' class='button right shadow primaryColor-Dark'><img src='/src/icons/forward_arrow.svg' /></button>
                </form>
                <button type='button' class='button primaryColor-Dark right shadow' onclick=\"renameFolder( '" . addslashes( getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder ) . "', '" . addslashes( $folder ) . "' )\"><img src='/src/icons/edit.svg' /></button>
                <button type='button' class='button primaryColor-Dark right shadow' onclick=\"deleteFolder( '" . addslashes( getInServerAddress( $_SERVER["PHP_SELF"] ) . $overrideFolder ) . "', '" . addslashes( $folder ) . "' )\"><img src='/src/icons/bin.svg' /></button>
            </article>
        </section>
    ";
?>