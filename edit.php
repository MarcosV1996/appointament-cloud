<?php
session_start();
require 'db_connect.php';

// Get existing data
try {
    $stmt = $conn->prepare("SELECT * FROM appointments WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $appointment = $stmt->fetch();

    if(!$appointment) {
        $_SESSION['message'] = "Agendamento não encontrado!";
        $_SESSION['msg_type'] = "danger";
        header("Location: index.php");
        exit;
    }
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Update
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $stmt = $conn->prepare("UPDATE appointments SET 
            client_name = ?,
            appointment_date = ?,
            service_type = ?,
            phone = ?,
            email = ?,
            status = ?,
            notes = ?
            WHERE id = ?");
        
        $stmt->execute([
            $_POST['client_name'],
            $_POST['appointment_date'],
            $_POST['service_type'],
            $_POST['phone'],
            $_POST['email'],
            $_POST['status'],
            $_POST['notes'],
            $_POST['id']
        ]);
        
        $_SESSION['message'] = "Agendamento atualizado com sucesso!";
        $_SESSION['msg_type'] = "success";
        header("Location: index.php");
        exit;
    } catch(PDOException $e) {
        $_SESSION['message'] = "Erro ao atualizar agendamento: " . $e->getMessage();
        $_SESSION['msg_type'] = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Agendamento</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="container header-content">
            <img src="assets/logo.png" alt="Logo" class="logo">
            <h1>Editar Agendamento</h1>
        </div>
    </header>

    <main class="container">
        <div class="card">
            <form method="POST">
                <input type="hidden" name="id" value="<?= $appointment['id'] ?>">

                <div class="form-group">
                    <label for="client_name">Nome do Cliente</label>
                    <input type="text" id="client_name" name="client_name" class="form-control" 
                           value="<?= htmlspecialchars($appointment['client_name']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="appointment_date">Data e Hora</label>
                    <input type="datetime-local" id="appointment_date" name="appointment_date" class="form-control"
                           value="<?= date('Y-m-d\TH:i', strtotime($appointment['appointment_date'])) ?>" required>
                </div>

                <div class="form-group">
                    <label for="service_type">Tipo de Serviço</label>
                    <select id="service_type" name="service_type" class="form-control" required>
                        <option value="social" <?= $appointment['service_type'] == 'social' ? 'selected' : '' ?>>Social</option>
                        <option value="psychological" <?= $appointment['service_type'] == 'psychological' ? 'selected' : '' ?>>Psicológico</option>
                        <option value="legal" <?= $appointment['service_type'] == 'legal' ? 'selected' : '' ?>>Jurídico</option>
                        <option value="medical" <?= $appointment['service_type'] == 'medical' ? 'selected' : '' ?>>Médico</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="phone">Telefone</label>
                    <input type="tel" id="phone" name="phone" class="form-control" 
                           value="<?= htmlspecialchars($appointment['phone'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" class="form-control"
                           value="<?= htmlspecialchars($appointment['email'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="scheduled" <?= $appointment['status'] == 'scheduled' ? 'selected' : '' ?>>Agendado</option>
                        <option value="completed" <?= $appointment['status'] == 'completed' ? 'selected' : '' ?>>Concluído</option>
                        <option value="cancelled" <?= $appointment['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelado</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="notes">Observações</label>
                    <textarea id="notes" name="notes" class="form-control"><?= htmlspecialchars($appointment['notes'] ?? '') ?></textarea>
                </div>

                <div class="form-group" style="margin-top: 30px;">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Atualizar Agendamento
                    </button>
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>Sistema de Agendamentos &copy; <?= date('Y') ?></p>
        </div>
    </footer>
</body>
</html>