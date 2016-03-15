<?php

$mysqli = new mysqli("localhost", "root", "root", "biblioteca");
$mysqli->set_charset('utf8');
if (mysqli_connect_errno()) {
    printf("Error: %s\n", mysqli_connect_errno());
    exit();
}

$codiLlibre = $_POST["llibre"];
$codiAutor = $_POST["autor"];
​
$sql = "DELETE FROM LLI_AUT WHERE FK_IDLLIB = $codiLlibre AND FK_IDAUT= $codiAutor";
​
​
$cursor = $mysqli->query($sql) or die("Error sql:$sql");
​
echo "OK";