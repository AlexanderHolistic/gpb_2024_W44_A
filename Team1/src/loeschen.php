<?php
$db = new mysqli('localhost', 'root', '', 'team1_notizy');

if (isset($_POST['delete'])) {
    $id = (int)$_POST['delete'];
    $db->query("DELETE FROM notizen WHERE id = $id");
}

$db->close();
header('Location: index.php');
?> 