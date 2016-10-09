<?php

/*
    error.php
    /srv/Sites/Vortex/html/php/error.php
    Nathan Denig
    nathan@denig.me

    error.php is called upon by the other pages and .htaccess when an error condition is encountered so that the proper message is displayed and handling is done safely. 

*/

    //Builds error messages in an associative array with error codes as each key
    $error_msg = array (
        "11" => "<h1>Error with Video File</h1>\n<p>Please confirm file is valid and not corrupted or try again with different filetype.</p>",
        "21" => "<h1>Upload Failed</h1>\n<p>Please confirm file size is under 400 mb and try again later.</p>",
        "31" => "<h1>SQL Connect Error</h1>\n<p>Please try again in a few minutes.</p>",
        "41" => "<h1>Unknown Video ID</h1>\n<p>Please ensure you entered a valid numerical ID value.</p>",
        "51" => "<h1>Unspecified Error</h1>\n<p>Please try again in a few minutes.</p>",
        "61" => "<h1>Playback Error</h1>\n<p>Problem with the video file, player, or stream. Try with another video and ensure you have enough bandwidth on a stable connection.</p>",
        "400" => "<h1>400:Bad Request</h1>",
        "401" => "<h1>401:Unauthorized Access</h1>",
        "403" => "<h1>403:Forbidden</h1>",
        "404" => "<h1>404:Not Found</h1>",
        "500" => "<h1>500:Internal Service Error</h1>"
    );

    //Determines error code from URL
    $error_code = $_SERVER['PATH_INFO'];
    $error_code = trim ($error_code , '/');

    if ($error_code == NULL || !array_key_exists($error_code, $error_msg)) {
        $error_code = "51";
    }

    //Builds page
    require("index_header.php");
    echo '<div class="center-text">';
    echo $error_msg[$error_code];
    echo "</div>";
    require("footer.php");

?>
