<?php

    require_once("../../php/database.php");
    require_once("db-info.php");
    
    if($_GET["table"]) {

        $table = $_GET["table"];
        $sql = "SELECT * FROM ".$table;
        $result = $GLOBALS["conn"]->query($sql);

        $sqlColumnName = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".$table."'";
        $resultColumnName = $GLOBALS["conn"]->query($sqlColumnName);

        $sqlRows = "SELECT * FROM ".$table;
        $resultRows = $GLOBALS["conn"]->query($sqlRows);

        
        echo "<div class='view-table'><a href='insert-update-rows.php?table=".$table."' role='button' class='btn btn-secondary add-new-row-button'>Inserici nuova riga</a>";
        

        if($resultRows->num_rows == 0) {
            echo "<div class='alert alert-primary' role='alert'>Nessuna riga presente nel database</div>";
        } else {

            $columnsName = array();
            echo "<div class='table-responsive table-bordered'><table class='table-hover'><tr><th></th><th></th>";
            while($row = mysqli_fetch_array($resultColumnName)) {
                echo "<th>".$row["COLUMN_NAME"]."</th>";
                array_push($columnsName, $row["COLUMN_NAME"]);
            }
            echo "</tr>";

            while($row = mysqli_fetch_array($resultRows)) {
                $id = $row[$PRIMARY_KEYS[$table]];
                echo "<tr id='".$id."''>";
                echo "<td><a href='insert-update-rows.php?table=".$table."&id=".$id."' role='button' class='btn btn-warning modify-row-button' value='".$id."'>Modifica</button></td><td><button class='btn btn-danger delete-row-button' value='".$id."'>Cancella</button></td>";
                foreach($columnsName as $columnName) {
                    if($columnName != $PRIMARY_KEYS[$table] && in_array($columnName, $PRIMARY_KEYS)) {
                        $extern_table = array_search($columnName, $PRIMARY_KEYS);
                        $sql2 = getQuerySearchExternByID($extern_table, $row[$columnName]);
                        $result2 = $GLOBALS["conn"]->query($sql2);
                        if($result2->num_rows != 0) {
                            $row2 = mysqli_fetch_array($result2);
                            echo "<td>".implode(", ", array_unique($row2))."</td>";
                        }
                    } else {
                        echo "<td>".$row[$columnName]."</td>";
                    }
                }
                echo "</tr>";
            }
            echo "</table></div>";
        }
        echo "</div>";
    }

?>