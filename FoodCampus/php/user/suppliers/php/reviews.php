<h2 class="text-center">Recensioni</h2>
<?php
if (!$isSupplier) {
    ?>
    <form id="newReview" class="form-group">
        <div class="pt-2">
            <input name="stars" id="valutationReview" class="rating rating-loading" data-min="0" data-max="5" data-step="0.5" value="4" data-size="lg">
        </div>
        <label for="commentReview" class="font-weight-bold">Scrivi la tua recensione</label>
        <textarea class="form-control" rows="5" id="commentReview" name="comment" placeholder="Che cosa ti è piaciuto e cosa non ti è piaciuto?" required></textarea>
        <label for="titleReview" class="font-weight-bold" id="addTitleReview">Aggiungi un titolo</label>
        <input type="text" class="form-control" id="titleReview" name="title" placeholder="Quali sono le cose più importanti da sapere?" required>
        <button type="submit" id="submitReview" class="btn btn-primary">Invia</button>
    </form>
    <?php
}
?>
<div class="col"><hr></div>
<?php
$query = "SELECT COUNT(*) AS numberReview, AVG(valutazione) AS averageRating FROM recensione WHERE IDFornitore = ?";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("s", $idSupplier);
    if ($stmt->execute()) {
        $res = $stmt->get_result();
        if ($res->num_rows == 1) {
            $row = $res->fetch_assoc();
            ?>
            <p id="numberReview" class="font-weight-bold"><?php echo $row["numberReview"];?> recensioni clienti</p>
            <div id="starAverageRating">
                <input class="rating rating-loading" data-min="0" data-max="5" data-step="1" value="<?php echo $row['averageRating'];?>" data-size="lg" data-showcaption=false disabled/>
            </div>
            <p id="averageRating"><?php echo number_format($row['averageRating'], 1);?> su 5 stelle</p>
            <?php
        }
    }
}
?>
<?php
$query = "SELECT nome, cognome, immagine, titolo, commento, valutazione FROM recensione R, cliente C WHERE R.IDCliente = C.IDCliente AND R.IDFornitore = ?";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("s", $idSupplier);
    if ($stmt->execute()) {
        $res = $stmt->get_result();
        ?>
        <div id="dividerFromReviews" class="col <?php if ($res->num_rows == 0) { echo 'notVisible'; } ?>"><hr></div>
        <div id="mediasReviews">
            <?php
            if ($res->num_rows > 0) {
                while($row = $res->fetch_assoc()) {
                    ?>
                    <div class="media border p-3">
                        <img src="../../../../res/clients/<?php echo $row["immagine"] != NULL ? $row["immagine"] : "default.png";?>" alt="<?php echo $row['nome'];?>" id="imageClient" class="mr-3 mt-3 rounded-circle">
                        <div class="media-body">
                            <input class="rating rating-loading" data-min="0" data-max="5" data-step="1" value="<?php echo $row['valutazione'];?>" data-size="md" data-showcaption=false disabled>
                            <span><?php echo $row['nome'];?></span>
                            <span class="font-weight-bold"><?php echo $row["titolo"];?></span>
                            <p><?php echo $row["commento"];?></p>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    <?php
    }
}
?>
