<?PHP

$mysqli = new mysqli("localhost", "root", "root", "biblioteca");
$mysqli->query("SET NAMES 'utf8'");
$t = $_GET["term"];
$cadena = "select colleccio as value from COLLECCIONS where colleccio like '%$t%' order by colleccio";
$curs = $mysqli->query($cadena);
$taula = array();
while ($reg = $curs->fetch_assoc()) {
    $taula[] = array_map('utf8_encode', $reg);
}
header('Content-type: application/json');
echo json_encode($taula);

