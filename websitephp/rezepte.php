<?php

// connect to the database
$conn = mysqli_connect('localhost', 'admin123', 'test123', 'recipies');

// Verbindung prüfen
if(!$conn){
    echo 'Connection error: '. mysqli_connect_error();
}

// Abfrage für alle Gerichte schreiben
$sql = 'SELECT title, ingredients, id, time, catogori, votes FROM gerichte ORDER BY datecreated';

// die Ergebnismenge (Set of Zeilen) abrufen
$result = mysqli_query($conn, $sql);

// die resultierenden Zeilen als Array abrufen
$dishes = mysqli_fetch_all($result, MYSQLI_ASSOC);

// das $result aus dem Speicher freigeben
mysqli_free_result($result);

// verbindung schliessen
mysqli_close($conn);

?>
<!DOCTYPE html>
<html lang="en">

    <?php include('templates/header.php'); ?>
    <h2 class="headd">Neueste Rezepte</h2>
    <?php foreach($dishes as $dish): ?>

        <div class="recepies">
            <div class="title">
            <h3><?php echo htmlspecialchars($dish['title']); ?></h6></div>
            <div class="cato"><h4><?php echo $dish['catogori']; ?></h4></div>
            <div class="minutes"><h4><?php echo $dish['time']; ?> Minutes</h4></div>
            <div class="votes"><h4>Votes: <?php echo $dish['votes']; ?></h4></div>
            <div class="weiter"><a class="more" href="details.php?id=<?php echo $dish['id'] ?>">Weiter</a></div>
        </div>
                      
    <?php endforeach; ?>
    <?php include('templates/footer.php'); ?>
</body>
</html>