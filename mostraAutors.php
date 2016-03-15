<?php

$mysqli = new mysqli("localhost", "root", "root", "biblioteca");
$mysqli->set_charset('utf8');
if (mysqli_connect_errno()) {
    printf("Error: %s\n", mysqli_connect_errno());
    exit();
}

$codigo = $_POST["id"];

$sql = "SELECT * FROM LLI_AUT INNER JOIN AUTORS ON ( LLI_AUT.FK_IDAUT = AUTORS.ID_AUT ) WHERE FK_IDLLIB =$codigo";

$cursor = $mysqli->query($sql) or die("Error sql:$sql");

$taula = array();
while ($reg = $cursor->fetch_assoc()) {
    $taula[] = array_map('utf8_encode', $reg);

}

header('Content-type: application/json');
echo json_encode($taula);

