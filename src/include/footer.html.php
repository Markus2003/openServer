<footer class='primaryColor'>
    <b><code>openServer</code></b><br>
    an open source program from <code>Marco Ricci</code><br>
    <a href='https://github.com/Markus2003'><img src='/src/icons/github.svg' /></a><br>
    <h5 id='version'>
        <code>openServer</code> version: <?php echo '<code>' . file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/configs/versionName' ) . '</code> - <code>' . file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/configs/versionStatus' ) . '-' . file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/configs/version' ) . '</code>' ?>
    </h5>
</footer>