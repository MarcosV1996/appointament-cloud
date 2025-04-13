<?php
require 'db_connect.php';
require 'helpers.php'; 

try {
    $stmt = $conn->query("SELECT * FROM appointments ORDER BY appointment_date DESC");
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Agendamentos</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="container header-content">
            <img src="assets/logo.png" alt="Logo" class="logo">
            <h1>Sistema de Agendamentos</h1>
        </div>
    </header>

    <main class="container">
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2>Lista de Agendamentos</h2>
                <a href="create.php" class="btn btn-success">
                    <i class="fas fa-plus"></i> Novo Agendamento
                </a>
            </div>

            <?php if(empty($appointments)): ?>
                <p>Nenhum agendamento encontrado.</p>
            <?php else: ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Data/Hora</th>
                                <th>Serviço</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($appointments as $appt): ?>
                            <tr>
                                <td><?= htmlspecialchars($appt['client_name']) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($appt['appointment_date'])) ?></td>
                                <td><?= traduzirServico($appt['service_type']) ?></td>
                                <td>
                                    <span class="status-badge <?= strtolower($appt['status']) ?>">
                                        <?= traduzirStatus($appt['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="edit.php?id=<?= $appt['id'] ?>" class="btn btn-secondary">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <a href="delete.php?id=<?= $appt['id'] ?>" 
                                       class="btn btn-danger" 
                                       onclick="return confirm('Tem certeza que deseja excluir este agendamento?')">
                                        <i class="fas fa-trash"></i> Excluir
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>Sistema de Agendamentos &copy; <?= date('Y') ?></p>
        </div>
    </footer>
</body>
</html>