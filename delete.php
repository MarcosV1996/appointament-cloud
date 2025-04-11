<?php
session_start();
require 'db_connect.php';

if(isset($_GET['id'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM appointments WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        
        $_SESSION['message'] = "Agendamento excluído com sucesso!";
        $_SESSION['msg_type'] = "success";
    } catch(PDOException $e) {
        $_SESSION['message'] = "Erro ao excluir agendamento: " . $e->getMessage();
        $_SESSION['msg_type'] = "danger";
    }
}

header("Location: index.php");
exit;
?>