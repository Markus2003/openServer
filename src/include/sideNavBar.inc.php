<?php
    
    function randomGreetings () {

        $greetings = ["Hello", "Welcome back"];
        return $greetings[ rand( 0, count( $greetings ) - 1 ) ];

    }

    session_start();
    $jsonRes = json_decode( file_get_contents( $_SERVER["DOCUMENT_ROOT"] . '/src/res/iconForSection.json' ), true );

    if ( isset( $_SESSION["openServerUsername"] ) )
        echo "<p id='navBarGreetings'>" . randomGreetings() . ",<br>" . $_SESSION["openServerUsername"] . "!</p>";

    else
        echo "<p id='navBarGreetings'>Hello,<br>Guest!</p>";

    echo "<a href='/'><img src='/src/icons/home.svg' />Home</a>";
    $rawFolder = scandir( $_SERVER["DOCUMENT_ROOT"] );
    foreach ( $rawFolder as $folder )
        if ( is_dir( $_SERVER["DOCUMENT_ROOT"] . '/' . $folder ) and checkBlacklistFolder( $folder ) )
            if ( findStringInArray( $jsonRes["sectionName"], $folder ) )
                echo "<a href='/" . $folder . "'><img src='/src/icons/" . $jsonRes["sectionIcon"][ array_search( $folder, $jsonRes["sectionName"] ) ] . "' />". $folder . "</a>";
            else
                echo "<a href='/" . $folder . "'><img src='/src/icons/" . $jsonRes["fallback"] . "' />". $folder . "</a>";

?>