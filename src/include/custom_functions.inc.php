<?php

    function isReadableForBrowser ( $fileName ) {

        $knowTypes = [ "mp3", "mp4", "m4a", "opus", "png", "jpg", "jpeg", "gif", "pdf", "txt", "html", "css", "scss", "js", "php", "json", "c", "cpp", "ino", "java", "py", "sh", "bat" ];

        if ( in_array( explode( ".", $fileName )[ count( explode( ".", $fileName ) ) - 1 ], $knowTypes ) )
            return TRUE;

        return FALSE;

    }

    function isReadableForServer ( $fileName ) {
        $audioTypes = [ "mp3", "m4a", "opus" ];
        $imageTypes = [ "png", "jpg", "jpeg", "gif" ];
        $videoTypes = [ "mp4", "avi", "mkv" ];
        $bookTypes = [ "epub", "pdf" ];
        $textTypes = [ "txt", "html", "css", "scss", "js", "php", "json", "c", "cpp", "ino", "java", "py", "sh", "bat", "sql" ];
        $archiveType = [ "zip", "tar", "rar", "7z", "xz" ];
        $installDiskType = [ "iso", "img" ];
        $androidInstallerTypes = [ "apk", "apkm", "abb" ];
        $extension = getFileExtension( $fileName );
        #$extension = explode( ".", $fileName )[ count( explode( ".", $fileName ) ) - 1 ];

        if ( in_array( $extension, $audioTypes ) ) 
            return "Audio";
        
        else if ( in_array( $extension, $videoTypes ) )
            return "Video";

        else if ( in_array( $extension, $imageTypes ) )
            return "Image";

        else if ( in_array( $extension, $bookTypes ) )
            return "Book";

        else if ( in_array( $extension, $textTypes ) )
            return "Text";

        else if ( in_array( $extension, $archiveType ) )
            return "Archive";

        else if ( in_array( $extension, $installDiskType ) )
            return "Install Disk";

        else if ( in_array( $extension, $androidInstallerTypes ) )
            return "Android Installer";

        else
            return FALSE;
    }

    function getFileExtension ( $fileName ) {
        return explode( ".", $fileName )[ count( explode( ".", $fileName ) ) - 1 ];
    }

    function checkBlacklistFolder ( $folderName ) {
        $blacklist = json_decode( file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/res/filesFoldersBlacklist.json' ), true );
        session_start();
        if ( !isset( $_SESSION["openServerUsername"] ) )
            array_push( $blacklist["folders"], "Personal Vault" );
        foreach ( $blacklist["folders"] as $test )
            if ( $folderName == $test )
                return FALSE;
        return TRUE;
    }

    function checkBlacklistFile ( $fileName ) {
        $blacklist = json_decode( file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/res/filesFoldersBlacklist.json' ), true );
        foreach ( $blacklist["files"] as $test )
            if ( $fileName == $test )
                return FALSE;
        return TRUE;
    }

    function generateUserpath ( $length = 15 ) {
        if ( $length > 15 )
            $length = 15;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen( $characters );
        $randomString = '';
        for ( $i = 0; $i < $length; $i++ )
            $randomString .= $characters[ rand( 0, $charactersLength - 1 ) ];
        return $randomString;
    }
    
    function checkIfUserpathExist( $userpath ) {
        include $_SERVER["DOCUMENT_ROOT"] . '/src/include/db_connect-Reader.inc.php';
        $result = $database->query("SELECT userpath FROM " . $credentials["defaultDatabase"] . ".users WHERE userpath='" . $userpath . "';");
        $database->close();
        if ( $result->num_rows == 0 )
            return FALSE;
        else
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

    function contains ( $whereToSearch, $whatToSearch ) {
        #if ( preg_match( '/(?<=[\s,.:;"\']|^)' . $whatToSearch . '(?=[\s,.:;"\']|$)/', $whereToSearch ) ) return true;
        return strpos( $whereToSearch, $whatToSearch ) !== false;
    }

    function printAppIconName ( $appName ) {
        if ( is_file( $_SERVER["DOCUMENT_ROOT"] . '/Applications/' . $appName . '/icon.svg' ) )
            return $appName . '/icon.svg';
        else
            return '/src/icons/applications.svg';
    }

    function printPrivateAppIconName ( $appName ) {
        if ( is_file( $_SERVER["DOCUMENT_ROOT"] . '/Personal Vault/' . $_SESSION["openServerUserpath"] . '/.privateApps/' . $appName . '/icon.svg' ) )
            return $_SESSION["openServerUserpath"] . '/.privateApps/' . $appName . '/icon.svg';
        else
            return '/src/icons/applications.svg';
    }

    function printFilmPoster ( $filmName ) {
        array_replace( $filmName, '.' . explode( '.', $filmName )[ count(explode( '.', $filmName )) - 1 ], '' );
        return $filmName;
    }

    function getInServerAddress ( $rawAddress ) {
        $result = '';
        $explodedAddress = explode( '/', $rawAddress );
        array_pop( $explodedAddress );
        foreach ( $explodedAddress as $chunk )
            $result .= $chunk . '/';
        return $result;
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

    function foldersize ( $path ) {
        $bytestotal = 0;
        $path = realpath( $path );
        if ( $path!==false && $path!='' && file_exists( $path ) )
            foreach ( new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $path, FilesystemIterator::SKIP_DOTS ) ) as $object )
                $bytestotal += $object->getSize();
        return $bytestotal;
    }

    function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    function checkIfShared ( $pathToShare, $fileShared ) {
        $pathToShare = str_replace( explode( '/', $pathToShare )[0], '', $pathToShare );
        include $_SERVER["DOCUMENT_ROOT"] . '/src/include/db_connect-Reader.inc.php';
        $result = $database->query("SELECT * FROM " . $credentials["defaultDatabase"] . ".shareRegister WHERE email='" . $_SESSION["openServerEmail"] . "' AND pathToShare='" . $pathToShare . "' AND fileShared='" . $fileShared . "';");
        $database->close();
        if ( $result->num_rows == 0 ) return false; else return true;
    }

    function generateUIID () {
        $numbers = '0123456789';
        $characters = 'abcdef';
        $numbersLength = strlen( $numbers );
        $charactersLength = strlen( $characters );
        $randomString = '';
        include $_SERVER["DOCUMENT_ROOT"] . '/src/include/db_connect-Reader.inc.php';
        do {
            $randomString = '';
            for ( $i = 0; $i < 8; $i++ )
                $randomString .= $numbers[ rand( 0, $numbersLength - 1 ) ];
            $randomString .= '-';
            for ( $i = 0; $i < 4; $i++ )
                $randomString .= $numbers[ rand( 0, $numbersLength - 1 ) ];
            $randomString .= '-';
            for ( $o = 0; $o < 2; $o++ ) {
                $randomString .= $characters[ rand( 0, $charactersLength - 1 ) ];
                for ( $i = 0; $i < 3; $i++ )
                    $randomString .= $numbers[ rand( 0, $numbersLength - 1 ) ];
                $randomString .= '-';
            }
            $randomString .= $characters[ rand( 0, $charactersLength - 1 ) ];
            for ( $i = 0; $i < 11; $i++ )
                $randomString .= $numbers[ rand( 0, $numbersLength - 1 ) ];
        } while ( $database->query("SELECT * FROM " . $credentials["defaultDatabase"] . ".shareRegister WHERE shareUUID='" . $randomString . "';")->num_rows != 0 );
        $database->close();
        return $randomString;
    }

?>