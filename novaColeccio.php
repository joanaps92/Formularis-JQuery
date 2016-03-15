<?php

$mysqli = new mysqli("localhost", "root", "root", "biblioteca");
$mysqli->set_charset('utf8');
if (mysqli_connect_errno()) {
    printf("Error: %s\n", mysqli_connect_errno());
    exit();
}

$coleccio = $_GET["nom"];

$sql = "INSERT INTO COLLECCIONS
VALUES ('$coleccio');";

$cursor = $mysqli->query($sql) or die("Error sql:$sql");

echo "OK";
