<?php
$db = new mysqli('localhost', 'root', '', 'team1_notizy');

if (isset($_POST['edit'])) {
    $id = (int)$_POST['edit'];
    $neuer_text = $db->real_escape_string($_POST['editText']);
    $db->query("UPDATE notizen SET notiz = '$neuer_text' WHERE id = $id");
}

$db->close();
header('Location: index.php');
?> 