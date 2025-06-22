<?php
include 'db_connect.php';

// Получаем список клиентов для выпадающего списка
$clients = $conn->query("SELECT id, name FROM clients")->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $client_id = $_POST['client_id'];
    $service = $_POST['service'];
    $status = $_POST['status'];
    
    $sql = "INSERT INTO projects (title, client_id, service, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siss", $title, $client_id, $service, $status);
    $stmt->execute();
    
    header("Location: projects.php");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить проект</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Добавить проект</h2>
    <form method="POST" id="projectForm" novalidate>
    <div class="mb-3">
        <label class="form-label">Название проекта*</label>
        <input type="text" name="title" class="form-control" required minlength="3" maxlength="100">
        <div class="invalid-feedback">Название проекта должно содержать от 3 до 100 символов.</div>
    </div>
    <div class="mb-3">
        <label class="form-label">Клиент*</label>
        <select name="client_id" class="form-select" required>
            <option value="">Выберите клиента</option>
            <?php foreach ($clients as $client): ?>
                <option value="<?= $client['id'] ?>"><?= htmlspecialchars($client['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <div class="invalid-feedback">Пожалуйста, выберите клиента.</div>
    </div>
    <!-- Остальные поля остаются без изменений -->
    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>
</div>
<script>
// Валидация формы на стороне клиента
document.getElementById('projectForm').addEventListener('submit', function(event) {
    if (!this.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
    }
    this.classList.add('was-validated');
}, false);
</body>
</html>