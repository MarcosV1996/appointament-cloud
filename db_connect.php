<?php
$host = "IP_DB";
$user = "app_acolhimento";
$pass = "123";
$db   = "acolhimento_db";

$conn = new mysqli($host, $user, $pass, $db);

if($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}
?>