<?php
require 'db_connect.php';

// Busca o registro
$stmt = $conn->prepare("SELECT * FROM agendamentos WHERE id = ?");
$stmt->bind_param("i", $_GET['id']);
$stmt->execute();
$agendamento = $stmt->get_result()->fetch_assoc();

// Atualização
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("UPDATE agendamentos SET nome_acolhido=?, data_agendamento=?, tipo_atendimento=? WHERE id=?");
    $stmt->bind_param("sssi", $_POST['nome'], $_POST['data'], $_POST['tipo'], $_POST['id']);
    $stmt->execute();
    header("Location: index.php");
    exit;
}
?>

<!-- Formulário preenchido -->
<form method="POST">
    <input type="hidden" name="id" value="<?= $agendamento['id'] ?>">
    <input type="text" name="nome" value="<?= htmlspecialchars($agendamento['nome_acolhido']) ?>" required>
    <input type="datetime-local" name="data" value="<?= date('Y-m-d\TH:i', strtotime($agendamento['data_agendamento'])) ?>" required>
    <select name="tipo" required>
        <option value="social" <?= $agendamento['tipo_atendimento'] == 'social' ? 'selected' : '' ?>>Social</option>
        <option value="psicologico" <?= $agendamento['tipo_atendimento'] == 'psicologico' ? 'selected' : '' ?>>Psicológico</option>
    </select>
    <button type="submit">Atualizar</button>
</form>