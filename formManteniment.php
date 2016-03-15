<?php
session_start();
//print_r($_GET);
foreach ($_GET as $key => $value) {
    $_SESSION[$key] = $value;
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Untitled Document</title>
        <link href="estils/style.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
    </head>
    <body>
        <div class="header">

        </div>
        <div class="formulari">
            <form action="" method="get" id="myform" name="myform">
                <fieldset>
                    <legend>Modifica Llibre</legend>
                    <?php
                    $mysqli = new mysqli("localhost", "root", "root", "biblioteca");
                    if (mysqli_connect_errno()) {
                        printf("Error: %s\n", mysqli_connect_errno());
                        exit();
                    }
                    $mysqli->query("SET NAMES 'utf8'");
                    $idLlibre = isset($_GET["ID_LLIB"]) ? $_GET["ID_LLIB"] : $_GET["MAX_ID"];

                    if (isset($_GET["botoInserir"])) {
                        echo '<p><label for="codi">Codi Llibre: </label>
                        <input id="codi" name="codi" value="' . $idLlibre . '" readonly/></p>
                    <p><label for="titol">Titol*: </label>
                        <input id="titol" name="titol"  required/></p>
                    <p><label for="nEdicio">Num. Edició: </label>
                    <input id="nEdicio" name="nEdicio"  />
                    <label for="any">Any Edició*: </label>
                    <input id="any" name="any" " required/></p>
                    <p><label for="lloc">Lloc Edició: </label>
                        <input id="lloc" name="lloc" /></p>
                    <p><label for="desc">Descripció: </label>
                        <textarea id="desc" name="desc"></textarea></p>
                    <p><label for="isbn">ISBN: </label>
                    <input id="isbn" name="isbn" />
                    <label for="legal">Depòsit Legal: </label>
                    <input id="legal" name="legal" /></p>
                    <p><label for="sig">Sig. Top.: </label>
                        <input id="sig" name="sig" /></p>
                    <p><label for="col">Col·lecció: </label>
                    <input id="col" name="col"/>';

                        echo '<button type="button" id="afegir_col">Afegir Col·lecció</button><label for="dep">Departament: </label>
                    <select id="dep" name="dep">';
                        $sqlDEP = 'SELECT DEPARTAMENT FROM departaments ORDER BY DEPARTAMENT';
                        $stmt5 = $mysqli->query($sqlDEP);
                        if ($stmt5->num_rows > 0) {
                            $iterator5 = new IteratorIterator($stmt5);
                            foreach ($iterator5 as $row5) {
                                if ($row5["DEPARTAMENT"] === $row4["FK_DEPARTAMENT"]) {
                                    echo '<option value="' . $row5["DEPARTAMENT"] . '">' . $row5["DEPARTAMENT"] . '</option>';
                                }
                            }
                        }
                        echo '</select></p>';

                        echo '<p><label for="edi">Editorial: </label>
                    <select id="edi" name="edi">';
                        $sqlEDI = 'SELECT NOM_EDIT FROM editors ORDER BY NOM_EDIT';
                        $stmt6 = $mysqli->query($sqlEDI);
                        if ($stmt6->num_rows > 0) {
                            $iterator6 = new IteratorIterator($stmt6);
                            foreach ($iterator6 as $row6) {
                                if ($row6["NOM_EDIT"] === $row4["NOM_EDIT"]) {
                                    echo '<option value="' . $row6["NOM_EDIT"] . '">' . $row6["NOM_EDIT"] . '</option>';
                                }
                            }
                        }
                        echo '</select>';
                        echo '<label for="llen">Llengua: </label>
                    <select id="llen" name="llen">';
                        $sqlLLEN = 'SELECT LLENGUA FROM llengues ORDER BY LLENGUA';
                        $stmt7 = $mysqli->query($sqlLLEN);
                        if ($stmt7->num_rows > 0) {
                            $iterator7 = new IteratorIterator($stmt7);
                            foreach ($iterator7 as $row7) {

                                echo '<option value="' . $row7["LLENGUA"] . '">' . $row7["LLENGUA"] . '</option>';
                            }
                        }
                        echo '</select></p>';
                    } else {
                        $queryForm = "SELECT ID_LLIB, TITOL, NUMEDICIO, LLOCEDICIO, ANYEDICIO, DESCRIP_LLIB, ISBN,DEPLEGAL, SIGNTOP, FK_COLLECCIO, FK_DEPARTAMENT, NOM_EDIT, FK_LLENGUA FROM llibres left join editors on FK_IDEDIT=ID_EDIT WHERE ID_LLIB=$idLlibre";
                        $stmt4 = $mysqli->query($queryForm);
                        if ($stmt4->num_rows > 0) {
                            $iterator4 = new IteratorIterator($stmt4);
                            foreach ($iterator4 as $row4) {
                                echo '<p><label for="codi">Codi Llibre: </label>
                        <input id="codi" name="codi" value="' . $idLlibre . '" readonly/></p>
                    <p><label for="titol">Titol*: </label>
                        <input id="titol" name="titol" value="' . $row4["TITOL"] . '" required/></p>
                    <p><label for="nEdicio">Num. Edició: </label>
                    <input id="nEdicio" name="nEdicio" value="' . $row4["NUMEDICIO"] . '" />
                    <label for="any">Any Edició*: </label>
                    <input id="any" name="any" value="' . $row4["ANYEDICIO"] . '" required/></p>
                    <p><label for="lloc">Lloc Edició: </label>
                        <input id="lloc" name="lloc" value="' . $row4["LLOCEDICIO"] . '"/></p>
                    <p><label for="desc">Descripció: </label>
                        <textarea id="desc" name="desc">' . $row4["DESCRIP_LLIB"] . '</textarea></p>
                    <p><label for="isbn">ISBN: </label>
                    <input id="isbn" name="isbn" value="' . $row4["ISBN"] . '"/>
                    <label for="legal">Depòsit Legal: </label>
                    <input id="legal" name="legal" value="' . $row4["DEPLEGAL"] . '"/></p>
                    <p><label for="sig">Sig. Top.: </label>
                        <input id="sig" name="sig" value="' . $row4["SIGNTOP"] . '"/></p>
                    <p><label for="col">Col·lecció: </label>
                    <input id="col" name="col"/>';

                                echo '<button type="button" id="afegir_col">Afegir Col·lecció</button></br><label for="dep">Departament: </label>
                    <select id="dep" name="dep">';
                                $sqlDEP = 'SELECT DEPARTAMENT FROM departaments ORDER BY DEPARTAMENT';
                                $stmt5 = $mysqli->query($sqlDEP);
                                if ($stmt5->num_rows > 0) {
                                    $iterator5 = new IteratorIterator($stmt5);
                                    foreach ($iterator5 as $row5) {
                                        if ($row5["DEPARTAMENT"] === $row4["FK_DEPARTAMENT"]) {
                                            echo '<option value="' . $row5["DEPARTAMENT"] . '" selected>' . $row5["DEPARTAMENT"] . '</option>';
                                        } else {
                                            echo '<option value="' . $row5["DEPARTAMENT"] . '">' . $row5["DEPARTAMENT"] . '</option>';
                                        }
                                    }
                                }
                                echo '</select></p>';

                                echo '<p><label for="edi">Editorial: </label>
                    <select id="edi" name="edi">';
                                $sqlEDI = 'SELECT NOM_EDIT FROM editors ORDER BY NOM_EDIT';
                                $stmt6 = $mysqli->query($sqlEDI);
                                if ($stmt6->num_rows > 0) {
                                    $iterator6 = new IteratorIterator($stmt6);
                                    foreach ($iterator6 as $row6) {
                                        if ($row6["NOM_EDIT"] === $row4["NOM_EDIT"]) {
                                            echo '<option value="' . $row6["NOM_EDIT"] . '" selected>' . $row6["NOM_EDIT"] . '</option>';
                                        } else {
                                            echo '<option value="' . $row6["NOM_EDIT"] . '">' . $row6["NOM_EDIT"] . '</option>';
                                        }
                                    }
                                }
                                echo '</select>';
                                echo '<label for="llen">Llengua: </label>
                    <select id="llen" name="llen">';
                                $sqlLLEN = 'SELECT LLENGUA FROM llengues ORDER BY LLENGUA';
                                $stmt7 = $mysqli->query($sqlLLEN);
                                if ($stmt7->num_rows > 0) {
                                    $iterator7 = new IteratorIterator($stmt7);
                                    foreach ($iterator7 as $row7) {
                                        if ($row7["LLENGUA"] === $row4["FK_DEPARTAMENT"]) {
                                            echo '<option value="' . $row7["LLENGUA"] . '" selected>' . $row7["LLENGUA"] . '</option>';
                                        } else {
                                            echo '<option value="' . $row7["LLENGUA"] . '">' . $row7["LLENGUA"] . '</option>';
                                        }
                                    }
                                }
                                echo '</select></p>';
                            }
                        }
                    }
                    ?>
                    <div id="autors">
                        <h3>AUTORS</h3>
                        
                        <button type="button" id="boto_afegir" style="float: left;">Afegir Autor</button>
                        <div id="ocult">
                                    <tr class="ocult">
                                        <td><label>Nom:</label><input type="text" name="nom" id="nom"/></td>
                                        <td><label>Nacionalitat:</label><input type="text" name="nacionalitat" id="nacionalitat"/></td>
                                        <td><label>Naixament:</label><input type="text" name="naixament" id="naixament"/></td>
                                    </tr>
                                    <tr class="ocult">
                                        <td>
                                            <button id="guardaAutor" type='button' class="btn waves-light green lighten-1">GUARDA</button>
                                        </td>
                                        <td>
                                            <button id="cancelaAutor" type="button" class="btn waves-light red lighten-1">CANCELA</button>
                                        </td>
                                    </tr>
                                </div>
                        <table id="taula_autors">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>NOM</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="body_table">
                                
                            </tbody>
                        </table>
                        <!--<table>
                            <tr class="trOcult">
                                <td>
                                    <button id="guardaAutor" type='button'>GUARDA</button>
                                </td>
                                <td>
                                    <button id="cancelaAutor" type="button">CANCELA</button>
                                </td>
                            </tr>

                        </table>-->
                    </div>
                </fieldset>
            </form>
        </div>
    </body>
</html>
