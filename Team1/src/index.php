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
    <div class="logo-container">
        <img src="logo.png" alt="Notizy Logo" class="logo">
    </div>

    <form action="speichern.php" method="POST">
        <label for="userText">Geben Sie Ihren Text ein:</label>
        <input type="text" id="userText" name="userText" placeholder="Hier Text eingeben">
        <input type="submit" id="safe" name="speichern" value="Speichern">
    </form>

    <div id="notizen">
        <?php
        $db = new mysqli('localhost', 'root', '', 'team1_notizy');
        $result = $db->query("SELECT * FROM notizen ORDER BY id ASC");
        
        while ($row = $result->fetch_assoc()) {
            echo "<div class='notiz-container'>";
            // Normaler Anzeigemodus
            echo "<div class='notiz-anzeige' id='anzeige_{$row['id']}'>";
            echo "<p>" . htmlspecialchars($row['notiz']) . "</p>";
            echo "<div class='button-container'>";
            echo "<button onclick='bearbeiten({$row['id']})' class='edit-btn'>Bearbeiten</button>";
            echo "<form method='POST' action='loeschen.php' style='display: inline;'>";
            echo "<button type='submit' name='delete' value='{$row['id']}' class='delete-btn'>Löschen</button>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
            
            // Bearbeitungsmodus (standardmäßig versteckt)
            echo "<div class='notiz-bearbeiten' id='bearbeiten_{$row['id']}' style='display:none;'>";
            echo "<form method='POST' action='bearbeiten.php'>";  // Hier wurde die action hinzugefügt
            echo "<input type='text' name='editText' value='" . htmlspecialchars($row['notiz']) . "'>";
            echo "<input type='hidden' name='edit' value='{$row['id']}'>";
            echo "<div class='button-container'>";
            echo "<button type='submit' class='save-btn'>Speichern</button>";
            echo "<button type='button' onclick='abbrechen({$row['id']})' class='cancel-btn'>Abbrechen</button>";
            echo "</div>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
        }
        $db->close();
        ?>
    </div>

    <script>
    function bearbeiten(id) {
        document.getElementById('anzeige_' + id).style.display = 'none';
        document.getElementById('bearbeiten_' + id).style.display = 'block';
    }

    function abbrechen(id) {
        document.getElementById('anzeige_' + id).style.display = 'block';
        document.getElementById('bearbeiten_' + id).style.display = 'none';
    }
    </script>
</body>
</html>