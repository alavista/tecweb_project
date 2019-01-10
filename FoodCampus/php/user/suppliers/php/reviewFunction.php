<?php
function addReview($conn, $idClient, $idSupplier, $title, $comment, $valutation) {
    $query="INSERT INTO `recensione` (`IDCliente`, `IDFornitore`, `titolo`, `commento`, `valutazione`) VALUES (?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("sssss", $idClient, $idSupplier, $title, $comment, $valutation);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
?>
