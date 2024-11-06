<?php
$db = new mysqli('localhost', 'root', '', 'team1_notizy');

if (isset($_POST['edit']) && isset($_POST['editText'])) {
    $id = (int)$_POST['edit'];
    $neuer_text = $db->real_escape_string($_POST['editText']);
    $sql = "UPDATE notizen SET notiz = '$neuer_text' WHERE id = $id";
    $db->query($sql);
}

$db->close();
header('Location: index.php');
?> 