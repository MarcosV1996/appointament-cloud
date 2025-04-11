<?php
require 'db_connect.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("INSERT INTO agendamentos (nome_acolhido, data_agendamento, tipo_atendimento) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $_POST['nome'], $_POST['data'], $_POST['tipo']);
    $stmt->execute();
    header("Location: index.php");
    exit;
}
?>

<!-- Formulário HTML -->
<form method="POST">
    <input type="text" name="nome" placeholder="Nome" required>
    <input type="datetime-local" name="data" required>
    <select name="tipo" required>
        <option value="social">Social</option>
        <option value="psicologico">Psicológico</option>
    </select>
    <button type="submit">Salvar</button>
</form>