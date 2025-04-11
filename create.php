<?php
require 'db_connect.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $stmt = $conn->prepare("INSERT INTO appointments 
            (client_name, appointment_date, service_type, phone, email, status, notes) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $_POST['client_name'],
            $_POST['appointment_date'],
            $_POST['service_type'],
            $_POST['phone'],
            $_POST['email'],
            'scheduled',
            $_POST['notes']
        ]);
        
        $_SESSION['message'] = "Agendamento criado com sucesso!";
        $_SESSION['msg_type'] = "success";
        header("Location: index.php");
        exit;
    } catch(PDOException $e) {
        $_SESSION['message'] = "Erro ao criar agendamento: " . $e->getMessage();
        $_SESSION['msg_type'] = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Agendamento</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="container header-content">
            <img src="assets/logo.png" alt="Logo" class="logo">
            <h1>Novo Agendamento</h1>
        </div>
    </header>

    <main class="container">
        <div class="card">
            <form method="POST">
                <div class="form-group">
                    <label for="client_name">Nome do Cliente</label>
                    <input type="text" id="client_name" name="client_name" class="form-control" placeholder="Nome completo" required>
                </div>

                <div class="form-group">
                    <label for="appointment_date">Data e Hora</label>
                    <input type="datetime-local" id="appointment_date" name="appointment_date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="service_type">Tipo de Serviço</label>
                    <select id="service_type" name="service_type" class="form-control" required>
                        <option value="">Selecione...</option>
                        <option value="social">Social</option>
                        <option value="psychological">Psicológico</option>
                        <option value="legal">Jurídico</option>
                        <option value="medical">Médico</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="phone">Telefone</label>
                    <input type="tel" id="phone" name="phone" class="form-control" placeholder="(00) 00000-0000">
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="email@exemplo.com">
                </div>

                <div class="form-group">
                    <label for="notes">Observações</label>
                    <textarea id="notes" name="notes" class="form-control" placeholder="Informações adicionais..."></textarea>
                </div>

                <div class="form-group" style="margin-top: 30px;">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Salvar Agendamento
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