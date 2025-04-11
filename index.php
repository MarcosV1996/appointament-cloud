<?php
require 'db_connect.php';

$query = "SELECT * FROM agendamentos ORDER BY data_agendamento DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agendamentos</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>Lista de Agendamentos</h1>
    <table>
        <tr>
            <th>Nome</th>
            <th>Data</th>
            <th>Tipo</th>
            <th>Ações</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['nome_acolhido']) ?></td>
            <td><?= date('d/m/Y H:i', strtotime($row['data_agendamento'])) ?></td>
            <td><?= ucfirst($row['tipo_atendimento']) ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>">Editar</a>
                <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Confirmar exclusão?')">Excluir</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="create.php">Novo Agendamento</a>
</body>
</html>