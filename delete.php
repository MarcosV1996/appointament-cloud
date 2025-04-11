<?php
require 'db_connect.php';

$stmt = $conn->prepare("DELETE FROM agendamentos WHERE id = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
header("Location: index.php");
exit;
?>