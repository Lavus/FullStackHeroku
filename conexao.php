<?php
    $host='localhost';
    $user='root';
    $pass='';
    $base='fullstack';
    $mysqli = new mysqli($host,$user,$pass,$base);
    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }
?>
