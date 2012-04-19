<?php

ini_set("memory_limit","512M");

// Turn off all error reporting as the error can be displayed as part of the image
error_reporting(0);

    $scriptName = getScriptName();
    $startPosition = strpos($_SERVER['REQUEST_URI'], $scriptName) + strlen($scriptName); 
    $assetPath = substr($_SERVER['REQUEST_URI'], $startPosition);
    $data = file_get_contents(__DIR__ . '/' . $assetPath);
    if ($data == false) {
        $assetName = getLastPathSegment($_SERVER['REQUEST_URI']);
        $con = mysql_connect("%database_host%","%database_user%","%database_password%");
        if (!$con) {
            die('Could not connect: ' . mysql_error());
        }
        mysql_select_db("%database_name%", $con);
        $result = mysql_query("SELECT * FROM mqm_asset WHERE name = '$assetName'");
        while ($row = mysql_fetch_array($result)) {
            $data = $row['data'];
            $data = base64_decode($data);
            file_put_contents(__DIR__ . '/' . $assetPath, $data);
            break;
        }
        mysql_close($con);
    }
    header('Content-type: image/jpeg');
    echo($data);

function getLastPathSegment($url)
{
    $path = parse_url($url, PHP_URL_PATH); // to get the path from a whole URL
    $pathTrimmed = trim($path, '/'); // normalise with no leading or trailing slash
    $pathTokens = explode('/', $pathTrimmed); // get segments delimited by a slash

    return end($pathTokens); // get the last segment
}

function getScriptName()
{
    $iPos = strrpos(__FILE__, "\\");
    $fileName = substr(__FILE__, $iPos + 1, strlen(__FILE__));
    
    return $fileName;
}