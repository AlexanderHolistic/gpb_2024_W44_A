<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notizy</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
    <h1><big>N</big><small>OTIZ</small><big>Y</big></h1>

    <?php
    $db = new mysqli('localhost', 'root', '', 'team1_notizy');

    if (isset($_POST['speichern'])) {
        $notiz = $db->real_escape_string($_POST['userText']);
        $db->query("INSERT INTO notizen (notiz) VALUES ('$notiz')");
    }
    ?>

    <br>
    <br>
    <form method="POST">
        <label for="userText">Geben Sie Ihren Text ein:</label>
        <input type="text" id="userText" name="userText" placeholder="Hier Text eingeben">
        <input type="submit" id="safe" name="speichern" value="Speichern" src='save_disk.png'>
    </form>

    <div id="notizen">
        <?php
        $result = $db->query("SELECT * FROM notizen ORDER BY id ASC");
        while ($row = $result->fetch_assoc()) {
            echo "<p>" . htmlspecialchars($row['notiz']) . "</p>";
        }
        $db->close();
        ?>
    </div>

</body>
</html>