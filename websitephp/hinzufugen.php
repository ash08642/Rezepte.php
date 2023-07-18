<?php

	// Verbindung zur Datenbank
	$conn = mysqli_connect('localhost', 'admin123', 'test123', 'recipies');

	// Verbindung prüfen
	if(!$conn){
		echo 'Connection error: '. mysqli_connect_error();
	}

$email = $title = $ingredients = $kochzeit = $schritte = '';
$errors = array('email' => '', 'title' => '', 'catogorie' => '', 'ingredients' => '', 'kochzeit' => '', 'time' => '', 'schritte' => '');

if(isset($_POST['submit'])){

    // email validieren
		if(empty($_POST['email'])){
			$errors['email'] = 'An email is required';
		} else{
			$email = $_POST['email'];
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$errors['email'] = 'Email must be a valid email address';
			}
		}

		// title validieren
		if(empty($_POST['title'])){
			$errors['title'] = 'A title is required';
		} else{
			$title = $_POST['title'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
				$errors['title'] = 'Title must be letters and spaces only';
			}
		}

		// catogorie  validieren
		if(empty($_POST['catogorie'])){
			$errors['catogorie'] = 'catogorie is required';
		} else{
			$catogorie = $_POST['catogorie'];
		}

		// ingredients validieren
		if(empty($_POST['ingredients'])){
			$errors['ingredients'] = 'At least one ingredient is required';
		} else{
			$ingredients = $_POST['ingredients'];
			if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)){
				$errors['ingredients'] = 'Ingredients must be a comma separated list';
			}
		}

        // koch zeit validieren
		if(empty($_POST['kochzeit'])){
			$errors['kochzeit'] = 'cooking time required';
		} else{
			$kochzeit = $_POST['kochzeit'];
		}

		// time validieren
		if(empty($_POST['time'])){
			$errors['time'] = 'cooking time required';
		} else{
			$kochzeit = $_POST['time'];
		}

		// schritte validieren
		if(empty($_POST['schritte'])){
			$errors['schritte'] = 'steps required';
		} else{
			$schritte = $_POST['schritte'];
		}

		// gibt es errors?
		if(array_filter($errors)){
			//echo 'errors in form';
		} else {
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$title = mysqli_real_escape_string($conn, $_POST['title']);
			$ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
			$catagorie = mysqli_real_escape_string($conn, $_POST['catogorie']);
			$kochzeit = mysqli_real_escape_string($conn, $_POST['kochzeit']);
			$time = mysqli_real_escape_string($conn, $_POST['time']);
			$schritte = mysqli_real_escape_string($conn, $_POST['schritte']);
			$votes = 0;
			// sql querie erstellen
			$sql = "INSERT INTO gerichte(email, title, catogori, ingredients, time, steps, votes) VALUES('$email','$title','$catogorie','$ingredients',$kochzeit, '$schritte', $votes)";

			// in der Datenbank speichern und prüfen, ob der Vorgang erfolgreich wars
			if(mysqli_query($conn, $sql)){
				// success
				header('Location: index.php');
			} else {
				echo 'query error: '. mysqli_error($conn);
			}
		}
}

?>
<!DOCTYPE html>
<html lang="en">

    <?php include('templates/header.php'); ?>
		<form class="add-form" action="hinzufugen.php" method="POST">
			<div class="errors">
				<?php echo $errors['email']; ?>
			</div>
			<label class="form-label">Your Email</label><br>
			<input class="form-input" type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
			<div class="errors">
				<?php echo $errors['title']; ?>
			</div>
			<label class="form-label">Title</label><br>
			<input class="form-input" type="text" name="title" value="<?php echo htmlspecialchars($title) ?>"><br>
			<div class="errors">
				<?php echo $errors['catogorie']; ?>
			</div>
			<label class="form-label">Catagorie</label><br>
			<div class="cat">
				<input class="radio-input" type="radio" id="breakfast" value ="breakfast" name="catogorie" onclick="breakfastSelect()"><label id="breakfast1"for="breakfast">breakfast</label>
				<input class="radio-input" type="radio" id="snack" value ="snack" name="catogorie" onclick="snackSelect()"><label id="snack1" for="snack">snack</label>
				<input class="radio-input" type="radio" id="dinner" value ="dinner" name="catogorie" onclick="dinnerSelect()"><label id="dinner1" for="dinner">dinner</label>
				<input class="radio-input" type="radio" id="dessert" value ="dessert" name="catogorie" onclick="dessertSelect()"><label id="dessert1" for="dessert">dessert</label>
				<input class="radio-input" type="radio" id="other" value ="other" name="catogorie" onclick="otherSelect()"><label id="other1" for="other">other</label>
			</div><br>
			<div class="errors">
				<?php echo $errors['ingredients']; ?>
			</div>
			<label class="form-label">Ingredients (comma separated)</label><br>
			<input class="form-input" type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients) ?>">
            <div class="errors">
				<?php echo $errors['kochzeit']; ?>
			</div>
			<div>
				<label class="form-label">Koch Zeit</label>
			</div>
			<input class="form-input" type="number" name="kochzeit" value="<?php echo htmlspecialchars($kochzeit) ?>"><br>
			<input class="radio-input" type="radio" id="minutes" value ="minutes" name="time" onclick="minutesSelect()"><label id="minutes1" for="minutes">minutes</label>
			<input class="radio-input" type="radio" id="hours" value ="hours" name="time" onclick="hoursSelect()"><label id="hours1" for="hours">hours</label><br><br>
            <div class="errors"><?php echo $errors['schritte']; ?></div>
			<label class="form-label">Rezept Schritte</label><br>
			<textarea class="form-input" type="text" rows=5 name="schritte" value="<?php echo htmlspecialchars($schritte) ?>"></textarea><br>
			<input class="submit" type="submit" name="submit" value="Submit">
			
		</form>
	<?php include('templates/footer.php'); ?>
</body>
</html>