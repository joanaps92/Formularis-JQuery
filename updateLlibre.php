<?php

$mysqli = new mysqli("localhost", "root", "root", "biblioteca");
$mysqli->set_charset('utf8');
if (mysqli_connect_errno()) {
    printf("Error: %s\n", mysqli_connect_errno());
    exit();
}

$codi = $_POST["codi"];
$titol = $_POST["'titol'"];
$nEdicio = $_POST["'nEdicio'"];
$any = $_POST["any"];
$lloc = $_POST["'lloc'"];
$desc = $_POST["'desc'"];
$isbn = $_POST["'isbn'"];
$legal = $_POST["'legal'"];
$sig = $_POST["'sig'"];
$col = $_POST["'col'"];
$dep = $_POST["'dep'"];
$edi = $_POST["edi"];
$llen = $_POST["'llen'"];

$sql = "UPDATE `biblioteca`.`llibres`
SET
TITOL = $titol,
NUMEDICIO = $nEdicio,
LLOCEDICIO = $lloc,
ANYEDICIO = $any,
DESCRIP_LLIB = $desc,
ISBN = $isbn,
DEPLEGAL = $dep,
SIGNTOP = $sig,
FK_COLLECCIO = $col,
FK_DEPARTAMENT = $dep,
FK_IDEDIT = $edi,
FK_LLENGUA = $llen,
WHERE ID_LLIB = $codi";

$cursor = $mysqli->query($sql) or die("Error sql:$sql");
echo "OK";