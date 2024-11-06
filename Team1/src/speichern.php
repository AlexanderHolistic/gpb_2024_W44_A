<?php
$db = new mysqli('localhost', 'root', '', 'team1_notizy');

if (isset($_POST['speichern'])) {
    $notiz = $db->real_escape_string($_POST['userText']);
    $db->query("INSERT INTO notizen (notiz) VALUES ('$notiz')");
}

$db->close();
header('Location: index.php');
?> 