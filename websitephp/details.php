<?php

    // Verbindung zur Datenbank
	$conn = mysqli_connect('localhost', 'admin123', 'test123', 'recipies');

	// Verbindung prüfen
	if(!$conn){
		echo 'Connection error: '. mysqli_connect_error();
	}
	
    if(isset($_POST['delete'])){

        $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

		$sql = "DELETE FROM gerichte WHERE id = $id_to_delete";

		if(mysqli_query($conn, $sql)){
			header('Location: rezepte.php');
		} else {
			echo 'query error: '. mysqli_error($conn);
		}

	}

    if(isset($_POST['increment']) ){

        $id_to_increment = mysqli_real_escape_string($conn, $_POST['id_to_increment']);

		$sql = "UPDATE gerichte SET votes = votes + 1 WHERE id = $id_to_increment";

		if(mysqli_query($conn, $sql)){	
            header('Location: rezepte.php');
		} else {
			echo 'query error: '. mysqli_error($conn);
		}

	}
    if(isset($_POST['decrement']) ){

        $id_to_decrement = mysqli_real_escape_string($conn, $_POST['id_to_decrement']);

		$sql = "UPDATE gerichte SET votes = votes - 1 WHERE id = $id_to_decrement";

		if(mysqli_query($conn, $sql)){	
            header('Location: rezepte.php');
		} else {
			echo 'query error: '. mysqli_error($conn);
		}

	}

// prüft GET request id parameters
if(isset($_GET['id'])){
		
    // escape sql chars
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // sql querie erstellen
    $sql = "SELECT * FROM gerichte WHERE id = $id";

    $result = mysqli_query($conn, $sql);

    // Ergebnis im Array-Format abrufen
    $dish = mysqli_fetch_assoc($result);
	// Verbindund schliessen
	mysqli_free_result($result);
    mysqli_close($conn);


}
$errors = array('email' => '', 'komment' => '');
?>

<!DOCTYPE html>
<html>

<?php include('templates/header.php'); ?>
<div class="container">
<div class="containercenter">
    <?php if($dish): ?>
    <?php else: ?>
        <h5>No such dish exists.</h5>
    <?php endif ?>
</div>
<div>
    <h2 class="dTitle"><?php echo htmlspecialchars($dish['title']); ?></h6>
    <div class="zutat"><h3 class="ingred">Ingredients/Zutaten</h3>
    <ul>
		<?php foreach(explode(',', $dish['Ingredients']) as $ing): ?>
			<li class="lists"><?php echo htmlspecialchars($ing); ?></li>
        <?php endforeach; ?>
	</ul></div>
    <div><h2 class="zeit">Koch Zeit/Cooking Time : <?php echo $dish['time']; ?> Minutes</h2></div>
</div>
<div class="info">
<p>Created by <?php echo $dish['email']; ?> at <?php echo date($dish['dateCreated']); ?></p><br>
<h3>Schritte</h3>
<p><?php echo $dish['steps']; ?></p>
</div>
</div>

<!-- Votes FORM -->
<form class="increment" action="details.php" method="POST">
	<input type="hidden" name="id_to_increment" value="<?php echo $id; ?>">
	<input type="submit" name="increment" value="Like">
</form>
<form class="decrement" action="details.php" method="POST">
	<input type="hidden" name="id_to_decrement" value="<?php echo $id; ?>">
	<input type="submit" name="decrement" value="Dislike">
</form>

<!-- DELETE FORM -->
<form class="delete" action="details.php" method="POST">
	<input type="hidden" name="id_to_delete" value="<?php echo $id; ?>">
	<input type="submit" name="delete" value="Delete">
</form>

<div class="points"></div>
<div class="dauer"></div>
<div class="art"></div>
<?php include('templates/footer.php'); ?>

</html>