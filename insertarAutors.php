<?php

$mysqli = new mysqli("localhost", "root", "root", "biblioteca");
$mysqli->set_charset('utf8');
if (mysqli_connect_errno()) {
    printf("Error: %s\n", mysqli_connect_errno());
    exit();
}

$autor = $_POST["autor"];
$llibre = $_POST["llibre"];

$sql = "INSERT INTO LLI_AUT (FK_IDLLIB, FK_IDAUT)
VALUES ($llibre, $autor)";
       
$cursor = $mysqli->query($sql) or die("Error sql:$sql");


echo "OK";
