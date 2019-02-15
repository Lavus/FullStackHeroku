<?php
    //Get Heroku ClearDB connection information
    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
    $host = $url["host"];
    $user = $url["user"];
    $pass = $url["pass"];
    $base = substr($url["path"], 1);
    $mysqli = new mysqli($host,$user,$pass,$base);
    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }
?>
