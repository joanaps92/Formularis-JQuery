<?php

$mysqli = new mysqli("localhost", "root", "root", "biblioteca");
$mysqli->set_charset('utf8');
if (mysqli_connect_errno()) {
    printf("Error: %s\n", mysqli_connect_errno());
    exit();
}

$nom = $_POST["nouNom"];

if (!empty($_POST["nouNaixament"])) {
    $nouNaix = $_POST["nouNaixament"];
} else {
    $nouNaix = "NULL";
}

if (!empty($_POST["novaNacionalitat"])) {
    $novaNac = $_POST["novaNacionalitat"];
} else {
    $novaNac = "NULL";
}



$selectMax = "SELECT MAX(ID_AUT) FROM AUTORS";
$maxAutor = $mysqli->query($selectMax) or die("Error sql:$selectMax");
$maxAutor++;

$sql = "INSERT INTO AUTORS (ID_AUT,NOM_AUT,DNAIX_AUT,FK_NACIONALITAT)
VALUES ($maxAutor, '$nom', '$novaNac', '$nouNaix')";

$cursor = $mysqli->query($sql) or die("Error sql:$sql");


echo "OK";
