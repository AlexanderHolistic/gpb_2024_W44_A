<?php
$db = new mysqli('172.16.1.49', 'team1', 'team1!', 'team1_notizy');
// Speichern einer neuen Notiz
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['speichern'])) {
    $notiz = $db->real_escape_string($_POST['userText']);
    $db->query("INSERT INTO notizen (notiz) VALUES ('$notiz')");
}
// Löschen einer Notiz
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['loeschen'])) {
    $id = (int)$_POST['loeschen'];
    $db->query("DELETE FROM notizen WHERE id = $id");
}
// Bearbeiten einer Notiz
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bearbeiten_speichern'])) {
    $id = (int)$_POST['notiz_id'];
    $notiz = $db->real_escape_string($_POST['editText']);
    $db->query("UPDATE notizen SET notiz = '$notiz' WHERE id = $id");
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Notizy</title>
</head>
<body style="font-family: Arial; background-color: #87CEEB; margin: 0; padding: 0;">
    <h1 style="text-align: center; color: #333; padding: 20px 0; margin: 0; background-color: white;">NotizY</h1>
    <div style="display: flex; margin: 20px; gap: 20px; height: calc(100vh - 100px);">
        <!-- Linke Spalte: Liste der Notizen -->
        <div style="flex: 1; background: white; padding: 20px; overflow-y: auto;">
            <h2>Notizen Liste</h2>
            <?php
            $result = $db->query("SELECT * FROM notizen ORDER BY id DESC");
            
            while ($row = $result->fetch_assoc()) {
                echo "<div style='border-bottom: 1px solid #eee; padding: 10px 0;'>";
                echo "<p style='margin: 0 0 10px 0;'>" . htmlspecialchars(substr($row['notiz'], 0, 100)) . "...</p>";
                echo "<div style='display: flex; gap: 10px;'>";
                echo "<form method='POST' style='display: inline;'>";
                echo "<button type='submit' name='bearbeiten' value='" . $row['id'] . "' style='background: #2196F3; color: white; padding: 5px 10px; border: none; cursor: pointer;'>Bearbeiten</button>";
                echo "</form>";
                
                echo "<form method='POST' style='display: inline;'>";
                echo "<button type='submit' name='loeschen' value='" . $row['id'] . "' style='background: #f44336; color: white; padding: 5px 10px; border: none; cursor: pointer;'>Löschen</button>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
            }
            ?>
        </div>
        <!-- Vertikale Linie -->
        <div style="width: 1px; background-color: #ccc;"></div>
        <!-- Rechte Spalte: Bearbeiten/Erstellen -->
        <div style="flex: 2; background: white; padding: 20px;">
            <?php
            // Wenn eine Notiz bearbeitet wird
            if (isset($_POST['bearbeiten'])) {
                $id = (int)$_POST['bearbeiten'];
                $edit_result = $db->query("SELECT * FROM notizen WHERE id = $id");
                $edit_row = $edit_result->fetch_assoc();
                
                echo "<h2>Notiz bearbeiten</h2>";
                echo "<form method='POST'>";
                echo "<textarea name='editText' style='width: 100%; height: 300px; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd;'>" 
                     . htmlspecialchars($edit_row['notiz']) . "</textarea><br>";
                echo "<input type='hidden' name='notiz_id' value='" . $id . "'>";
                echo "<button type='submit' name='bearbeiten_speichern' style='background: #4CAF50; color: white; padding: 10px 20px; border: none; cursor: pointer;'>Speichern</button>";
                echo "</form>";
            } else {
                // Formular für neue Notiz
                echo "<h2>Neue Notiz erstellen</h2>";
                echo "<form method='POST'>";
                echo "<textarea name='userText' style='width: 100%; height: 300px; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd;'></textarea><br>";
                echo "<button type='submit' name='speichern' style='background: #4CAF50; color: white; padding: 10px 20px; border: none; cursor: pointer;'>Speichern</button>";
                echo "</form>";
            }
            ?>
        </div>
    </div>
</body>
</html>
<?php $db->close(); ?>
