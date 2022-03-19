<?php

    function isReadableForBrowser ( $fileName ) {

        $knowTypes = [ "mp3", "mp4", "m4a", "png", "jpg", "jpeg", "gif", "pdf", "txt", "html", "css", "scss", "js", "php", "json", "c", "cpp", "ino", "java", "py", "sh", "bat" ];

        if ( in_array( explode( ".", $fileName )[ count( explode( ".", $fileName ) ) - 1 ], $knowTypes ) )
            return TRUE;

        return FALSE;

    }

    function isReadableForServer ( $fileName ) {

        $imageTypes = [ "png", "jpg", "jpeg", "gif" ];
        $bookTypes = [ "epub", "pdf" ];
        $textTypes = [ "txt", "html", "css", "scss", "js", "php", "json", "c", "cpp", "ino", "java", "py", "sh", "bat", "sql" ];

        $extension = explode( ".", $fileName )[ count( explode( ".", $fileName ) ) - 1 ];

        if ( $extension == "mp3" ) 
            return "Audio";
        
        else if ( $extension == "mp4" )
            return "Video";

        else if ( in_array( $extension, $imageTypes ) )
            return "Image";

        else if ( in_array( $extension, $bookTypes ) )
            return "Book";

        else if ( in_array( $extension, $textTypes ) )
            return "Text";

        else
            return FALSE;

    }

    function checkBlacklistFolder ( $folderName ) {

        $blacklist = [".", "..", "hidden", ".hiddenApps", "src", "posters"];
        session_start();
        if ( !isset( $_SESSION["openServerUsername"] ) )
            array_push( $blacklist, "Personal Vault" );
        foreach ( $blacklist as $test )
            if ( $folderName == $test )
                return FALSE;
        
        return TRUE;

    }

    function checkBlacklistFile ( $fileName ) {

        return TRUE;

    }

    function getRelativeLink ( $directory ) {

        $explodedDirectory = explode( "/", $directory );
        $finalFolder = "";
        for ( $i = 1; $i != count( $explodedDirectory ) - 1; $i++ )
            if ( $explodedDirectory[ $i ] != null )
                $finalFolder += $explodedDirectory[ $i ] . "/";

        return $finalFolder;

    }

    function getScannableDir () {

        $dir = "";

        if ( is_file( $_SERVER["DOCUMENT_ROOT"] . $_SERVER["REQUEST_URI"] ) ) {

            $explodedRequest = explode( '/', $_SERVER["REQUEST_URI"] );
            for ( $i = 0; $i != count( $explodedRequest ) - 2; $i++ )
                $dir += $explodedRequest[ $i ] . "/";

            if ( $dir == "" )
                $dir = "/";

        } else
            $dir = $_SERVER["REQUEST_URI"];

        return $_SERVER["DOCUMENT_ROOT"] . $dir;

    }

    function findStringInArray ( $array, $string ) {

        for ( $i = 0; $i != count( $array ); $i++ )
            if ( $array[ $i ] == $string )
                return TRUE;

        return FALSE;

    }

    function printAppIconName ( $appName ) {

        if ( is_file( $_SERVER["DOCUMENT_ROOT"] . '/Applications/' . $appName . '/icon.svg' ) )
            return $appName . '/icon.svg';
        else
            return '/src/icons/applications.svg';

    }

    function formatSize ( $bytes ) {

        if ( $bytes >= 1073741824 ) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ( $bytes >= 1048576 ) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ( $bytes >= 1024 ) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ( $bytes > 1 ) {
            return $bytes . ' Bytes';
        } elseif ( $bytes == 1 ) {
            return $bytes . ' Byte';
        } else {
            return '0 Bytes';
        }
        
    }

?>