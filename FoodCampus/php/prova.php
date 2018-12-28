<?php
    require_once 'database.php';

    $query = "SELECT nome, indirizzo_via FROM fornitore";
    if ($stmt = $conn->prepare($query)) {
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                echo $row["indirizzo_via"];
                $query = "SELECT nome FROM fornitore WHERE nome = ?";
                if ($stmt = $conn->prepare($query)) {
                    $stmt->bind_param("s", $row["nome"]);
                    $stmt->execute();
                    $res1 = $stmt->get_result();
                    if ($res1->num_rows > 0) {
                        while ($row1 = $res1->fetch_assoc()) {
                            echo $row1["nome"];
                        }
                    }
                }
            }
        }
    }





?>
