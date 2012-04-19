<?php

ini_set("memory_limit","512M");

$con = mysql_connect("%database_host%","%database_user%","%database_password%");
if (!$con) {
    die('Could not connect: ' . mysql_error());
}

mysql_select_db("%database_name%", $con);
$assetName = getLastPathSegment($_SERVER['REQUEST_URI']);
$result = mysql_query("SELECT * FROM mqm_asset WHERE name = '$assetName'");

while ($row = mysql_fetch_array($result)) {
    $data = $row['data'];
    $data = base64_decode($data);
    
    header('Content-type: image/jpeg');
    echo($data);
}

mysql_close($con);

function getLastPathSegment($url)
{
    $path = parse_url($url, PHP_URL_PATH); // to get the path from a whole URL
    $pathTrimmed = trim($path, '/'); // normalise with no leading or trailing slash
    $pathTokens = explode('/', $pathTrimmed); // get segments delimited by a slash

    return end($pathTokens); // get the last segment
}