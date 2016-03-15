<?php
session_start();
//print_r($_GET);
 $mysqli = new mysqli("localhost", "root", "root", "biblioteca");
            if (mysqli_connect_errno()) {
                printf("Error: %s\n", mysqli_connect_errno());
                exit();
            }
            $mysqli->query("SET NAMES 'utf8'");
$vBusqueda = "";
$modifica = "";
foreach ($_GET as $key => $value) {
    $_SESSION[$key] = $value;
    $vBusqueda = isset($_SESSION["busqueda"]) ? $_SESSION["busqueda"] : "";
}
$rs = $mysqli->prepare("SELECT MAX(ID_LLIB) FROM LLIBRES");
                $rs->execute();
                $rs->bind_result($maxId);
                while ($rs->fetch()) {
                }
                $maxId++;
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Untitled Document</title>
        <link href="estils/style.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <div id="Llibres">
            <form action="mantenimentForm.php" method="post" id="myform" name="myform">
                <label for="order">Ordenat per: </label>
                <select name="order">
                    <option label="ID_Llibre" value="ID_LLIB">ID_Llibre</option>
                    <option label="Titol" value="TITOL">Titol</option>
                </select>
                <label for="busqueda">Cercar</label>
                <input type="text" name="busqueda" <?php echo 'value="' . $vBusqueda . '"' ?>>
                <input name="boto" type="submit">
            </form>
        </div>
        <div id="nou_llibre">
            <form action="formManteniment.php" method="get" id="myform" name="myform">
                <fieldset>
                    <legend>Nou Llibre</legend>
                    <input type="hidden" name="MAX_ID" value="<?php $maxId ?>"/>
                    <input type="submit" name="botoInserir" >
                </fieldset>
            </form>
        </div>
        <?php
        try {
            $mysqli = new mysqli("localhost", "root", "root", "biblioteca");
            if (mysqli_connect_errno()) {
                printf("Error: %s\n", mysqli_connect_errno());
                exit();
            }
            $mysqli->query("SET NAMES 'utf8'");
            $insert = "";
            /*if (isset($_GET["botoInserir"])) {
                $insert = $_GET["inserir"];
                $rs = $mysqli->prepare("SELECT MAX(ID_LLIB) FROM LLIBRES");
                $rs->execute();
                $rs->bind_result($maxId);
                while ($rs->fetch()) {
                }
                $maxId++;
            }*/

            if (isset($_GET["BotoBorrar"])) {
                $delete = $_GET["ID_LLIB"];
                $sqlDELETE = "DELETE FROM LLIBRES WHERE ID_LLIB LIKE \"$delete\"";
                $del = $mysqli->query($sqlDELETE);
                //print_r($sqlDELETE);
            }

            if (isset($_GET["BotoGuardar"])) {
                $update = $_GET["ID_LLIB"];
                $update2 = $_GET["TITOL"];
                $sqlUpdate = "UPDATE LLIBRES SET TITOL=\"$update2\" WHERE ID_LLIB=\"$update\"";
                $upd = $mysqli->query($sqlUpdate);
                print_r($sqlUpdate);
            }

            $order = isset($_SESSION["order"]) ? $_SESSION["order"] : "ID_LLIB";
            $like = isset($_SESSION["busqueda"]) ? $_SESSION["busqueda"] : "%";
            $where = "WHERE $order LIKE '%$like%'";
            $query_max_results = "SELECT ID_LLIB, TITOL
        FROM LLIBRES
        $where
        ORDER BY $order";
            $result = $mysqli->query($query_max_results);
            $total = $result->num_rows;
            $limit = 20;
            $pages = ceil($total / $limit);
            $page = isset($_GET["PAGINA"]) ? $_GET["PAGINA"] : min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
                        'options' => array(
                            'default' => 1,
                            'min_range' => 1,
                        ),
            )));
            $offset = ($page - 1) * $limit;
            $start = $offset + 1;
            $end = min(($offset + $limit), $total);
            $prevlink = ($page > 1) ? '<a href="?page=1" title="First page">&laquo;</a> <a href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';
            $nextlink = ($page < $pages) ? '<a href="?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="?page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';
            echo '<div id="paging"><p>[', $prevlink, '  ', $nextlink, ']', $page, '-', $pages, '</p></div>';

//            $sql = "SELECT ID_LLIB, TITOL, NOM_EDIT, FK_DEPARTAMENT, ISBN from LLIBRES, EDITORS";
//
//                $sql.=" WHERE $orderby LIKE '%$textcerca%' and (LLIBRES.FK_IDEDIT=EDITORS.ID_EDIT)";
//
//                $sql.=" ORDER BY $orderby $sentit";
//
//                $sql.=" limit $offset," . FILES_PER_PAGINA;
            $query = "
        SELECT ID_LLIB, TITOL, NOM_EDIT,  FK_DEPARTAMENT, ISBN
        FROM LLIBRES, EDITORS
        $where and (LLIBRES.FK_IDEDIT=EDITORS.ID_EDIT)
        ORDER BY $order
        LIMIT $limit
        OFFSET $offset";
            echo $query;
            $stmt = $mysqli->query($query);
            if ($stmt->num_rows > 0) {
                $iterator = new IteratorIterator($stmt);
                echo '<table><tr id="primera"><td>Codi</td><td>Titol</td><td>Editorial</td><td>Departament</td><td>ISBN</td></tr>';
                foreach ($iterator as $row) {
                    $id = $row["ID_LLIB"];
                    $titol = $row["TITOL"];
                    $editorial = $row["NOM_EDIT"];
                    $departament = $row["FK_DEPARTAMENT"];
                    $isbn = $row["ISBN"];
                    echo "<tr id=\"parell\"><td>" . $id . "</td><td>" . $titol . "</td><td>" . $editorial . "</td><td>" . $departament . "</td><td>" . $isbn . "</td><td>
<form name='Editar' id='Editar1' action='formManteniment.php' method='get' class='formulariBoto'>
<div>
<input type='hidden' name='OPERACIO' value='EDITA'>
<input type='hidden' name='ORDRE' value='$order'>
<input type='hidden' name='PAGINA' value='$page'>
<input type='hidden' name='TEXTCERCA' value=''>
<input type='hidden' name='ID_LLIB' value='$id'>
<input type='Submit' name='BotoEdicio' value='Editar'>
</div>
</form>
</td>";
                }
            } else {
                echo '<p>No results could be displayed.</p>';
            }
        } catch (Exception $e) {
            echo '<p>', $e->getMessage(), '</p>';
        }
        ?>
    </body>
</html>
