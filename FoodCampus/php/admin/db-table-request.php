<?php
    require_once("../database.php");

    if($_GET["table"]) {

        $table = $_GET["table"];
        $sql = "SELECT * FROM ".$table;
        $result = $GLOBALS["conn"]->query($sql);

        $sqlColumnName = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".$table."'";
        $resultColumnName = $GLOBALS["conn"]->query($sqlColumnName);

        $sqlRows = "SELECT * FROM ".$table;
        $resultRows = $GLOBALS["conn"]->query($sqlRows);

        ?>
            <button type="button" class="btn btn-secondary">Inserici nuova riga</button>
        <?php

        if($resultRows->num_rows == 0) {
            echo "<div class='alert alert-primary' role='alert'>Nessuna riga presente nel database</div>";
        } else {

            $columnsName = array();
            echo "<div class='table-responsive'><table class='table-hover'><tr>";
            while($row = mysqli_fetch_array($resultColumnName)) {
                echo "<th>".$row["COLUMN_NAME"]."</th>";
                array_push($columnsName, $row["COLUMN_NAME"]);
            }
            echo "<th></th><th></th></tr>";

            while($row = mysqli_fetch_array($resultRows)) {
                $id = -1;
                $first = true;
                foreach($columnsName as $columnName) {
                    if($first) {
                        $id = $row[$columnName];
                        echo "<tr id='".$id."''>";
                        $first = false;
                    }
                    echo "<td>".$row[$columnName]."</td>";
                }
                echo "<td><button type='button' class='btn btn-warning enable-button' value='"
                .$id."'>Modifica</button></td><td><button type='button' class='btn btn-danger enable-button' value='"
                .$id."'>Cancella</button></td></tr>";
            }
            echo "</table></div>";
        }

    

    }

?>